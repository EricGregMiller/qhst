# phpMyAdmin MySQL-Dump
# http://phpwizard.net/phpMyAdmin/
#
# Host: localhost Database : phpBook

# --------------------------------------------------------
#
# Table structure for table 'badwords'
#

CREATE TABLE badwords (
   badword varchar(25) NOT NULL
);

#
# Dumping data for table 'badwords'
#

INSERT INTO badwords VALUES ( 'fuck');
INSERT INTO badwords VALUES ( 'schweinehund');
INSERT INTO badwords VALUES ( 'fucking');
INSERT INTO badwords VALUES ( 'shit');
INSERT INTO badwords VALUES ( 'piss');

# --------------------------------------------------------
#
# Table structure for table 'banned_ips'
#

CREATE TABLE banned_ips (
   banned_ip varchar(15) NOT NULL,
   PRIMARY KEY (banned_ip)
);

#
# Dumping data for table 'banned_ips'
#

INSERT INTO banned_ips VALUES ( '0.0.0.0');

# --------------------------------------------------------
#
# Table structure for table 'guestbook'
#

CREATE TABLE guestbook (
   id int(5) NOT NULL auto_increment,
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
);

#
# Dumping data for table 'guestbook'
#

INSERT INTO guestbook VALUES ( '1', 'Webmaster', 'robin@theology.edu', '0', 'www.myplesk.com', 'Hi dear User <img src=images/smilies/smile.gif>
', '981136586', '0.0.0.0', 'A - Wien', 'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0)', '');

# --------------------------------------------------------
#
# Table structure for table 'smilies'
#

CREATE TABLE smilies (
   code char(3) NOT NULL,
   file varchar(15) NOT NULL,
   name varchar(25) NOT NULL
);

#
# Dumping data for table 'smilies'
#

INSERT INTO smilies VALUES ( ':)', 'smile.gif', 'Smile');
INSERT INTO smilies VALUES ( ':-)', 'smile.gif', 'Smile');
INSERT INTO smilies VALUES ( ':-]', 'lol.gif', 'LOL');
INSERT INTO smilies VALUES ( ';)', 'wink.gif', 'Winkywinky');
INSERT INTO smilies VALUES ( ';-)', 'wink.gif', 'Winkywinky');
INSERT INTO smilies VALUES ( ':(', 'frown.gif', 'Frown');
INSERT INTO smilies VALUES ( ':-(', 'frown.gif', 'Frown');
INSERT INTO smilies VALUES ( ':[', 'mad.gif', 'Mad');
INSERT INTO smilies VALUES ( ':z)', 'grazy.gif', 'Grazy');
INSERT INTO smilies VALUES ( ':y)', 'crying.gif', 'Crying');
INSERT INTO smilies VALUES ( ':o)', 'sleepy.gif', 'Sleepy');
INSERT INTO smilies VALUES ( ':a)', 'alien.gif', 'Alien');
INSERT INTO smilies VALUES ( ':s)', 'smokie.gif', 'Smokie');
INSERT INTO smilies VALUES ( ':l)', 'love.gif', 'Loooove');
INSERT INTO smilies VALUES ( ':L)', 'love2.gif', 'Loooooooooove');
INSERT INTO smilies VALUES ( ':]', 'biggrin.gif', 'Big Smile');
INSERT INTO smilies VALUES ( ':-/', 'bounce.gif', 'Bounce');
INSERT INTO smilies VALUES ( ':b)', 'burnout.gif', 'Burnout');
INSERT INTO smilies VALUES ( ':&)', 'clown.gif', 'Clown');
INSERT INTO smilies VALUES ( ':?)', 'confused.gif', 'Confused');
INSERT INTO smilies VALUES ( ':c)', 'cool.gif', 'Cooooooool');
INSERT INTO smilies VALUES ( ':e)', 'eek.gif', 'Eeeeeeek');
INSERT INTO smilies VALUES ( ':f)', 'flash.gif', 'Flash');
INSERT INTO smilies VALUES ( ':g)', 'girl.gif', 'Girl');
INSERT INTO smilies VALUES ( ':i)', 'idee.gif', 'Idea');
INSERT INTO smilies VALUES ( ':r)', 'redface.gif', 'Redface');
INSERT INTO smilies VALUES ( ':8)', 'rolleyes.gif', 'RollEyes');
INSERT INTO smilies VALUES ( ':}', 'tongue.gif', 'Tongue');
INSERT INTO smilies VALUES ( ':t)', 'tasty.gif', 'Tasty');
INSERT INTO smilies VALUES ( ':1)', 'alien2.gif', 'invader');
INSERT INTO smilies VALUES ( ':2)', 'kitty.gif', 'Bastard Kitty');
INSERT INTO smilies VALUES ( ':3)', 'heart.gif', 'Heart1');
INSERT INTO smilies VALUES ( ':4)', 'rainbow.gif', 'tie died');
INSERT INTO smilies VALUES ( ':5)', 'el.gif', 'Embarrassed');
INSERT INTO smilies VALUES ( ':6)', 'pumpkin2.gif', 'Helloween');
INSERT INTO smilies VALUES ( ':7)', 'private.gif', 'Secret');
INSERT INTO smilies VALUES ( ':x)', 'xmas.gif', 'Christmas');
INSERT INTO smilies VALUES ( ':9)', 'kiss.gif', 'Kiss, Kiss');
INSERT INTO smilies VALUES ( ':1]', 'karate.gif', 'Karate');
INSERT INTO smilies VALUES ( ':2]', 'cold.gif', 'Cold');
INSERT INTO smilies VALUES ( ':3]', 'devil.gif', 'Devil');
INSERT INTO smilies VALUES ( ':4]', 'tongue2.gif', 'So Nyah!');
INSERT INTO smilies VALUES ( ':5]', 'redhot.gif', 'Red Hot');
INSERT INTO smilies VALUES ( ':6]', 'smash.gif', 'Smash!');
INSERT INTO smilies VALUES ( ':7]', 'frosty.gif', 'Frosty');
INSERT INTO smilies VALUES ( ':8]', 'confused2.gif', 'Confused again');
INSERT INTO smilies VALUES ( ':9]', 'kaioken.gif', 'KAI');
INSERT INTO smilies VALUES ( ':1}', 'vampire.gif', 'Vampire');
INSERT INTO smilies VALUES ( ':2}', 'splat.gif', 'Splat');
INSERT INTO smilies VALUES ( ':3}', 'rwb.gif', 'Flag Smiley');
INSERT INTO smilies VALUES ( ':4}', 'FRlol.gif', 'LOL2');
INSERT INTO smilies VALUES ( ':5}', 'goodbad.gif', 'Good / Bad');
INSERT INTO smilies VALUES ( ':6}', 'eek2.gif', 'EEEEK');
INSERT INTO smilies VALUES ( ':7}', 'dodgy.gif', 'Dodgy');
INSERT INTO smilies VALUES ( ':8}', 'bawling.gif', 'Bawling');
INSERT INTO smilies VALUES ( ':9}', 'party.gif', 'Party on, Garth!');
INSERT INTO smilies VALUES ( ':ni', 'nighty.gif', 'Nightey, Night!');
INSERT INTO smilies VALUES ( ':wa', 'wavey.gif', 'Wave!');
INSERT INTO smilies VALUES ( ':pa', 'patty.gif', 'Patty');
INSERT INTO smilies VALUES ( ':al', 'alarm.gif', 'Alarm');
INSERT INTO smilies VALUES ( ':ba', 'barf.gif', 'Barf!');
INSERT INTO smilies VALUES ( ':bd', 'birthday.gif', 'Birthday');
INSERT INTO smilies VALUES ( ':bu', 'bubble.gif', 'bubble');
INSERT INTO smilies VALUES ( ':ca', 'cat.gif', 'Kitty');
INSERT INTO smilies VALUES ( ':ce', 'censored.gif', 'Censor');
INSERT INTO smilies VALUES ( ':ch', 'cheers.gif', 'Cheers');
INSERT INTO smilies VALUES ( ':co', 'cowboy.gif', 'Cowboy');
INSERT INTO smilies VALUES ( ':da', 'dance.gif', 'Dancing');
INSERT INTO smilies VALUES ( ':gr', 'dance1.gif', 'Dancing Stick');
INSERT INTO smilies VALUES ( ':du', 'dunce.gif', 'Dunce');
INSERT INTO smilies VALUES ( ':fi', 'finger.gif', 'Bird');
INSERT INTO smilies VALUES ( ':fe', 'flame.gif', 'Flame');
INSERT INTO smilies VALUES ( ':fg', 'flaming.gif', 'Flaming');
INSERT INTO smilies VALUES ( ':fl', 'flower2.gif', 'Flower2');
INSERT INTO smilies VALUES ( ':hi', 'hippie.gif', 'Hippie');
INSERT INTO smilies VALUES ( ':jo', 'joker.gif', 'Jester');
INSERT INTO smilies VALUES ( ':kn', 'knight.gif', 'Knight');
INSERT INTO smilies VALUES ( ':ko', 'koolaid.gif', 'KoolAid');
INSERT INTO smilies VALUES ( ':lo', 'looney.gif', 'Looney');
INSERT INTO smilies VALUES ( ':pi', 'pimp.gif', 'Pimp');
INSERT INTO smilies VALUES ( ':fy', 'mfinger.gif', 'Monkey Bird');
INSERT INTO smilies VALUES ( ':pu', 'pukeface.gif', 'Puke');
INSERT INTO smilies VALUES ( ':no', 'no.gif', 'NO!');
INSERT INTO smilies VALUES ( ':ro', 'rosie.gif', 'Rosy Cheeks');
INSERT INTO smilies VALUES ( ':sh', 'shudder.gif', 'Shudder');
INSERT INTO smilies VALUES ( ':si', 'sick.gif', 'Sick');
INSERT INTO smilies VALUES ( ':sm', 'smoker.gif', 'Smokin');
INSERT INTO smilies VALUES ( ':se', 'sperm.gif', 'Sperm');
INSERT INTO smilies VALUES ( ':to', 'tomato.gif', 'tomato');
INSERT INTO smilies VALUES ( ':tu', 'tut.gif', 'King Tut');
INSERT INTO smilies VALUES ( ':ty', 'type.gif', 'Typing');
INSERT INTO smilies VALUES ( ':wh', 'whip.gif', 'Whip It!');
INSERT INTO smilies VALUES ( ':ja', 'whoa.gif', 'Jaw Dropping');
