<?php
require 'QHPage.php';

class QHCCPage extends QHPage
{
  function ShortcutIcon()
  {
    print (' <link rel="shortcut icon" href="/Master/qhcc.ico" />'."\n");
  }

  function StyleSheet()
  {
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n");
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHCC.css" />'."\n");
  }

  function SetTopImages()
  {
    $this->homeAdd = "/QHCC/church.htm";
    $this->topImg = "QHCCLogoTitle.gif";
    $this->tabSet = "QHCC";
  }

  function SetButtons()
  {
    $this->PrintButton("/QHCC/announcements.html", "Announcements");
    $this->PrintButton("/QHCC/whatsup.html", "What We Do");
    $this->PrintButton("/QHCC/sermon.html", "This Week's Sermon");
    $this->PrintButton("/QHCC/deacons.html", "Servants");
    $this->PrintButton("/QHCC/location.html", "Map");
  }

  function Copyright()
  {
    print ('      <P><FONT SIZE="-1">Copyright &copy; Quartz Hill Community Church. <BR>'."\n");
  }
} // End of class
?>
