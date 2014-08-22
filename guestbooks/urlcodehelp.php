<?
#################################################################################################
#
#  project           	: phpBook
#  filename          	: urlcodehelp.php
#  last modified by  	: Erich Fuchs
#  e-mail            	: office@smartisoft.com
#  purpose           	: Show's the URLCode Help
#
#################################################################################################

#  HTML Header Start
#################################################################################################

require ("config.php");

echo "<html>\n";
echo " <head>\n";
echo "  <title>$url_code_help</title>\n";
echo "  <link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">\n";
echo "  $languagemetatag\n";
echo "  <meta name=\"robots\" content=\"index, nofollow\">\n";
echo "  <meta name=\"revisit-after\" content=\"20 days\">\n";
echo " </head>\n";
echo "<body>\n";

?>

              SWF URL Code Format:<br>
              [swf width=244 height=39]http://www.domain.com/swf/log.swf[/swf]
              <p>IMG URL Code
                Format:<br>
                [img]http://www.domain.com/images/log.gif[/img] <br></p>
              <p>Email URL Code
                Format:<br>
                [email]webmaster@domain.com[/email]<br>
                <br>
                URL URL Code Format:<br>
                [url]http://www.domain.com[/url]<br>
                or<br>
                [url]www.domain.com[/url]<br>
                or<BR>
		[url=http://www.domain.com]Domain[/url]<BR>
		<br>
                Bold URL Code Format:<br>
                [b]Bold[/b]</p>
              <p>Italics URL
                Code Format:<br>
                [i]Italics[/i]</p>
              <p>Underline URL
                Code Format:<br>
                [u]Underline[/u]</p></font>
</body>
</html>
