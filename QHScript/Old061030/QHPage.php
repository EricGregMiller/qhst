<?php
class QHPage
{

  var $requestUri;
  var $webRoot;
  
  var $homeAdd;
  var $topImg;
  var $leftTopImg;
  
  function ShortcutIcon()
  {
  }

  function StyleSheet()
  {
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n");
  }

  function HeadEnd()
  {
    $this->ShortcutIcon();
    $this->StyleSheet();
    print (' <script src="/Master/NavigateButtonSupport.js"></script>'."\n");
  }

  function PrintButton($href, $buttonImage, $buttonNum)
  {
    print("        <a href=\"$href\" onMouseOver=\"ChangeButtonImage(this,$buttonNum,'on')\" ");
    print("onMouseOut=\"ChangeButtonImage(this,$buttonNum)\">\n");
    print("          <img src=/Master/button/$buttonImage.jpg width=\"151\" height=\"33\" border=\"0\"></A><br>\n");
  }

  function SetTopImages()
  {
    $this->homeAdd = "/";
    $this->topImg = "top1";
    $this->leftTopImg = "lefttop";
  }

  function SetButtons()
  {
  }

  function PageBegin()
  {
    // Set top of page.
    $this->SetTopImages();
    print('<table width="100%" border="0" cellspacing="0" cellpadding="0">'."\n");
    print('  <tr> '."\n");
    print("    <td colspan=\"2\" background=\"/Master/topbg.jpg\">\n");
    print("      <a href=\"$this->homeAdd\"><img src=\"/Master/$this->topImg.jpg\" width=\"383\" height=\"92\" border= \"0\"></td>\n");
    print('  </tr>'."\n");
    print('  <tr> '."\n");
    print('    <td width="11%" background="/Master/left.jpg" valign="top"> '."\n");
    print("      <p><a href=\"/\"><img src=\"/Master/$this->leftTopImg.jpg\" width=\"151\" height=\"134\" border=\"0\"></a><br>\n");

    // Set control buttons
    $this->SetButtons();
    print('        <img src="/Master/bot.jpg" width="151" height="60"><br>'."\n");
    print('      </p>'."\n");
    print('      <p>&nbsp;</p>'."\n");
    print('      <p>&nbsp;</p>'."\n");
    print('      <p>&nbsp;</p>'."\n");
    print('      <p>&nbsp;</p>'."\n");
    print('      <p>&nbsp; </p>'."\n");
    print('    </td>'."\n");
    print('    <td width="95%" valign="top"> '."\n");

  }

  function Copyright()
  {
    print ('      <P><FONT SIZE="-1">Copyright &copy; Quartz Hill School of Theology. <BR>'."\n");
  }

  function PageEnd()
  {
    // Google ad code
    print ('    <script type="text/javascript"><!--'."\n"); 
    print ('      google_ad_client = "pub-1971528834274288"'."\n");
    print ('      google_ad_width = 728'."\n");
    print ('      google_ad_height = 90'."\n");
    print ('      google_ad_format = "728x90_as"'."\n");
    print ('      google_ad_type = "text_image"'."\n");
    print ('      google_ad_channel =""'."\n");
    print ('      google_color_border = "C3D9FF"'."\n");
    print ('      google_color_bg = "6F7A9E"'."\n");
    print ('      google_color_link = "C3D9FF"'."\n");
    print ('      google_color_text = "C3D9FF"'."\n");
    print ('      google_color_url = "C3D9FF"'."\n");
    print ('    //--></script>'."\n"); 
    print ('    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"> </script>'."\n"); 

    // End of QH page.
    print ('      <hr>'."\n");

    // Copyright
    $this->Copyright();
    print ('      All Rights Reserved. <BR>'."\n");
    print ('      Graphics by <A href="http://www.webpagedesign.com.au">Art for the web</A></FONT></center></P>'."\n");
    
    // Close tables
    print ('      </td>'."\n");
    print ('  </tr>'."\n");
    print ('</table>'."\n");

  }

  function handler()
  {
    $ruri = $this->requestUri;
    //print "<p>filename = $ruri</p>\n";

    $currWorkDir = getcwd();
    $currWorkDir .= "/";

    //$cgi = new CGI;
    //print ($cgi->header(-type=>'text/html'));
    //header('Content-type: text/html');

    // Get the base path of the document directory in.
    $webRoot = $this->webRoot;
    $webRoot .= "/";
    //print "<p>webRoot = $webRoot</p>\n";
    $fqfFile = $this->requestUri;
    
    // Change web address to complete file path.
    //print "<p>fqfFile = $fqfFile</p>\n";
    if (preg_match("?^/?", $fqfFile))
    {
      $fqfFile = preg_replace("?^/?", $webRoot, $fqfFile);
    }
    else
    {
      $fqfFile = $currWorkDir . $fqfFile;
    }

    // Add index.htm(l) to file name if needed.
    //print "<p>fqfFile = $fqfFile</p>\n";
    if (is_dir($fqfFile))
    {
      if (!preg_match("?/$?", $fqfFile))
      {
        $fqfFile .= "/";
      }
      if (file_exists($fqfFile . "index.html"))
      {
        $fqfFile .= "index.html";
      }
      elseif (file_exists($fqfFile . "index.htm"))
      {
        $fqfFile .= "index.htm";
      }
    }
    //print "<p>fqfFile = $fqfFile</p>\n";

    if (file_exists($fqfFile))
    { // Found input file -- process it.
    
      $inputLines = file($fqfFile);
      
      // Loop through lines in file.
      foreach ($inputLines as $line)
      {
        // Suppress qhst lines that will be added by this script.
        $printLine = 1;
        if (preg_match("/link.*rel.*\"shortcut icon\".*href.*=.*Master.*\.ico/i", $line) || 
            preg_match("?link.*rel.*\"stylesheet\".*href.*=.*/Master/(QHST|QHCC)\.css?i", $line) || 
            preg_match("?\"/Master/NavigateButtonSupport\.js\"?i", $line) || 
            preg_match("?\"/Master/(QHST|QHCC|AVCWG)PageBegin\.js\"?i", $line) || 
            preg_match("?\"/Master/(QHST|QHCC|AVCWG)PageEnd\.js\"?i", $line))
        {
          $printLine = 0;
        }
        
        // Print end of head.
        if (preg_match("?</head?i", $line))
        {
          $this->HeadEnd();
        }
        
        // Print end of page.
        if (preg_match("?\</body?i", $line))
        {
          $this->PageEnd();
        }
        
        // Print file line.
        if ($printLine)
        {
          print $line;
        }
        
        // Print beginning of page.
        if (preg_match("?\<body?i", $line))
        {
          $this->PageBegin();
        }
      }
    }
    else
    { // Could not find input file -- build error page.
    
      print ("<html>\n");
      print ("<head>\n");
      print ("  <title>QHST File Not Found</title>\n");
      print ("  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n");

      $this->HeadEnd();

      print ("</head>\n");
      print ("<body>\n");

      $this->PageBegin();

      print ("    <h1>Web Page Not Found</h1>\n");
      print ("    <p>You tried to get to www.theology.edu$ruri.\n");
      print ("    <p>This web page could not be found on our site. If you typed the address\n");
      print ("       please check your typing. If you followed a link from another site you may want to contact them.\n");
      print ("       If you used a link on our site, we apologize for the \n");
      print ("       inconvenience. Feel feel to contact our <a HREF=\"mailto:administrator@theology.edu\"> web administrator</a> about it.\n");
      print ("    </p>\n");
      print ("       <p>You also might want to try our <a HREF=\"/search.html\"> search page</a> to find what you want.\n");
      print ("    </p>\n");
      print ("    <br>\n");
      print ("    <br>\n");

      $this->PageEnd();

      print ("</body>\n");
      print ("</html>\n");

    }
  }
} // End of class
?>
