<?
#################################################################################################
#
#  project           	: phpBook
#  filename          	: smiliehelp.php
#  last modified by  	: Erich Fuchs
#  e-mail            	: office@smartisoft.com
#  purpose           	: Show's the Smilie DB
#
#################################################################################################

#  HTML Header Start
#################################################################################################

require ("config.php");

echo "<html>\n";
echo " <head>\n";
echo "  <title>$smiley_help</title>\n";
echo "  <link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">\n";
echo "  $languagemetatag\n";
echo "  <meta name=\"robots\" content=\"index, nofollow\">\n";
echo "  <meta name=\"revisit-after\" content=\"20 days\">\n";
echo " </head>\n";
echo "<body>\n";

#  Connect to the DB
#################################################################################################

mysql_connect($server, $db_user, $db_pass);

#  Get Entrys for current page
#################################################################################################

    echo "<table>\n";
    echo "<tr>\n";
    echo "<td><div class=\"maininputleft\">Code</div></td>\n";
    echo "<td></td>\n";
    echo "<td><div class=\"maintext\"></div></td>\n";
    echo "</tr>\n";
    $result = mysql_db_query($database, "SELECT * FROM smilies") or died("Query Error");
    while ($db = mysql_fetch_array($result)) {
	echo "<tr>\n";
        echo "<td><div class=\"maininputleft\">$db[code]</div></td>\n";
	echo "<td>&nbsp&nbsp<img src=".$image_dir."/smilies/".$db[file]."></td>\n";
        echo "<td><div class=\"maintext\">$db[name]</div></td>\n";
	echo "</tr>\n";
    }
    echo "</table>\n";
mysql_close();

?>

</body>
</html>