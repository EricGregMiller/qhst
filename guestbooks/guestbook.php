<?
#################################################################################################
#
#  project           	: phpBook
#  filename          	: guestbook.php
#  last modified by  	: Erich Fuchs
#  e-mail            	: office@smartisoft.com
#  purpose           	: Guestbook
#
#################################################################################################

$proctime_start=microtime();

#  Include Configs & Variables
#################################################################################################

require ("config.php");

if (strstr (getenv('HTTP_USER_AGENT'), 'MSIE')) { // Browser Detection
    $in_field_size="50";
    $text_field_size="31";
} else {
    $in_field_size="30";
    $text_field_size="24";
}


#  Connect DB
#################################################################################################
mysql_connect($server, $db_user, $db_pass) or died("Database Connect Error");


#  Process
#################################################################################################

if ($action=="submit") {					// Add an action


  if (!$in && !$delid && !$delcommentid && !$commentid) {
    header("Location: $PHP_SELF");
    exit;
  } elseif ($delid && $admin==$adminpass) {
    mysql_db_query($database, "DELETE FROM guestbook WHERE id='$delid'") or died("Database Query Error");
    header("Location: $PHP_SELF?offset=$offset&poffset=$poffset&admin=$admin");
    exit;
  } elseif ($delcommentid && $admin==$adminpass) {
    mysql_db_query($database, "UPDATE guestbook SET comment='' where id='$delcommentid'") or died("Database Query Error");
    header("Location: $PHP_SELF?offset=$offset&poffset=$poffset&admin=$admin");
    exit;
  } elseif ($commentid && $admin==$adminpass) {
    if(isset($comment)){
      $action=changed;
      mysql_db_query($database, "UPDATE guestbook SET comment='".encode_msg($comment)."' where id='$commentid'") or died("Database Query Error");
	  } else {
      $action="";
    }
    header("Location: $PHP_SELF?commentid=$commentid&action=$action&offset=$offset&poffset=$poffset&admin=$admin");
    exit;
  } else {
    if (isbanned()) {
	header("Location: $PHP_SELF");
        exit;
    }
    $add_date=time();
    $result=mysql_db_query($database, "SELECT * FROM guestbook WHERE ip='$REMOTE_ADDR' AND timestamp>($add_date-(60*$timelimit))") or died("Database Query Error");
    $query=mysql_fetch_array($result);
    if ($query) {
	header("Location: $PHP_SELF");
        exit;
    }
    $in = strip_array($in);
    $in['message'] = encode_msg($in['message']);    // Add SQL compatibilty & Smilie Convert
    $in['http']    = str_replace("http://", "", $in['http']);   // Remove http:// from URLs
    if ($in['name'] == "") { died("<html><head><title>$guestbook_head</title>$languagemetatag</head><body><center>$name_empty</center></body></html>"); }
    if ($in['icq'] != "" && ($in['icq'] < 1000 || $in['icq'] > 999999999)) { died("<html><head><title>$guestbook_head</title>$languagemetatag</head><body><center>$icq_wrong</center></body></html>"); }
    if (!eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}$",$in['email']) && $in['email'] != "") { died("<html><head><title>$guestbook_head</title>$languagemetatag</head><body><center>$non_valid_email</center></body></html>"); }
    if (strlen($in['message']) < $limit["0"] || strlen($in['message']) > $limit["1"]) { died("<html><head><title>$guestbook_head</title>$languagemetatag</head><body><center>$message_incorrect $limit[0] $and $limit[1] $characters.</center></body></html>"); }
    if ($in['email'] == "") { $in['email'] = "none"; }
    if ($in['icq'] == "") { $in['icq'] = 0; }
    if ($in['http'] == "") { $in['http'] = "none"; }
    if ($in['location'] == "0") { $in['location'] = "none"; }
    $in['browser'] = $HTTP_USER_AGENT;
    mysql_db_query($database, "INSERT INTO guestbook (name, email, http, icq, message, timestamp, ip, location, browser)
    VALUES('$in[name]', '$in[email]','$in[http]','$in[icq]','$in[message]','$add_date', '$REMOTE_ADDR','$in[location]','$in[browser]')")
    or died("Database Query Error");
    if ($gb_notify) {
        @mail("$gb_notify","$gb_notifysubj","$notify_text $in[name]\n\n".censor_msg($in[message]),"From: $gb_notify");
    }
    if ($timelimit) {
        setcookie("phpbookcookie","$guestbook_head", time()+(60*$timelimit),"/");
    }
    if ($admin) {$adminlink="?admin=$admin";}
    header("Location: $PHP_SELF$adminlink");
    exit;
  }

} else {	         				// Show the entries #####################

  #  Header
  #################################################################################################

  echo "<html>\n";
  echo " <head>\n";
  echo "  <title>$guestbook_head</title>\n";
  echo "  <link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">\n";
  echo "  $languagemetatag\n";
  echo "  <meta name=\"robots\" content=\"index, nofollow\">\n";
  echo "  <meta name=\"revisit-after\" content=\"20 days\">\n";
  echo "    <script language=\"Javascript\">\n";
  echo "       function floodprotect() {\n";
  echo "   	alert(\"$banned\");\n";
  echo "       }\n";
  echo "    </script>\n";
  echo " </head>\n";
  echo "<body>\n";

  #  The Main-Section
  #################################################################################################

  echo" <table align=\"$table_align\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" margin=1 width=\"$table_width\" height=\"$table_height\">\n";
  echo"   <tr>\n";
  echo"    <td class=\"class1\">\n";
  echo"      <table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=\"100%\" height=\"$table_height\">\n";
  echo"       <tr>\n";
  echo"        <td class=\"class2\">\n";
  if ($action=="add") {
    echo "	    <table>\n";
    echo "            <tr>\n";
    echo "             <td width=\"1%\">\n";
    echo "              <div class=\"mainheader\">$guestbook_head</div>\n";
    echo "             </td>\n";
    echo "             <td>\n";
    echo "              <div class=\"mainmenu\">$gb_link1head</div></div>\n";
    echo "             </td>\n";
    echo "            </tr>\n";
    echo "           </table>\n";
    echo "	<div class=\"maintext\">\n";
    echo " 	<br>\n";
    echo " 	<table align=\"center\">\n";
    echo " 	<Form action=\"$PHP_SELF?action=submit\" method=\"post\">\n";
    echo "     	<tr>\n";
    echo "      <td><div class=\"maininputleft\">$gbadd_name</div></td>\n";
    echo "      <td><input type=\"text\" name=\"in[name]\" size=\"$in_field_size\" maxlength=\"35\"></td>\n";
    echo "     	</tr>\n";
    echo "     	<tr>\n";
    echo "      <td><div class=\"maininputleft\">$gbadd_location</div></td>\n";
    if ($location_text) {
	echo "  <td><input type=\"text\" name=\"in[location]\" size=\"$in_field_size\" maxlength=\"35\"></td>\n";
    } else {
	echo "	<td class=\"class_add2\"><select name=\"in[location]\">\n";
	echo "	<option value=\"0\" SELECTED>$location_sel</option>\n";
	include ("$loc_dir/$locations");
	echo "	</select></td>\n";
    }
    echo "     </tr>\n";
    echo "     <tr>\n";
    echo "             <td><div class=\"maininputleft\">$gbadd_email</div></td>\n";
    echo "             <td><input type=\"text\" name=\"in[email]\" size=\"$in_field_size\" maxlength=\"35\"></td>\n";
    echo "     </tr>\n";
    echo "     <tr>\n";
    echo "             <td><div class=\"maininputleft\">$gbadd_icq</div></td>\n";
    echo "             <td><input type=\"text\" name=\"in[icq]\" size=\"$in_field_size\" value=\"\" maxlength=\"12\"></td>\n";
    echo "     </tr>\n";
    echo "     <tr>\n";
    echo "             <td><div class=\"maininputleft\">$gbadd_url</div></td>\n";
    echo "             <td><input type=\"text\" name=\"in[http]\" size=\"$in_field_size\" maxlength=\"60\" value=\"http://\"></td>\n";
    echo "     </tr>\n";
    echo "     <tr>\n";
    echo "             <td valign=\"top\"><div class=\"maininputleft\">$gbadd_msg<br><br>\n";
    echo "		<div class=\"xsmallleft\"><a href=\"smiliehelp.php\"
			    onClick='enterWindow=window.open(\"smiliehelp.php\",\"Smilie\",
			    \"width=300,height=450,top=100,left=100,scrollbars=yes\"); return false'
			    onmouseover=\"window.status='$smiliehelp'; return true;\"
			    onmouseout=\"window.status=''; return true;\">$smiley_help</a></div>\n";
    echo "		<div class=\"xsmallleft\"><a href=\"urlcodehelp.php\"
			    onClick='enterWindow=window.open(\"urlcodehelp.php\",\"URLCode\",
			    \"width=550,height=450,top=100,left=100,scrollbars=yes\"); return false'
			    onmouseover=\"window.status='$urlcodehelp'; return true;\"
			    onmouseout=\"window.status=''; return true;\">$url_code_help</a></div>\n";
    echo "		</div></td>\n";
    echo "             <td><textarea rows=\"8\" name=\"in[message]\" cols=\"$text_field_size\"></textarea></td>\n";
    echo "     </tr>\n";
    echo "     <tr>\n";
    echo "             <td></td>\n";
    echo "             <td><br><input type=\"hidden\" name=\"admin\" value=\"$admin\"><input type=\"submit\" Value=\"$submit\"></td>\n";
    echo "     </tr>\n";
    echo " </table>\n";
    echo " </form>\n";
    echo "           </div>\n";
  } elseif ($action=="admin" && $admin==$adminpass) {
    echo "	    <table>\n";
    echo "            <tr>\n";
    echo "             <td width=\"1%\">\n";
    echo "              <div class=\"mainheader\">$guestbook_head</div>\n";
    echo "             </td>\n";
    echo "             <td>\n";
    echo "              <div class=\"mainmenu\">";
    echo "		<a href=\"$PHP_SELF?admin=$admin\" onmouseover=\"window.status='$gb_link5desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link5</a> || ";
    echo "		$gb_link2head</div>\n";
    echo "             </td>\n";
    echo "            </tr>\n";
    echo "           </table>\n";
    echo "	<div class=\"maintext\">\n";
    echo " 	<br>\n";
    echo "       <a href=\"$PHP_SELF?action=badwords&admin=$admin\" onmouseover=\"window.status='$gb_link3desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link3</a><br>\n";
    echo "       <a href=\"$PHP_SELF?action=banned_ips&admin=$admin\" onmouseover=\"window.status='$gb_link4desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link4</a>\n";
    echo "      </div>\n";
  } elseif ($action == "badwords" && $admin==$adminpass) {
    echo "	    <table>\n";
    echo "            <tr>\n";
    echo "             <td width=\"1%\">\n";
    echo "              <div class=\"mainheader\">$guestbook_head</div>\n";
    echo "             </td>\n";
    echo "             <td>\n";
    echo "              <div class=\"mainmenu\">";
    echo "		<a href=\"$PHP_SELF?admin=$admin\" onmouseover=\"window.status='$gb_link5desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link5</a> || ";
    echo "		<a href=\"$PHP_SELF?action=admin&admin=$admin\" onmouseover=\"window.status='$gb_link2desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link2</a> || ";
    echo "		$gb_link3head</div>\n";
    echo "             </td>\n";
    echo "            </tr>\n";
    echo "           </table>\n";
    $count=0;
    $result = mysql_db_query($database, "select * from badwords") or die("Database Query Error");
    echo " <br><table align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\">\n";
    echo "   <tr>\n";
    echo "    <td class=\"class2\">\n";
    echo "      ";
    echo "    </td>\n";
    echo "    <td class=\"class1\" align=\"right\" width=\"90\">\n";
    echo "	<div class=\"smallleft\"><a href=\"$PHP_SELF?action=new_badword&admin=$admin\">New</a></div>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";

    while ($db = mysql_fetch_array($result)) {
        echo " <table align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\">\n";
	echo "   <tr>\n";
        echo "    <td class=\"class1\">\n";
	echo "     <div class=\"smallleft\">$db[badword]</div>";
        echo "    </td>\n";
        echo "    <td class=\"class1\" align=\"right\" width=\"90\">\n";
	echo "	   <div class=\"smallleft\"><a href=\"$PHP_SELF?action=edit_badword&admin=$admin&value=$db[badword]\">Edit</a> || \n";
	echo "	   $menusep<a href=\"$PHP_SELF?action=delete_badword&admin=$admin&value=$db[badword]\">Delete</a></div>\n";
        echo "    </td>\n";
	echo "  </tr>\n";
        echo "</table>\n";
	$count++;
    }
    echo "<div class=\"smallleft\"><br>$count $gb_link3stat<br><br></div>\n";

  } elseif ($action == "edit_badword" || $action == "new_badword" && $admin==$adminpass) {
    echo "	    <table>\n";
    echo "            <tr>\n";
    echo "             <td width=\"1%\">\n";
    echo "              <div class=\"mainheader\">$guestbook_head</div>\n";
    echo "             </td>\n";
    echo "             <td>\n";
    echo "              <div class=\"mainmenu\">";
    echo "		<a href=\"$PHP_SELF?admin=$admin\" onmouseover=\"window.status='$gb_link5desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link5</a> || ";
    echo "		<a href=\"$PHP_SELF?action=admin&admin=$admin\" onmouseover=\"window.status='$gb_link2desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link2</a> || ";
    echo "		$gb_link3head</div>\n";
    echo "             </td>\n";
    echo "            </tr>\n";
    echo "           </table>\n";
    echo "<form action=\"$PHP_SELF\" method=\"GET\">\n";
    echo "<table align=\"center\" width=\"100%\">\n";
    if ($action == "edit_badword") {
	echo "<input type=\"hidden\" name=\"action\" value=\"save_edit_badword\">\n";
    } else {
        echo "<input type=\"hidden\" name=\"action\" value=\"save_new_badword\">\n";
    }
    echo "<input type=\"hidden\" name=\"value\" value=\"$value\">\n";
    echo "<input type=\"hidden\" name=\"admin\" value=\"$admin\">\n";
    echo "<tr>\n";
    echo "<td class=\"classadd1\"><div class=\"maininputleft\">$gb_link3text</div></td>\n";
    echo "<td class=\"classadd2\">\n";
    echo "<input type=text name=\"newvalue\" size=\"25\" maxlength=\"50\" value=\"$value\"></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td class=\"classadd2\"></td>\n";
    echo "<td class=\"classadd2\"><br><input type=submit value=Submit></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</form>\n";

  } elseif ($action == "save_edit_badword" && $admin==$adminpass) {

    $result = mysql_db_query($database, "UPDATE badwords SET badword='$newvalue' WHERE badword='$value'") or die("Database Query Error");
    echo "<script language=javascript>location.replace('$PHP_SELF?action=badwords&admin=$admin');</script>\n";

  } elseif ($action == "save_new_badword" && $admin==$adminpass) {
    $result = mysql_db_query($database, "INSERT INTO badwords (badword) VALUES('$newvalue')") or die("Database Query Error");
    echo "<script language=javascript>location.replace('$PHP_SELF?action=badwords&admin=$admin');</script>\n";

  } elseif ($action == "delete_badword" && $admin==$adminpass) {
    $result = mysql_db_query($database, "DELETE FROM badwords WHERE badword='$value'") or die("Database Query Error");
    echo "<script language=javascript>location.replace('$PHP_SELF?action=badwords&admin=$admin');</script>\n";

  } elseif ($action == "banned_ips" && $admin==$adminpass) {
    echo "	    <table>\n";
    echo "            <tr>\n";
    echo "             <td width=\"1%\">\n";
    echo "              <div class=\"mainheader\">$guestbook_head</div>\n";
    echo "             </td>\n";
    echo "             <td>\n";
    echo "              <div class=\"mainmenu\">";
    echo "		<a href=\"$PHP_SELF?admin=$admin\" onmouseover=\"window.status='$gb_link5desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link5</a> || ";
    echo "		<a href=\"$PHP_SELF?action=admin&admin=$admin\" onmouseover=\"window.status='$gb_link2desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link2</a> || ";
    echo "		$gb_link4head</div>\n";
    echo "             </td>\n";
    echo "            </tr>\n";
    echo "           </table>\n";
    $count=0;
    $result = mysql_db_query($database, "select * from banned_ips") or die("Database Query Error");
    echo " <br><table align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\">\n";
    echo "   <tr>\n";
    echo "    <td class=\"class2\">\n";
    echo "      ";
    echo "    </td>\n";
    echo "    <td class=\"class1\" align=\"right\" width=\"90\">\n";
    echo "	<div class=\"smallleft\"><a href=\"$PHP_SELF?action=new_banned_ip&admin=$admin\">New</a></div>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";

    while ($db = mysql_fetch_array($result)) {
        echo " <table align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\">\n";
	echo "   <tr>\n";
        echo "    <td class=\"class1\">\n";
	echo "     <div class=\"smallleft\">$db[0]</div>";
        echo "    </td>\n";
        echo "    <td class=\"class1\" align=\"right\" width=\"90\">\n";
	echo "	   <div class=\"smallleft\"><a href=\"$PHP_SELF?action=edit_banned_ip&admin=$admin&value=$db[banned_ip]\">Edit</a> || \n";
	echo "	   <a href=\"$PHP_SELF?action=delete_banned_ip&admin=$admin&value=$db[banned_ip]\">Delete</a></div>\n";
        echo "    </td>\n";
	echo "  </tr>\n";
        echo "</table>\n";
	$count++;
    }
    echo "<div class=\"smallleft\"><br>$count $gb_link4stat<br><br></div>\n";

  } elseif ($action == "edit_banned_ip" || $action == "new_banned_ip") {
    echo "	    <table>\n";
    echo "            <tr>\n";
    echo "             <td width=\"1%\">\n";
    echo "              <div class=\"mainheader\">$guestbook_head</div>\n";
    echo "             </td>\n";
    echo "             <td>\n";
    echo "              <div class=\"mainmenu\">";
    echo "		<a href=\"$PHP_SELF?admin=$admin\" onmouseover=\"window.status='$gb_link5desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link5</a> || ";
    echo "		<a href=\"$PHP_SELF?action=admin&admin=$admin\" onmouseover=\"window.status='$gb_link2desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link2</a> || ";
    echo "		$gb_link4head</div>\n";
    echo "             </td>\n";
    echo "            </tr>\n";
    echo "           </table>\n";
    echo "<form action=\"$PHP_SELF\" method=\"GET\">\n";
    echo "<table align=\"center\" width=\"100%\">\n";
    if ($action == "edit_banned_ip") {
	echo "<input type=\"hidden\" name=\"action\" value=\"save_edit_banned_ip\">\n";
    } else {
        echo "<input type=\"hidden\" name=\"action\" value=\"save_new_banned_ip\">\n";
    }
    echo "<input type=\"hidden\" name=\"value\" value=\"$value\">\n";
    echo "<input type=\"hidden\" name=\"admin\" value=\"$admin\">\n";
    echo "<tr>\n";
    echo "<td class=\"classadd1\"><div class=\"maininputleft\">$gb_link4text</div></td>\n";
    echo "<td class=\"classadd2\">\n";
    echo "<input type=text name=\"newvalue\" size=\"25\" maxlength=\"50\" value=\"$value\"></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td class=\"classadd2\"></td>\n";
    echo "<td class=\"classadd2\"><br><input type=submit value=Submit></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</form>\n";

  } elseif ($action == "save_edit_banned_ip" && $admin==$adminpass) {
    $result = mysql_db_query($database, "UPDATE banned_ips SET banned_ip='$newvalue' WHERE banned_ip='$value'") or die("Database Query Error");
    echo "<script language=javascript>location.replace('$PHP_SELF?action=banned_ips&admin=$admin');</script>\n";

  } elseif ($action == "save_new_banned_ip" && $admin==$adminpass) {
    $result = mysql_db_query($database, "INSERT INTO banned_ips (banned_ip) VALUES('$newvalue')") or die("Database Query Error");
    echo "<script language=javascript>location.replace('$PHP_SELF?action=banned_ips&admin=$admin');</script>\n";

  } elseif ($action == "delete_banned_ip" && $admin==$adminpass) {
    $result = mysql_db_query($database, "DELETE FROM banned_ips WHERE banned_ip='$value'") or die("Database Query Error");
    echo "<script language=javascript>location.replace('$PHP_SELF?action=banned_ips&admin=$admin');</script>\n";

  } else {

    if ($admin) {$adminlink="&admin=$admin";}

    echo "	    <table>\n";
    echo "            <tr>\n";
    echo "             <td width=\"1%\">\n";
    echo "              <div class=\"mainheader\">$guestbook_head</div>\n";
    echo "             </td>\n";
    echo "             <td>\n";
    echo "              <div class=\"mainmenu\">\n";
    if ($admin==$adminpass) {
       echo " 		    <a href=\"$PHP_SELF?action=admin&admin=$admin\" onmouseover=\"window.status='$gb_link2desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link2</a> || \n";
    }
    if ($phpbookcookie==$guestbook_head && $admin!=$adminpass) {
       echo " 		    <a href=\"$PHP_SELF\" onclick=javascript:floodprotect() onmouseover=\"window.status='$gb_link1desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link1</a>\n";
    } else {
       echo " 		    <a href=\"$PHP_SELF?action=add$adminlink\" onmouseover=\"window.status='$gb_link1desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link1</a>\n";
    }
    echo "              </div>\n";
    echo "             </td>\n";
    echo "            </tr>\n";
    echo "           </table>\n";
    echo "           <div class=\"maintext\">\n";

    #  Start with Output
    #################################################################################################

    echo "<table align=\"center\"  cellspacing=\"0\" cellpadding=\"3\" width=\"100%\" border=\"0\">\n";
    echo "<tr><td><div class=\"maincatnav\">\n";
    echo "$gb_desc<br>\n";
    echo "</div></td>\n";

    #  Calculate Page-Numbers
    #################################################################################################

    if (empty($perpage)) $perpage = 1;
    if (empty($pperpage)) $pperpage = 9;	//!!! ONLY 5,7,9,11,13 !!!!
    if (empty($sort)) $sort = "desc";
    if (empty($offset)) $offset = 0;
    if (empty($poffset)) $poffset = 0;
    $amount = mysql_db_query($database, "SELECT count(*) FROM guestbook");
    $amount_array = mysql_fetch_array($amount);
    $pages = ceil($amount_array["0"] / $perpage);
    $actpage = ($offset+$perpage)/$perpage;
    $maxoffset = ($pages-1)*$perpage;
    $maxpoffset = $pages-$pperpage;
    $middlepage=($pperpage-1)/2;
    if ($maxpoffset<0) {$maxpoffset=0;}
    echo "<td><div class=\"mainpages\">\n";
    if ($pages) {                                       // print only when pages > 0
        echo "$ad_pages\n";
	if ($offset) {
    	    $noffset=$offset-$perpage;
            $npoffset = $noffset/$perpage-$middlepage;
	    if ($npoffset<0) {$npoffset=0;}
            if ($npoffset>$maxpoffset) {$npoffset = $maxpoffset;}
	    echo "[<a href=\"$PHP_SELF?offset=0&poffset=0$adminlink\"><<</a>] ";
	    echo "[<a href=\"$PHP_SELF?offset=$noffset&poffset=$npoffset$adminlink\"><</a>] ";
    	}
        for($i = $poffset; $i< $poffset+$pperpage && $i < $pages; $i++) {
	    $noffset = $i * $perpage;
    	    $npoffset = $noffset/$perpage-$middlepage;
    	    if ($npoffset<0) {$npoffset = 0;}
    	    if ($npoffset>$maxpoffset) {$npoffset = $maxpoffset;}
	    $actual = $i + 1;
    	    if ($actual==$actpage) {
 		echo "(<b>$actual</b>) ";
            } else {
 		echo "[<a href=\"$PHP_SELF?offset=$noffset&poffset=$npoffset$adminlink\">$actual</a>] ";
	    }
	}
	if ($offset+$perpage<$amount_array["0"]) {
    	    $noffset=$offset+$perpage;
    	    $npoffset = $noffset/$perpage-$middlepage;
    	    if ($npoffset<0) {$npoffset=0;}
    	    if ($npoffset>$maxpoffset) {$npoffset = $maxpoffset;}
	    echo "[<a href=\"$PHP_SELF?offset=$noffset&poffset=$npoffset$adminlink\">></a>] ";
	    echo "[<a href=\"$PHP_SELF?offset=$maxoffset&poffset=$maxpoffset$adminlink\">>></a>] ";
        }
    }
    echo "</div></td></tr>\n";
    echo "</table>\n";

    #  Start the Page
    #################################################################################################

    echo "<table align=\"center\"  cellspacing=\"1\" cellpadding=\"3\" width=\"100%\" border=\"0\">\n";
    echo "   <tr>\n";
    echo "     <td class=\"gbheader\">$gb_name</td>\n";
    echo "     <td class=\"gbheader\">$gb_comments</td>\n";
    echo "   </tr>\n";

    #  Get actions for current page
    #################################################################################################

    $result = mysql_db_query($database, "SELECT * FROM guestbook ORDER by id $sort LIMIT $offset, $perpage");
    while ($db = mysql_fetch_array($result)) {

    if ($dateformat=="eu")
 {					// European Date & Timeformat
        $when = strftime("%d.%m.%Y %H:%M", $db["timestamp"]);
    } else {							// US  Date & Timeformat
	$when = strftime("%m/%d/%Y %I:%M %p", $db["timestamp"]);
    }

    if ($db[email]   != "none") {
	$email = "<a href=\"mailto:".$db[email]."\"><img src=\"$image_dir/icons/email.gif\" alt=\"$send_email\" border=\"0\" align=\"right\"></a>";
	} else {
	$email = "";
	}
    if ($db[icq]     != 0)      {
	$icq = "<a href=\"http://wwp.icq.com/scripts/contact.dll?msgto=$db[icq]\"><img src=\"http://wwp.icq.com/scripts/online.dll?icq=" . $db[icq] . "&img=5\" alt=\"$icq_message\" border=\"0\" align=\"right\" height=\"17\"></a>";
	} else {
	$icq = "";
	}
    if ($db[http]    != "none") {
	$http = "<a href=\"http://$db[http]\" target=\"_blank\"><img src=\"$image_dir/icons/home.gif\" alt=\"$view_homepage\" border=\"0\" align=\"right\"></a>";
	} else {
	$http = "";
	}
    if ($db[ip]      != "none") {
       if ($admin==$adminpass) {
	  $ip = "<img src=\"$image_dir/icons/ip.gif\" alt=\"".$db[ip]."\" align=\"left\">";
       } else {
	  $ip = "<img src=\"$image_dir/icons/ip.gif\" alt=\"$ip_logged\" align=\"left\">";
       }
    } else {
	$ip = "";
    }
    if ($db[location]!= "none") {
	$location = "$gb_location<br>$db[location]<br>";
	} else {
	$location = "<br><br>";
	}
    if ($db[browser]      != "") {
	$browser = "<img src=\"$image_dir/icons/browser.gif\" alt=\"$db[browser]\" align=\"left\">";
	} else {
	$browser = "";
	}
    echo "  <tr>\n";
    echo "     <td class=\"gbtable1\">\n";
    echo "        <div class=\"mainname\">$db[name]</div><br>\n";
    echo "        <div class=\"smallleft\">$location<br></div>\n";
    echo "        <br>$icq $http $email $ip $browser\n";
    echo "     </td>\n";
    echo "        <td class=\"gbtable2\"><div class=\"smallleft\">\n";
    if ($admin==$adminpass) {
        echo "<a href=\"$PHP_SELF?action=submit&delid=$db[id]&offset=$offset&poffset=$poffset$adminlink\"><img src=\"$image_dir/icons/trash.gif\" alt=\"$moderator_del_action\" border=\"0\" align=\"right\"></a>";
        echo "<a href=\"$PHP_SELF?action=submit&delcommentid=$db[id]&offset=$offset&poffset=$poffset$adminlink\"><img src=\"$image_dir/icons/trashcomment.gif\" alt=\"$moderator_del_comment\" border=\"0\" align=\"right\"></a>";
        echo "<a href=\"$PHP_SELF?action=submit&commentid=$db[id]&offset=$offset&poffset=$poffset$adminlink\"><img src=\"$image_dir/icons/comment.gif\" alt=\"$moderator_edit_comment\" border=\"0\" align=\"right\"></a>";
		        echo "<div class=\"spaceleft\">&nbsp;</div>\n";
    }
    echo "        $gb_posted $when</div><hr><div class=\"mainleft\">".censor_msg($db[message],($admin==$adminpass))."</div>\n";
    if($commentid == $db[id] && $action!="changed" && $admin==$adminpass) {
      echo "  &nbsp;&nbsp\n";
      echo "  <form action=\"$PHP_SELF?action=submit\" method=\"post\">\n";
      echo "     <input type=\"hidden\" name=\"admin\" value=\"$admin\"><input type=\"hidden\" name=\"commentid\" value=\"$commentid\">\n";
      echo "     <input type=\"hidden\" name=\"offset\" value=\"$offset\"><input type=\"hidden\" name=\"poffset\" value=\"$poffset\">\n";
      echo "     <div class=\"comment\"><textarea name=\"comment\" cols=\"".($text_field_size-5)."\" rows=\"5\">".decode_msg($db[comment])."</textarea>\n<BR>";
      echo "     <input type=\"submit\">&nbsp;&nbsp;<a href=\"smiliehelp.php\"
                            onClick='enterWindow=window.open(\"smiliehelp.php\",\"Smilie\",
                            \"width=250,height=450,top=100,left=100,scrollbars=yes\"); return false'
                            onmouseover=\"window.status='$smiliehelp'; return true;\"
                            onmouseout=\"window.status=''; return true;\">$smiley_help</a></div>\n";
      echo "  </form>\n";
    } elseif(!empty($db[comment])) {
      echo "  &nbsp;&nbsp<div class=\"comment\">".$gb_modcomment.$db[comment]."</div>\n";
    }
    echo "      </td>\n  </tr>\n";
    }

    # End of Page reached
    #################################################################################################

    echo"</table>\n";
    echo"</div>\n";
  }
  echo"        </td>\n";
  echo"       </tr>\n";
  echo"      </table>\n";
  echo"    </td>\n";
  echo"   </tr>\n";
  echo"   <tr>\n";
  echo"    <td>\n";
  echo"<br>\n";

  if ($show_sysinfo) {
    list($usec, $sec) = explode(" ",$proctime_start);
    $proctime_start = $usec+$sec;

    list($usec, $sec) = explode(" ",microtime());
    $proctime_end = $usec+$sec;
    $proctime = $proctime_end-$proctime_start;

    $query = mysql_db_query($database, "SELECT id FROM guestbook");
    $countall=mysql_num_rows($query);


    echo"<div class=\"footer\">Processingtime: ".substr($proctime,0,7)." sec., Entries: $countall, PHP Ver. ".phpversion()."</div>\n";
  }

  #  PLEASE DO NOT REMOVE OR EDIT THIS COPYRIGHT-NOTICE !!! THANKS !!! ################################################

  echo"<div class=\"footer\">phpBook Ver. $book_version &copy; 2001-".date("Y")." by <a href=\"http://www.smartisoft.com\" target=\"_blank\">SmartISoft</a></div>\n";
  #####################################################################################################################

  echo"    </td>\n";
  echo"   </tr>\n";
  echo" </table>\n";
  echo"</body>\n";
  echo"</html>\n";


}

#  Disconnect DB
#################################################################################################
mysql_close();

if ($support==$supportpwd && $supportpwd) {echo "<br><br>"; phpinfo();}

?>