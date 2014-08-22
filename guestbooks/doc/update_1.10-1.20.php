<?
#######################################################################################
#                                                                                     #
# File to upgrade phpBook from 1.10 to 1.20                                           #
#   Enter SQL Info to your Datebase below..                                           #
# DELETE THIS FILE AFTER UPDATING                                                     #
$host       = "localhost";                                                            #
$database   = "phpBook";                                                              #
$username   = "mysql_username";                                                       #
$password   = "mysql_password";                                                       #
#                                                                                     #
#######################################################################################


mysql_connect($host, $username, $password) or die ("Database connect Error");
    @mysql_select_db($database) or die ("Database select Error");

$result = mysql_query("ALTER TABLE guestbook ADD comment MEDIUMTEXT NOT NULL");
if (!$result) {
    echo "Alteration of guestbook table failed!<br>" .mysql_errno(). ": ".mysql_error(). "<br>";
    return;
}

echo "phpBook Tables Updated, Ok...";
?>