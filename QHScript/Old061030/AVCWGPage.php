<?php
require 'QHPage.php';

class AVCWGPage extends QHPage
{
  function ShortcutIcon()
  {
    print (' <link rel="shortcut icon" href="/Master/avcwg.ico" />'."\n");
  }

  function StyleSheet()
  {
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n");
  }

  function SetTopImages()
  {
    $this->homeAdd = "/writers/";
    $this->topImg = "AVCWGTop";
    $this->leftTopImg = "AVCWGLeftTop";
  }

  function SetButtons()
  {
    $this->PrintButton("/writers/conference.html ", "conference", 13);
    $this->PrintButton("/becomeachristian.html", "christian", 2);
    $this->PrintButton("/publishing.html", "publishing", 14);
    $this->PrintButton("/more.htm", "journal", 10);
    $this->PrintButton("/index.html", "theology", 15);
    $this->PrintButton("/QHCC/church.htm", "church", 12);
  }

  function Copyright()
  {
    print ('      <P><FONT SIZE="-1">Copyright &copy; Antelope Valley Christian Writers Guild. <BR>'."\n");
  }
} // End of class
?>
