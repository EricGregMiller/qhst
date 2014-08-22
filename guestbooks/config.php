<?
#################################################################################################
#
#  project           	: phpBook
#  filename          	: config.php
#  version           	: 1.50
#  last modified by  	: Erich Fuchs
#  e-mail            	: office@smartisoft.com
#  purpose           	: Configuration File
#  last modified     	: 10/26/2002
#
#################################################################################################

extract($_REQUEST);
extract($_SERVER);

// mySql Configuration
$server         	= "localhost";           	// Your mySQL Server, most cases "localhost"
$db_user        	= "usr5ba19fe05d62";           	// Your mySQL Username
$db_pass       	 	= "heretic";           	// Your mySQL Password
$database       	= "mysqlc61939b4baab686383d6fed53ff";             	// Database Name

// GB Parameters
$adminpass      	= "heretic";                	// Password for Administration
$guestbook_head 	= "GuestBook";           	// Guestbook Header (Name)
$gb_desc		= "The best phpBook on the Net";// Enter your description here
$url_to_start   	= "http://theology.edu/guestbooks"; // NO trailing slashes
$gb_notify      	= "robin@theology.edu";       // leave it empty -> disable notify

$language		= "english.php";		// for e.g. German enter german.php (see languages sub-dir)
$locations		= "worldlong.inc";		// for e.g. Europe enter europe.inc (see locations sub-dir)
$lang_dir		= "languages";			// Language Directory, no trailing slashes
$loc_dir		= "locations";			// Locations Directory, no trailing slashes
$image_dir		= "images";			// Image Directory, no trailing slashes
$limit          	= array(5 ,1000);      		// Message Limits (min,max)
$timelimit		= "60";				// Submit timeout in minutes (Cookiebanning), disabled if "";
$perpage		= "5";				// how much Entry's per page
$pperpage		= "11";  			// how much PageBreak's per page, should be like 5,7,9,11,13
$table_width		= "600";			// enter value in pix (e.g. "600") or in % (e.g. "80%")
$table_height		= "";				// "" means the table is variable
$table_align		= "center";
$dateformat		= "us";				// for european Date&Time-Format enter "eu"
$book_version		= "1.50";			// DO NOT CHANGE THIS
$show_sysinfo		= true;				// show the systeminformation on every bottom page
$supportpwd		= "2support";			// pwd for support-info, paranoid-setting is ""

#################################################################################################
#  End Configuration
#################################################################################################
#
#  !!! DO NOT EDIT ANYTHING BEHIND THIS LINE !!!
#
#################################################################################################

error_reporting(E_ALL & ~(E_WARNING | E_NOTICE));

require ("$lang_dir/$language");
require ("$lang_dir/admin.php");

#  Functions
#################################################################################################

function str_repeats($input, $mult) {
    $ret = "";
    while ($mult > 0) {
	$ret .= $input;
	$mult --;
    }
    return $ret;
}

function died($message) {				//when we die, than with a nice screen ;-)                                          	// tbd. NOT nice yet :-) btw. maybe next releases
    echo $message;
    exit;
}

function isbanned() {
    global $REMOTE_ADDR,$database;
    $ban_query = mysql_db_query($database, "SELECT * FROM banned_ips") or died("Database Query Error");
    while ($ip = mysql_fetch_row($ban_query)) {
        if ($ip["0"] == $REMOTE_ADDR) {
            return 1;
            exit;
        }
    }
    return 0;
}

function encode_msg ($msg) {
    global $image_dir,$database;
    if ($msg) {
        $msg = str_replace("\r", "", $msg);             // Replace carrige return
        $msg = str_replace("\n", "<BR>", $msg); 	// Replace newline with <br>
	$result = mysql_db_query($database, "SELECT * FROM smilies") or died("Query Error");
        while ($db = mysql_fetch_array($result)) {
	    $msg = str_replace($db[code], "<img src=".$image_dir."/smilies/".$db[file].">", $msg); // Smilie
        }
    }
    return $msg;
}

function urlcode_msg($msg) {
    if (get_magic_quotes_gpc()!=1) { $msg=addslashes($msg); }
    $msg = nl2br($msg);
    $msg = ereg_replace("javascript","",$msg);
    $msg = eregi_replace(quotemeta("[b]"),quotemeta("<b>"),$msg);
    $msg = eregi_replace(quotemeta("[/b]"),quotemeta("</b>"),$msg);
    $msg = eregi_replace(quotemeta("[i]"),quotemeta("<i>"),$msg);
    $msg = eregi_replace(quotemeta("[/i]"),quotemeta("</i>"),$msg);
    $msg = eregi_replace(quotemeta("[u]"),quotemeta("<u>"),$msg);
    $msg = eregi_replace(quotemeta("[/u]"),quotemeta("</u>"),$msg);
    $msg = eregi_replace("\\[url\\]www.([^\\[]*)\\[/url\\]", "<a href=\"http://www.\\1\" target=_blank>\\1</a>",$msg);
    $msg = eregi_replace("\\[url\\]([^\\[]*)\\[/url\\]","<a href=\"\\1\" target=_blank>\\1</a>",$msg);
    $msg = eregi_replace("\\[url=([^\\[]*)\\]([^\\[]*)\\[/url\\]","<a href=\"\\1\" target=_blank>\\2</a>",$msg);
    $msg = eregi_replace("\\[email\\]([^\\[]*)\\[/email\\]", "<a href=\"mailto:\\1\">\\1</a>",$msg);
    $msg = eregi_replace("\\[img\\]([^\\[]*)\\[/img\\]","<img src=\"\\1\" border=0>",$msg);
    $msg = eregi_replace("\\[swf width=([^\\[]*) height=([^\\[]*)\\]([^\\[]*)\\[/swf\\]","<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4\,0\,2\,0\" width=\"\\1\" height=\"\\2\"><param name=quality value=high><param name=\"SRC\" value=\"\\3\"><embed src=\"\\3\" quality=high pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"\\1\" height=\"\\2\"></embed></object>", $msg);
    return $msg;
}

function wordwrap_msg($msg, $maxwordlen=50) {
    $eachword = explode(" " , eregi_replace("<BR>"," ",$msg));
      for ($i=0; $i<count($eachword); $i++) {
	if (strlen($eachword[$i])>$maxwordlen) {
          $msg = eregi_replace($eachword[$i], chunk_split($eachword[$i],$maxwordlen), $msg);
	}
      }
    return $msg;
}

function censor_msg($msg, $admin=0) {  // Badword-Replacement
    global $database;
    $msg= urlcode_msg($msg);
    $msg= wordwrap_msg($msg);
    $eachword = explode(" " , eregi_replace("<BR>"," ",$msg));          // temp remove <BR>
    $result = mysql_db_query($database, "SELECT * FROM badwords") or died("Query Error");
    while ($db = mysql_fetch_array($result)) {
      for ($i=0; $i<count($eachword); $i++) {
	if (is_int(strpos($eachword[$i],$db[badword]))) {
          if($admin) {
            $msg = eregi_replace($eachword[$i], "<span class=\"censored\">".$eachword[$i]."</span>", stripslashes($msg)); // Badword
          } else {
            $msg = eregi_replace($eachword[$i], str_repeats("*", strlen($eachword[$i])), stripslashes($msg)); // Badword
          }
        }
      }
    }
    return $msg;
}

function decode_msg ($msg) {
    global $image_dir,$database;
    if ($msg) {
        $msg = str_replace("<BR>", "\n", $msg); // Replace newline with <br>
	$result = mysql_db_query($database, "SELECT * FROM smilies") or died("Query Error");
        while ($db = mysql_fetch_array($result)) {
	    $msg = str_replace("<img src=".$image_dir."/smilies/".$db[file].">",$db[code],$msg); // Smilie
        }
    }
    return $msg;
}

function strip_array ($in) {  //foreach()-Replacement !!!
    reset($in);
    while ($array=each($in)) {
        $ckey=$array['key'];
        $cvalue=$array['value'];
        $cvalue = str_replace("'", "''", $cvalue);
        $cvalue = stripslashes($cvalue);
        $cvalue = strip_tags($cvalue);
        $out[$ckey] = $cvalue;
    }
    return $out;
}

#################################################################################################
#  EOF

?>
