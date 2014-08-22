<?php
class QHPage
{

  var $requestUri;
  var $webRoot;
  
  var $homeAdd;
  var $topImg;
  var $tabSet;
  
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
  }

  function PrintButton($href, $buttonText)
  {
    print ('    <li>'."\n");
    print("       <a href=\"$href\">$buttonText</a>"."\n");
    print ('    </li>'."\n");
  }

  function SetTopImages()
  {
    $this->homeAdd = "/";
    $this->topImg = "QHSTLogoTitle.gif";
    $this->tabSet = "QHST";
  }

  function SetButtons()
  {
  }

  function PageBegin()
  {
    // ------------------    
    // Set top of page.
    // ------------------    
    $this->SetTopImages();
    // ------------------    
    // Header
    // ------------------    
    print ('<div id="Header" class="Header">'."\n");
    print ('  <a href="'.$this->homeAdd.'"><img src="/Master/'.$this->topImg.'" alt="Quartz Hill School of Theology"></a>'."\n");
    // ------------------    
    //   Header links
    // ------------------    
    print ('  <div id="HeaderLinks" class="HeaderLinks">'."\n");
    print ('    <div id="NavHead" class="NavHead">'."\n");
    print ('      <ul>'."\n");
    print ('        <li>'."\n");
    print ('          <a href="/becomeachristian.html">Christianity?</a>'."\n");
    print ('        </li>'."\n");
    print ('        <li>'."\n");
    print ('          <a href="/doctrinalstatement.html">We Believe</a>'."\n");
    print ('        </li>'."\n");
    print ('        <li>'."\n");
    print ('          <a href="/guestbook.html">Guestbook</a>'."\n");
    print ('        </li>'."\n");
    print ('      </ul>'."\n");
    print ('    </div>'."\n");
    // ------------------    
    //   Search
    // ------------------    
    print ('    <div id="Search" class="Search">'."\n");
    print ('      <!-- Search Google -->'."\n");
    print ('      <FORM method=GET action=http://www.google.com/custom>'."\n");
    print ('        <input type=text name=q size=25 maxlength=255 value="">'."\n");
    print ('        <!--<input type=submit name=sa value="Search">-->'."\n");
    print ('        <input type=image name=sa src="/Master/SearchButton.gif" border="0" width="60px" height="21px" align="absbottom">'."\n");
    print ('        <!-- Google box background, GL: 0 = white, 1 = gray, 2 = black -->'."\n");
    print ('        <input type=hidden name=cof value="GALT:#ffffff;S:http://www.theology.edu'.$this->homeAdd.';GL:2;VLC:#9999ff;AH:left;BGC:#6f7a9e;LH:83;LC:#99ccff;GFNT:#ffffff;L:http://www.theology.edu/Master/'.$this->topImg.';ALC:#99ccff;LW:428;T:#ffffff;GIMP:#ffffff;AWFID:daefd68b82f4aa6e;">'."\n");
    print ('        <input type=hidden name=domains value="theology.edu">'."\n");
    print ('        <br>'."\n");
    print ('        <input type=radio name=sitesearch value="">Search the Web'."\n");
    print ('        <input type=radio name=sitesearch value="theology.edu" checked>Search theology.edu'."\n");
    print ('      </FORM>'."\n");
    print ('      <!-- Search Google -->'."\n");
    print ('    </div>'."\n");
    print ('  </div>'."\n");
    print ('</div>'."\n");
    // ------------------    
    // Tabs
    // ------------------    
    print ('<div id="NavTab" class="NavTab">'."\n");
    print ('  <ul>'."\n");
    if (strcasecmp("QHST",$this->tabSet) == 0)
      print ('    <li id="NavTabSel">'."\n");
    else
      print ('    <li>'."\n");
    print ('      <a href="/">'."\n");
    print ('        <span>School</span></a>'."\n");
    print ('    </li>'."\n");
    if (strcasecmp("QHCC",$this->tabSet) == 0)
      print ('    <li id="NavTabSel">'."\n");
    else
      print ('    <li>'."\n");
    print ('      <a href="/QHCC/church.htm">'."\n");
    print ('        <span>Church</span></a>'."\n");
    print ('    </li>'."\n");
    if (strcasecmp("QHPH",$this->tabSet) == 0)
      print ('    <li id="NavTabSel">'."\n");
    else
      print ('    <li>'."\n");
    print ('      <a href="/publishing.html">'."\n");
    print ('        <span>Publishing</span></a>'."\n");
    print ('    </li>'."\n");
    if (strcasecmp("AVCWG",$this->tabSet) == 0)
      print ('    <li id="NavTabSel">'."\n");
    else
      print ('    <li>'."\n");
    print ('      <a href="/writers">'."\n");
    print ('        <span>Writers</span></a>'."\n");
    print ('    </li>'."\n");
    print ('  </ul>'."\n");
    print ('</div>'."\n");
    // ------------------    
    // Navigation bar
    // ------------------    
    print ('<div id="NavBar" class="NavBar">'."\n");
    print ('  <ul>'."\n");
    $this->SetButtons();
    print ('  </ul>'."\n");
    print ('</div>'."\n");
    // ------------------    
    // Google Ads
    // ------------------    
    print ('<div class="AdSense">'."\n");
    print ('  <script type="text/javascript"><!--'."\n");
    print ('  google_ad_client = "pub-1971528834274288";'."\n");
    print ('  google_ad_width = 120;'."\n");
    print ('  google_ad_height = 600;'."\n");
    print ('  google_ad_format = "120x600_as"'."\n");;
    print ('  google_ad_type = "text_image";'."\n");
    print ('  google_ad_channel = "";'."\n");
    print ('  google_color_border = "FFFFFF";'."\n");
    print ('  google_color_bg = "6F7A9E";'."\n");
    print ('  google_color_link = "C3D9FF";'."\n");
    print ('  google_color_text = "C3D9FF";'."\n");
    print ('  google_color_url = "C3D9FF";'."\n");
    print ('  //--></script>'."\n");
    print ('  <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">'."\n");
    print ('  </script>'."\n");
    print ('</div>'."\n");
    // ------------------    
    // Begin Content
    // ------------------    
    print('<div id="Content" class="Content">'."\n");
  }

  function Copyright()
  {
    print ('      <p><font size="-1">Copyright &copy; Quartz Hill School of Theology. <br>'."\n");
  }

  function PageEnd()
  {
    // ------------------    
    // Copyright
    // ------------------    
    $this->Copyright();
    print ('      All Rights Reserved. <br>'."\n");

    // ------------------    
    // End of content   
    // ------------------    
    print ('</div>'."\n");
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
