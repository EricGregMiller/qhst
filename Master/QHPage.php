<?php
class QHPage
{

  var $requestUri;
  var $webRoot;
  
  var $homeAdd;
  var $topImg;
  var $topAlt;
  var $tabSet;

  var $imageNames = array("1johnsmall.jpg" => "/QHPH/1johnsmall.jpg",
                          "2corsmall.jpg" => "/QHPH/2corsmall.jpg",
                          "actssmall.jpg" => "/QHPH/actssmall.jpg",
                          "baptist.jpg" => "/QHPH/baptist.jpg",
                          "bensirasmall.jpg" => "/QHPH/bensirasmall.jpg",
                          "complaint.jpg" => "/QHPH/complaint.jpg",
                          "eccsmall.jpg" => "/QHPH/eccsmall.jpg",
                          "ezrasmall.jpg" => "/QHPH/ezrasmall.jpg",
                          "foursmall.jpg" => "/QHPH/foursmall.jpg",
                          "galsmall.jpg" => "/QHPH/galsmall.jpg",
                          "jamessmall.jpg" => "/QHPH/jamessmall.jpg",
                          "jeremiahsmall.jpg" => "/QHPH/jeremiahsmall.jpg",
                          "jimbiblestudy.jpg" => "/QHPH/jimbiblestudy.jpg",
                          "jimtheology.jpg" => "/QHPH/jimtheology.jpg",
                          "johnapocalypse.jpg" => "/QHPH/johnapocalypse.jpg",
                          "matthewsmall.jpg" => "/QHPH/matthewsmall.jpg",
                          "nightthoughtssmall.jpg" => "/QHPH/nightthoughtssmall.jpg",
                          "pastoralsmall.jpg" => "/QHPH/pastoralsmall.jpg",
                          "psalm1small.jpg" => "/QHPH/psalm1small.jpg",
                          "psalm2small.jpg" => "/QHPH/psalm2small.jpg",
                          "ruthsmall.jpg" => "/QHPH/ruthsmall.jpg",
                          "seventhchildsmall.jpg" => "/QHPH/seventhchildsmall.jpg",
                          "smallspring2006.jpg" => "/QHPH/smallspring2006.jpg", 
                          "summary.jpg" => "/QHPH/summary.jpg", 
                          "a130X70wb.gif" => "/QHST/Images/a130X70wb.gif", 
                          "adobereader.gif" => "/QHST/Images/adobereader.gif", 
                          "all4one.gif" => "/QHST/Images/all4one.gif", 
                          "alot468x60a3.gif" => "/QHST/Images/alot468x60a3.gif", 
                          "altavist.gif" => "/QHST/Images/altavist.gif", 
                          "amzn-b1.gif" => "/QHST/Images/amzn-b1.gif", 
                          "amzn-b3.gif" => "/QHST/Images/amzn-b3.gif", 
                          "amzn-b4.gif" => "/QHST/Images/amzn-b4.gif", 
                          "amzn-b6.gif" => "/QHST/Images/amzn-b6.gif", 
                          "amzn-bm1.gif" => "/QHST/Images/amzn-bm1.gif", 
                          "amzn-bm2.gif" => "/QHST/Images/amzn-bm2.gif", 
                          "amzn-fa1.gif" => "/QHST/Images/amzn-fa1.gif", 
                          "animated-associates-button.gif" => "/QHST/Images/animated-associates-button.gif", 
                          "antediluviantiny.png" => "/QHST/Images/antediluviantiny.png", 
                          "archive.gif" => "/QHST/Images/archive.gif", 
                          "archivesmall.jpg" => "/QHST/Images/archivesmall.jpg", 
                          "areopagus.jpg" => "/QHST/Images/areopagus.jpg", 
                          "bestof.gif" => "/QHST/Images/bestof.gif", 
                          "bibliotk.gif" => "/QHST/Images/bibliotk.gif", 
                          "blank.jpg" => "/QHST/Images/blank.jpg", 
                          "blue.gif" => "/QHST/Images/blue.gif", 
                          "booksale.jpg" => "/QHST/Images/booksale.jpg", 
                          "bookstore.jpg" => "/QHST/Images/bookstore.jpg", 
                          "camera.jpg" => "/QHST/Images/camera.jpg", 
                          "cartweel.gif" => "/QHST/Images/cartweel.gif", 
                          "christina.jpg" => "/QHST/Images/christina.jpg", 
                          "churchmap.jpg" => "/QHST/Images/churchmap.jpg", 
                          "clock468x60a3.gif" => "/QHST/Images/clock468x60a3.gif", 
                          "cnsearch.gif" => "/QHST/Images/cnsearch.gif", 
                          "course.jpg" => "/QHST/Images/course.jpg", 
                          "coursebutton.jpg" => "/QHST/Images/coursebutton.jpg", 
                          "cross.gif" => "/QHST/Images/cross.gif", 
                          "cross2.gif" => "/QHST/Images/cross2.gif", 
                          "cross3.gif" => "/QHST/Images/cross3.gif", 
                          "cross4.gif" => "/QHST/Images/cross4.gif", 
                          "cross_sh.gif" => "/QHST/Images/cross_sh.gif", 
                          "cuneifrm.gif" => "/QHST/Images/cuneifrm.gif", 
                          "dave.jpg" => "/QHST/Images/dave.jpg", 
                          "deacondrew.jpg" => "/QHST/Images/deacondrew.jpg", 
                          "deaconrex.jpg" => "/QHST/Images/deaconrex.jpg", 
                          "deaconrick.jpg" => "/QHST/Images/deaconrick.jpg", 
                          "deaconrobin.jpg" => "/QHST/Images/deaconrobin.jpg", 
                          "deaconsherman.jpg" => "/QHST/Images/deaconsherman.jpg", 
                          "dennis.gif" => "/QHST/Images/dennis.gif", 
                          "dilbert2.gif" => "/QHST/Images/dilbert2.gif", 
                          "dilbert3.gif" => "/QHST/Images/dilbert3.gif", 
                          "dilbert4.gif" => "/QHST/Images/dilbert4.gif", 
                          "dilbert_.gif" => "/QHST/Images/dilbert_.gif", 
                          "dip.gif" => "/QHST/Images/dip.gif", 
                          "diploma.jpg" => "/QHST/Images/diploma.jpg", 
                          "doctrine.jpg" => "/QHST/Images/doctrine.jpg", 
                          "don.gif" => "/QHST/Images/don.gif", 
                          "don.jpg" => "/QHST/Images/don.jpg", 
                          "drim1.gif" => "/QHST/Images/drim1.gif", 
                          "drim2.gif" => "/QHST/Images/drim2.gif", 
                          "dss01.gif" => "/QHST/Images/dss01.gif", 
                          "dss02.gif" => "/QHST/Images/dss02.gif", 
                          "dss03.gif" => "/QHST/Images/dss03.gif", 
                          "east_can.gif" => "/QHST/Images/east_can.gif", 
                          "egypt2.gif" => "/QHST/Images/egypt2.gif", 
                          "el.jpg" => "/QHST/Images/el.jpg", 
                          "enuma_el.gif" => "/QHST/Images/enuma_el.gif", 
                          "estrvigl.gif" => "/QHST/Images/estrvigl.gif", 
                          "euler1.gif" => "/QHST/Images/euler1.gif", 
                          "euler2.gif" => "/QHST/Images/euler2.gif", 
                          "euler3.gif" => "/QHST/Images/euler3.gif", 
                          "excite.gif" => "/QHST/Images/excite.gif", 
                          "farvardyn.jpg" => "/QHST/Images/farvardyn.jpg", 
                          "Farvardyn-logo.gif" => "/QHST/Images/Farvardyn-logo.gif", 
                          "goshenfr.gif" => "/QHST/Images/goshenfr.gif", 
                          "greek.gif" => "/QHST/Images/greek.gif", 
                          "greek.jpg" => "/QHST/Images/greek.jpg", 
                          "guestbok.jpg" => "/QHST/Images/guestbok.jpg", 
                          "hip.gif" => "/QHST/Images/hip.gif", 
                          "hnettiny.gif" => "/QHST/Images/hnettiny.gif", 
                          "holocaust.jpg" => "/QHST/Images/holocaust.jpg", 
                          "holy_thu.gif" => "/QHST/Images/holy_thu.gif", 
                          "icq.gif" => "/QHST/Images/icq.gif", 
                          "icqdownload.gif" => "/QHST/Images/icqdownload.gif", 
                          "ie_stand.gif" => "/QHST/Images/ie_stand.gif", 
                          "ie_stati.gif" => "/QHST/Images/ie_stati.gif", 
                          "in-assoc.gif" => "/QHST/Images/in-assoc.gif", 
                          "infomine2.jpg" => "/QHST/Images/infomine2.jpg", 
                          "infoseek.gif" => "/QHST/Images/infoseek.gif", 
                          "inheritancetiny.jpg" => "/QHST/Images/inheritancetiny.jpg", 
                          "inheritancetiny.png" => "/QHST/Images/inheritancetiny.png", 
                          "innerbeautysmall.jpg" => "/QHST/Images/innerbeautysmall.jpg", 
                          "judy.jpg" => "/QHST/Images/judy.jpg", 
                          "jw.jpg" => "/QHST/Images/jw.jpg", 
                          "jwest2.gif" => "/QHST/Images/jwest2.gif", 
                          "kathy.jpg" => "/QHST/Images/kathy.jpg", 
                          "kelly.gif" => "/QHST/Images/kelly.gif", 
                          "lavaness.jpg" => "/QHST/Images/lavaness.jpg", 
                          "lavannes.jpg" => "/QHST/Images/lavannes.jpg", 
                          "left.jpg" => "/QHST/Images/left.jpg", 
                          "legalus.gif" => "/QHST/Images/legalus.gif", 
                          "library.gif" => "/QHST/Images/library.gif", 
                          "logo-plain.gif" => "/QHST/Images/logo-plain.gif", 
                          "logo_mic.gif" => "/QHST/Images/logo_mic.gif", 
                          "lycos.gif" => "/QHST/Images/lycos.gif", 
                          "m31g1.gif" => "/QHST/Images/m31g1.gif", 
                          "m31g1.jpg" => "/QHST/Images/m31g1.jpg", 
                          "mail.gif" => "/QHST/Images/mail.gif", 
                          "marble.jpg" => "/QHST/Images/marble.jpg", 
                          "mckinley.gif" => "/QHST/Images/mckinley.gif", 
                          "moontiny.jpg" => "/QHST/Images/moontiny.jpg", 
                          "mp3x.gif" => "/QHST/Images/mp3x.gif", 
                          "musicteam.jpg" => "/QHST/Images/musicteam.jpg", 
                          "mvsquare.gif" => "/QHST/Images/mvsquare.gif", 
                          "nav_logo.gif" => "/QHST/Images/nav_logo.gif", 
                          "netnow3.gif" => "/QHST/Images/netnow3.gif", 
                          "new-seal.gif" => "/QHST/Images/new-seal.gif", 
                          "new2.gif" => "/QHST/Images/new2.gif", 
                          "nice.jpg" => "/QHST/Images/nice.jpg", 
                          "people.jpg" => "/QHST/Images/people.jpg", 
                          "people2.jpg" => "/QHST/Images/people2.jpg", 
                          "pix1.gif" => "/QHST/Images/pix1.gif", 
                          "pix2.gif" => "/QHST/Images/pix2.gif", 
                          "pix3.gif" => "/QHST/Images/pix3.gif", 
                          "pix4.gif" => "/QHST/Images/pix4.gif", 
                          "pix5.gif" => "/QHST/Images/pix5.gif", 
                          "purple.gif" => "/QHST/Images/purple.gif", 
                          "qhjtsmall.jpg" => "/QHST/Images/qhjtsmall.jpg", 
                          "qhphlogo2.jpg" => "/QHST/Images/qhphlogo2.jpg", 
                          "qhphlogo3.jpg" => "/QHST/Images/qhphlogo3.jpg", 
                          "qhst.jpg" => "/QHST/Images/qhst.jpg", 
                          "qhstlogo.jpg" => "/QHST/Images/qhstlogo.jpg", 
                          "qhstlogosearch.jpg" => "/QHST/Images/qhstlogosearch.jpg", 
                          "real.gif" => "/QHST/Images/real.gif", 
                          "return.gif" => "/QHST/Images/return.gif", 
                          "rhebus.gif" => "/QHST/Images/rhebus.gif", 
                          "rkaf1.gif" => "/QHST/Images/rkaf1.gif", 
                          "robinbookbanner.jpg" => "/QHST/Images/robinbookbanner.jpg", 
                          "robinbookbanner2.jpg" => "/QHST/Images/robinbookbanner2.jpg", 
                          "robinbookbanner2x.jpg" => "/QHST/Images/robinbookbanner2x.jpg", 
                          "robinbookbanner2y.jpg" => "/QHST/Images/robinbookbanner2y.jpg", 
                          "robinbookbanner2z.jpg" => "/QHST/Images/robinbookbanner2z.jpg", 
                          "robinbookbanner33.jpg" => "/QHST/Images/robinbookbanner33.jpg", 
                          "robinbookbannerx.jpg" => "/QHST/Images/robinbookbannerx.jpg", 
                          "rpnbook2.jpg" => "/QHST/Images/rpnbook2.jpg", 
                          "ruth.jpg" => "/QHST/Images/ruth.jpg", 
                          "saved.jpg" => "/QHST/Images/saved.jpg", 
                          "schpress.gif" => "/QHST/Images/schpress.gif", 
                          "seal-01.gif" => "/QHST/Images/seal-01.gif", 
                          "seal-02.gif" => "/QHST/Images/seal-02.gif", 
                          "seal-03.gif" => "/QHST/Images/seal-03.gif", 
                          "seal-04.gif" => "/QHST/Images/seal-04.gif", 
                          "seal-05.gif" => "/QHST/Images/seal-05.gif", 
                          "seal-06.gif" => "/QHST/Images/seal-06.gif", 
                          "search.gif" => "/QHST/Images/search.gif", 
                          "search.jpg" => "/QHST/Images/search.jpg", 
                          "shop.gif" => "/QHST/Images/shop.gif", 
                          "silver_theology_8.JPG" => "/QHST/Images/silver_theology_8.JPG", 
                          "software.jpg" => "/QHST/Images/software.jpg", 
                          "somewhenobscurelytiny.jpg" => "/QHST/Images/somewhenobscurelytiny.jpg", 
                          "soundamp.gif" => "/QHST/Images/soundamp.gif", 
                          "squaropo.gif" => "/QHST/Images/squaropo.gif", 
                          "stations.gif" => "/QHST/Images/stations.gif", 
                          "stephanie.jpg" => "/QHST/Images/stephanie.jpg", 
                          "studentstore.jpg" => "/QHST/Images/studentstore.jpg", 
                          "studentstore01a.jpg" => "/QHST/Images/studentstore01a.jpg", 
                          "sunrise.gif" => "/QHST/Images/sunrise.gif", 
                          "tiles.jpg" => "/QHST/Images/tiles.jpg", 
                          "top.jpg" => "/QHST/Images/top.jpg", 
                          "top1.jpg" => "/QHST/Images/top1.jpg", 
                          "top3.jpg" => "/QHST/Images/top3.jpg", 
                          "topbg.jpg" => "/QHST/Images/topbg.jpg", 
                          "twobytwo.gif" => "/QHST/Images/twobytwo.gif", 
                          "ugar.gif" => "/QHST/Images/ugar.gif", 
                          "wa-button.gif" => "/QHST/Images/wa-button.gif", 
                          "water.gif" => "/QHST/Images/water.gif", 
                          "webcastsmall.jpg" => "/QHST/Images/webcastsmall.jpg", 
                          "webcrawl.gif" => "/QHST/Images/webcrawl.gif", 
                          "whatson.jpg" => "/QHST/Images/whatson.jpg", 
                          "winamp-miniban.gif" => "/QHST/Images/winamp-miniban.gif", 
                          "wrapping.gif" => "/QHST/Images/wrapping.gif", 
                          "wznow2.gif" => "/QHST/Images/wznow2.gif", 
                          "xaudio-shadow.gif" => "/QHST/Images/xaudio-shadow.gif", 
                          "yahoo.gif" => "/QHST/Images/yahoo.gif");

  function NewImageName($iImageName)
  {
    $in = preg_replace('?^.*theology.edu?i', '', $iImageName);
    $in = preg_replace('?^/?', '', $in);

    $newImageName = $this->imageNames[$in];
    
    return $newImageName;
  }

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
    $this->topAlt = "Quartz Hill School of Theology";
    $this->tabSet = "QHST";
  }

  function SetTabs($iFoot)
  {
    // Set info for head tabs.
    $selClass = "NavTabSel";
    $spanOpen = "<span>";
    $spanClose = "</span>";
    
    if ($iFoot)
    { // Set info for foot tabs.
      $selClass = "NavTabSel NavTabSelFoot";
      $spanOpen = "";
      $spanClose = "";
    }
    
    // Print tabs
    if (strcasecmp("QHST",$this->tabSet) == 0)
      print ("    <li class=\"".$selClass."\">\n");
    else
      print ("    <li>\n");
    print ("      <a href=\"/\">".$spanOpen."School".$spanClose."</a>\n");
    print ("    </li>\n");
    if (strcasecmp("QHCC",$this->tabSet) == 0)
      print ("    <li class=\"".$selClass."\">\n");
    else
      print ("    <li>\n");
    print ("      <a href=\"/QHCC\">".$spanOpen."Church".$spanClose."</a>\n");
    print ("    </li>\n");
    if (strcasecmp("QHPH",$this->tabSet) == 0)
      print ("    <li class=\"".$selClass."\">\n");
    else
      print ("    <li>\n");
    print ("      <a href=\"/QHPH\">".$spanOpen."Publishing".$spanClose."</a>\n");
    print ("    </li>\n");
    /* No more writers group
    if (strcasecmp("HDCWG",$this->tabSet) == 0)
      print ("    <li class=\"".$selClass."\">\n");
    else
      print ("    <li>\n");
    print ("      <a href=\"/writers\">".$spanOpen."Writers".$spanClose."</a>\n");
    print ("    </li>\n");
    */
    if (strcasecmp("Remata",$this->tabSet) == 0)
      print ("    <li class=\"".$selClass."\">\n");
    else
      print ("    <li>\n");
    print ("      <a href=\"/Remata\">".$spanOpen."Remata".$spanClose."</a>\n");
    print ("    </li>\n");
  }

  function SetButtons()
  {
  }

  function PrintAdSenseSearchClient()
  {
    print ('        <input type="hidden" name="client" value="pub-1971528834274288"/>'."\n");
  }

  function PrintAdSenseClient()
  {
    print ('  google_ad_client = "pub-1971528834274288";'."\n");
  }

  function PageBegin($showAds)
  {
    // ------------------    
    // Set top of page.
    // ------------------    
    $this->SetTopImages();
    // ------------------    
    // Page setup
    // ------------------    
    print('<div id="PageWrap">'."\n");
    print('<div id="MainSidebar"></div>'."\n");
    print('<div id="PagePad">'."\n");
    
    // ------------------    
    // Header
    // ------------------    
    print ('<div class="Header">'."\n");
    print ('  <a href="'.$this->homeAdd.'"><img src="/Master/'.$this->topImg.'" alt="'.$this->topAlt.'"/></a>'."\n");
    // ------------------    
    //   Header links
    // ------------------    
    print ('  <div class="HeaderLinks">'."\n");
    print ('    <div class="NavHead">'."\n");
    print ('      <ul>'."\n");
    print ('        <li>'."\n");
    print ('          <a href="/becomeachristian.html">Christianity?</a>'."\n");
    print ('        </li>'."\n");
    print ('        <li>'."\n");
    print ('          <a href="/doctrinalstatement.html">We Believe</a>'."\n");
    print ('        </li>'."\n");
    print ('      </ul>'."\n");
    print ('    </div>'."\n");
    // ------------------    
    //   Search
    // ------------------    
    print ('    <div class="Search">'."\n");
    print ('      <!-- SiteSearch Google -->'."\n");
    print ('      <form method="get" action="http://www.google.com/custom" target="_top">'."\n");
    print ('        <input type="hidden" name="domains" value="www.theology.edu"/>'."\n");
    print ('        <input type="text" name="q" size="20" maxlength="255" value=""/>'."\n");
    print ('        <input type="submit" name="sa" value="Google Search"/>'."\n");
    print ('        <br>'."\n");
    print ('        <input type="radio" name="sitesearch" value=""/>'."\n");
    print ('        <font size="-1">Web</font>'."\n");
    print ('        <input type="radio" name="sitesearch" value="www.theology.edu" checked="checked"/>'."\n");
    print ('        <font size="-1">www.theology.edu</font>'."\n");
    $this->PrintAdSenseSearchClient();
    print ('        <input type="hidden" name="forid" value="1"/>'."\n");
    print ('        <input type="hidden" name="ie" value="ISO-8859-1"/>'."\n");
    print ('        <input type="hidden" name="oe" value="ISO-8859-1"/>'."\n");
    print ('        <input type="hidden" name="cof" value="GALT:#C3D9FF;GL:1;DIV:#FFFFFF;VLC:9999FF;AH:center;BGC:6F7A9E;LBGC:8E9CCB;ALC:C3D9FF;LC:C3D9FF;T:C3D9FF;GFNT:FFFFFF;GIMP:FFFFFF;LH:50;LW:258;L:http://theology.edu/Master/'.$this->topImg.';S:http://www.theology.edu'.$this->homeAdd.';FORID:1"/>'."\n");
    print ('        <input type="hidden" name="hl" value="en"/>'."\n");
    print ('      </form>'."\n");
    print ('      <!-- SiteSearch Google -->'."\n");
    print ('    </div>'."\n");
    print ('  </div>'."\n");
    print ('</div>'."\n");
    // ------------------    
    // Google Ads
    // ------------------    
    print ('<div class="AdSense">'."\n");
    if ($showAds)
    {
      print ('  <script type="text/javascript"><!--'."\n");
      $this->PrintAdSenseClient();
      print ('  /* Absolution header (728x90) */'."\n");
      print ('  google_ad_slot = "9045468310";'."\n");;
      print ('  google_ad_width = 728;'."\n");
      print ('  google_ad_height = 90;'."\n");
      print ('  //--></script>'."\n");
      print ('  <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">'."\n");
      print ('  </script>'."\n");
    }
    print ('</div>'."\n");
    // ------------------    
    // Tabs
    // ------------------    
    print ('<div class="NavTab">'."\n");
    print ('  <ul>'."\n");
    $this->SetTabs(0);
    print ('  </ul>'."\n");
    print ('</div>'."\n");
    // ------------------    
    // Navigation bar
    // ------------------    
    print ('<div class="NavBar">'."\n");
    print ('  <ul>'."\n");
    $this->SetButtons();
    print ('  </ul>'."\n");
    print ('</div>'."\n");
    // ------------------    
    // Begin Content
    // ------------------    
    print('<div id="Content">'."\n");
  }

  function Copyright()
  {
    print ('      <p>Copyright &copy; Quartz Hill School of Theology. '."\n");
  }

  function PageEnd()
  {
    // ------------------    
    // End of content
    // ------------------    
    print ('</div> // End Content'."\n");

    // ------------------    
    // Navigation foot
    // ------------------    
    print ('<br>'."\n");
    print ('<div class="NavTab NavTabFoot">'."\n");
    print ('  <ul>'."\n");
    $this->SetTabs(1);
    print ('    <li>'."\n");
    print ('      <a href="/becomeachristian.html">Christianity?</a>'."\n");
    print ('    </li>'."\n");
    print ('    <li>'."\n");
    print ('      <a href="/doctrinalstatement.html">We Believe</a>'."\n");
    print ('    </li>'."\n");
    print ('  </ul>'."\n");
    print ('</div>'."\n");
    
    // ------------------    
    // Navigation foot 2
    // ------------------    
    print ('<div class="NavBar">'."\n");
    print ('  <ul>'."\n");
    $this->SetButtons();
    print ('  </ul>'."\n");
    print ('</div>'."\n");
    
    // ------------------    
    // Copyright
    // ------------------    
    print ('<div class="Copyright">'."\n");
    $this->Copyright();
    print ('      All Rights Reserved.<p>'."\n");
    print ('</div>'."\n");

    // ------------------    
    // End of page
    // ------------------    
    print ('</div> // End PagePad'."\n"); 
    print('<div id="SecondarySidebar"></div>'."\n");
    print ('</div> // End PageWrap'."\n"); 
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
          // Fix images
          $imgOffset = 0;
          while (preg_match('/< *img[^>]*src *= *[\'"]([^\'"]+)[\'"]/i', $line, $matches, PREG_OFFSET_CAPTURE, $imgOffset))
	  {
            $imgOffset = $matches[1][1];
            //print ("imgOffset = " . $imgOffset . "\n");
            $imageName = $matches[1][0];
            //print ("imageName = " . $imageName . "\n");
            $newImageName = $this->NewImageName($imageName);
            //print ("newImageName = " . $newImageName . "\n");
            //$line = preg_replace('/srcfix/i', 'src', $line, 1);
            if ($newImageName)
	    {
              $line = preg_replace('"'.$imageName.'"', $newImageName, $line);
            }
	  }
        
          print $line;
        }
        
        // Print beginning of page.
        if (preg_match("?\<body?i", $line))
        {
          $this->PageBegin(1);
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

      $this->PageBegin(0);

      print ("    <h1>Web Page Not Found</h1>\n");
      print ("    <p>You tried to get to www.theology.edu$ruri.\n");
      print ("    <p>This web page could not be found on our site. If you typed the address\n");
      print ("       please check your typing. If you followed a link from another site you may want to contact them.\n");
      print ("       If you used a link on our site, we apologize for the \n");
      print ("       inconvenience. Feel feel to contact our <a HREF=\"mailto:administrator@theology.edu\"> web administrator</a> about it.\n");
      print ("    </p>\n");
      print ("       <p>You can also try using the Google search at the top of the page to find what you want.\n");
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
