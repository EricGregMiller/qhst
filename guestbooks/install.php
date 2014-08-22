<?
#################################################################################################
#
#  project              : phpBook
#  filename             : install.php
#  last modified by     : Erich Fuchs
#  e-mail               : office@smartisoft.com
#  purpose              : Guestbook DB install
#  Script made by	: Nicky (www.nicky.net )22.10.2001
#
#################################################################################################
?>

<html>
 <head>
 <title>mySQL Tables Install Script for phpBook</title>
 </head>
 <body link=#0000FF alink=#0000FF vlink=#0000FF>
 <center><h1>ATTENTION</h1><hr>
 <font face="Verdana" size="2" color="#FF0000">with next step this install script will delete your existing<br>mySQL tables like "badwords", "banned_ips", "guestbook" and "smilies"<br>and will create new ones.<br><br>create tables now: click <a href="install.php?action=donow">here</a><br></font></center>
<?
require("config.php");

if ($action=="donow") {

mysql_connect("$server", "$db_user", "$db_pass") or die ("Connection Error >>> Check your configuration in config.php >>> you can find in at ## mySql Configuration ##");
mysql_select_db("$database") or die ("Database Error >>> Check your configuration in config.php >>> you can find in at ## mySql Configuration ##");

mysql_query("DROP TABLE IF EXISTS badwords");

mysql_query("
CREATE TABLE badwords (
   badword varchar(25) NOT NULL
) TYPE=MyISAM
") or die ("ERROR : Could not create table");
echo "<b>Badword table created</b>...<br>";

mysql_query("INSERT INTO badwords VALUES ( 'fuck')");
mysql_query("INSERT INTO badwords VALUES ( 'schweinehund')");
mysql_query("INSERT INTO badwords VALUES ( 'fucking')");
mysql_query("INSERT INTO badwords VALUES ( 'shit');");
mysql_query("INSERT INTO badwords VALUES ( 'piss');");

echo "Badwords Values inserted...<br>";

mysql_query("DROP TABLE IF EXISTS banned_ips");

mysql_query("
CREATE TABLE banned_ips (
   banned_ip varchar(15) NOT NULL,
   PRIMARY KEY (banned_ip)
) TYPE=MyISAM
") or die ("ERROR : Could not create table");
echo "<b>Banned IP's table created</b>...<br>";

mysql_query("DROP TABLE IF EXISTS guestbook");

mysql_query("
CREATE TABLE guestbook (
   id int(5) DEFAULT '0' NOT NULL auto_increment,
   name varchar(25) NOT NULL,
   email varchar(35) NOT NULL,
   icq int(11) DEFAULT '0' NOT NULL,
   http varchar(50) NOT NULL,
   message mediumtext NOT NULL,
   timestamp int(11) DEFAULT '0' NOT NULL,
   ip varchar(15) NOT NULL,
   location varchar(35) NOT NULL,
   browser varchar(50) NOT NULL,
   comment mediumtext NOT NULL,
   PRIMARY KEY (id)
) TYPE=MyISAM
") or die ("ERROR : Could not create table");
echo "<b>Guestbook table created</b>...<br>";

mysql_query("INSERT INTO guestbook VALUES ( '1', 'Webmaster', 'webmaster@erotikbazar.com', '0', 'www.erotikbazar.com', 'Hi dear User <img src=images/smilies/smile.gif>
<BR>
<BR>The phpBazar ist great <img src=images/smilies/bounce.gif> leave us a Message in our Guestbook
<BR>
<BR>by(t)e Webmaster', '981136586', '0.0.0.0', 'A - Wien', 'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0)', '')");

echo "Guestbook Values inserted...<br>";

mysql_query("DROP TABLE IF EXISTS smilies");

mysql_query("
CREATE TABLE smilies (
   code char(3) NOT NULL,
   file varchar(15) NOT NULL,
   name varchar(25) NOT NULL
) TYPE=MyISAM
") or die ("ERROR : Could not create table");
echo "<b>Smilies table created</b>...<br>";

mysql_query("INSERT INTO smilies VALUES ( ':)', 'smile.gif', 'Smile')");
mysql_query("INSERT INTO smilies VALUES ( ':-)', 'smile.gif', 'Smile')");
mysql_query("INSERT INTO smilies VALUES ( ':))', 'lol.gif', 'LOL')");
mysql_query("INSERT INTO smilies VALUES ( ';)', 'wink.gif', 'Winkywinky')");
mysql_query("INSERT INTO smilies VALUES ( ';-)', 'wink.gif', 'Winkywinky')");
mysql_query("INSERT INTO smilies VALUES ( ':(', 'frown.gif', 'Frown')");
mysql_query("INSERT INTO smilies VALUES ( ':-(', 'frown.gif', 'Frown')");
mysql_query("INSERT INTO smilies VALUES ( ':[', 'mad.gif', 'Mad')");
mysql_query("INSERT INTO smilies VALUES ( ':z)', 'grazy.gif', 'Grazy')");
mysql_query("INSERT INTO smilies VALUES ( ':y)', 'crying.gif', 'Crying')");
mysql_query("INSERT INTO smilies VALUES ( ':o)', 'sleepy.gif', 'Sleepy')");
mysql_query("INSERT INTO smilies VALUES ( ':a)', 'alien.gif', 'Alien')");
mysql_query("INSERT INTO smilies VALUES ( ':s)', 'smokie.gif', 'Smokie')");
mysql_query("INSERT INTO smilies VALUES ( ':l)', 'love.gif', 'Loooove')");
mysql_query("INSERT INTO smilies VALUES ( ':L)', 'love2.gif', 'Loooooooooove')");
mysql_query("INSERT INTO smilies VALUES ( ':]', 'biggrin.gif', 'Big Smile')");
mysql_query("INSERT INTO smilies VALUES ( ':-/', 'bounce.gif', 'Bounce')");
mysql_query("INSERT INTO smilies VALUES ( ':b)', 'burnout.gif', 'Burnout')");
mysql_query("INSERT INTO smilies VALUES ( ':&)', 'clown.gif', 'Clown')");
mysql_query("INSERT INTO smilies VALUES ( ':?)', 'confused.gif', 'Confused')");
mysql_query("INSERT INTO smilies VALUES ( ':c)', 'cool.gif', 'Cooooooool')");
mysql_query("INSERT INTO smilies VALUES ( ':e)', 'eek.gif', 'Eeeeeeek')");
mysql_query("INSERT INTO smilies VALUES ( ':f)', 'flash.gif', 'Flash')");
mysql_query("INSERT INTO smilies VALUES ( ':g)', 'girl.gif', 'Girl')");
mysql_query("INSERT INTO smilies VALUES ( ':i)', 'idee.gif', 'Idea')");
mysql_query("INSERT INTO smilies VALUES ( ':r)', 'redface.gif', 'Redface')");
mysql_query("INSERT INTO smilies VALUES ( ':8)', 'rolleyes.gif', 'RollEyes')");
mysql_query("INSERT INTO smilies VALUES ( ':}', 'tongue.gif', 'Tongue')");
mysql_query("INSERT INTO smilies VALUES ( ':t)', 'tasty.gif', 'Tasty')");
mysql_query("INSERT INTO smilies VALUES ( ':1)', 'alien2.gif', 'invader')");
mysql_query("INSERT INTO smilies VALUES ( ':2)', 'kitty.gif', 'Bastard Kitty')");
mysql_query("INSERT INTO smilies VALUES ( ':3)', 'heart.gif', 'Heart1')");
mysql_query("INSERT INTO smilies VALUES ( ':4)', 'rainbow.gif', 'tie died')");
mysql_query("INSERT INTO smilies VALUES ( ':5)', 'el.gif', 'Embarrassed')");
mysql_query("INSERT INTO smilies VALUES ( ':6)', 'pumpkin2.gif', 'Helloween')");
mysql_query("INSERT INTO smilies VALUES ( ':7)', 'private.gif', 'Secret')");
mysql_query("INSERT INTO smilies VALUES ( ':x)', 'xmas.gif', 'Christmas')");
mysql_query("INSERT INTO smilies VALUES ( ':9)', 'kiss.gif', 'Kiss, Kiss')");
mysql_query("INSERT INTO smilies VALUES ( ':1]', 'karate.gif', 'Karate')");
mysql_query("INSERT INTO smilies VALUES ( ':2]', 'cold.gif', 'Cold')");
mysql_query("INSERT INTO smilies VALUES ( ':3]', 'devil.gif', 'Devil')");
mysql_query("INSERT INTO smilies VALUES ( ':4]', 'tongue2.gif', 'So Nyah!')");
mysql_query("INSERT INTO smilies VALUES ( ':5]', 'redhot.gif', 'Red Hot')");
mysql_query("INSERT INTO smilies VALUES ( ':6]', 'smash.gif', 'Smash!')");
mysql_query("INSERT INTO smilies VALUES ( ':7]', 'frosty.gif', 'Frosty')");
mysql_query("INSERT INTO smilies VALUES ( ':8]', 'confused2.gif', 'Confused again')");
mysql_query("INSERT INTO smilies VALUES ( ':9]', 'kaioken.gif', 'KAI')");
mysql_query("INSERT INTO smilies VALUES ( ':1}', 'vampire.gif', 'Vampire')");
mysql_query("INSERT INTO smilies VALUES ( ':2}', 'splat.gif', 'Splat')");
mysql_query("INSERT INTO smilies VALUES ( ':3}', 'rwb.gif', 'Flag Smiley')");
mysql_query("INSERT INTO smilies VALUES ( ':4}', 'FRlol.gif', 'LOL2')");
mysql_query("INSERT INTO smilies VALUES ( ':5}', 'goodbad.gif', 'Good / Bad')");
mysql_query("INSERT INTO smilies VALUES ( ':6}', 'eek2.gif', 'EEEEK')");
mysql_query("INSERT INTO smilies VALUES ( ':7}', 'dodgy.gif', 'Dodgy')");
mysql_query("INSERT INTO smilies VALUES ( ':8}', 'bawling.gif', 'Bawling')");
mysql_query("INSERT INTO smilies VALUES ( ':9}', 'party.gif', 'Party on, Garth!')");
mysql_query("INSERT INTO smilies VALUES ( ':ni', 'nighty.gif', 'Nightey, Night!')");
mysql_query("INSERT INTO smilies VALUES ( ':wa', 'wavey.gif', 'Wave!')");
mysql_query("INSERT INTO smilies VALUES ( ':pa', 'patty.gif', 'Patty')");
mysql_query("INSERT INTO smilies VALUES ( ':al', 'alarm.gif', 'Alarm')");
mysql_query("INSERT INTO smilies VALUES ( ':ba', 'barf.gif', 'Barf!')");
mysql_query("INSERT INTO smilies VALUES ( ':bd', 'birthday.gif', 'Birthday')");
mysql_query("INSERT INTO smilies VALUES ( ':bu', 'bubble.gif', 'bubble')");
mysql_query("INSERT INTO smilies VALUES ( ':ca', 'cat.gif', 'Kitty')");
mysql_query("INSERT INTO smilies VALUES ( ':ce', 'censored.gif', 'Censor')");
mysql_query("INSERT INTO smilies VALUES ( ':ch', 'cheers.gif', 'Cheers')");
mysql_query("INSERT INTO smilies VALUES ( ':co', 'cowboy.gif', 'Cowboy')");
mysql_query("INSERT INTO smilies VALUES ( ':da', 'dance.gif', 'Dancing')");
mysql_query("INSERT INTO smilies VALUES ( ':gr', 'dance1.gif', 'Dancing Stick')");
mysql_query("INSERT INTO smilies VALUES ( ':du', 'dunce.gif', 'Dunce')");
mysql_query("INSERT INTO smilies VALUES ( ':fi', 'finger.gif', 'Bird')");
mysql_query("INSERT INTO smilies VALUES ( ':fe', 'flame.gif', 'Flame')");
mysql_query("INSERT INTO smilies VALUES ( ':fg', 'flaming.gif', 'Flaming')");
mysql_query("INSERT INTO smilies VALUES ( ':fl', 'flower2.gif', 'Flower2')");
mysql_query("INSERT INTO smilies VALUES ( ':hi', 'hippie.gif', 'Hippie')");
mysql_query("INSERT INTO smilies VALUES ( ':jo', 'joker.gif', 'Jester')");
mysql_query("INSERT INTO smilies VALUES ( ':kn', 'knight.gif', 'Knight')");
mysql_query("INSERT INTO smilies VALUES ( ':ko', 'koolaid.gif', 'KoolAid')");
mysql_query("INSERT INTO smilies VALUES ( ':lo', 'looney.gif', 'Looney')");
mysql_query("INSERT INTO smilies VALUES ( ':pi', 'pimp.gif', 'Pimp')");
mysql_query("INSERT INTO smilies VALUES ( ':fy', 'mfinger.gif', 'Monkey Bird')");
mysql_query("INSERT INTO smilies VALUES ( ':pu', 'pukeface.gif', 'Puke')");
mysql_query("INSERT INTO smilies VALUES ( ':no', 'no.gif', 'NO!')");
mysql_query("INSERT INTO smilies VALUES ( ':ro', 'rosie.gif', 'Rosy Cheeks')");
mysql_query("INSERT INTO smilies VALUES ( ':sh', 'shudder.gif', 'Shudder')");
mysql_query("INSERT INTO smilies VALUES ( ':si', 'sick.gif', 'Sick')");
mysql_query("INSERT INTO smilies VALUES ( ':sm', 'smoker.gif', 'Smokin')");
mysql_query("INSERT INTO smilies VALUES ( ':se', 'sperm.gif', 'Sperm')");
mysql_query("INSERT INTO smilies VALUES ( ':to', 'tomato.gif', 'tomato')");
mysql_query("INSERT INTO smilies VALUES ( ':tu', 'tut.gif', 'King Tut')");
mysql_query("INSERT INTO smilies VALUES ( ':ty', 'type.gif', 'Typing')");
mysql_query("INSERT INTO smilies VALUES ( ':wh', 'whip.gif', 'Whip It!')");
mysql_query("INSERT INTO smilies VALUES ( ':ja', 'whoa.gif', 'Jaw Dropping')");
echo "Smilies Values inserted...<br>";

echo "<br>All tables created..No errors found<br><br><b><font color=#FF0000>Please remove install.php from your Server !!!</font></b><br>Go now to your <a href=$url_to_start>Guestbook</a>.";

echo "<br><br><br><font face=\"Verdana\" size=\"1\" color=\"#FF0000\">mySQL Tables Install Script made by <a href=\"http://www.nicky.net\">Nicky.net</a> - 22.10.2001</font>";
}
?>
</body></html>