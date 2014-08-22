<?

# If you change your path on your server, the image-path stored in messages & comments point's to the oldpath,
# this little script correct this, only enter your newpath and run the script
# DON NOT REMOVE THE "=" in path-variables below !!!!

require ("../config.php");

$oldpath="=images/";
$newpath="=products/book/images/";

mysql_connect($server, $db_user, $db_pass);

    #  Start the Page
    #################################################################################################


    $result = mysql_db_query($database, "SELECT * FROM guestbook ORDER by id");
    while ($db = mysql_fetch_array($result)) {
	$message=ereg_replace($oldpath, $newpath, $db[message]);
	$comment=ereg_replace($oldpath, $newpath, $db[comment]);
	echo"$message<br>";
	mysql_db_query($database, "UPDATE guestbook set message='$message',comment='$comment' WHERE id='$db[id]'");
    }
    #  Disconnect DB
    #################################################################################################

    mysql_close();


?>