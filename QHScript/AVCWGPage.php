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
    $this->topImg = "AVCWGLogo50.gif";
    $this->topAlt = "Antelope Valley Christian Writers Guild";
    $this->tabSet = "AVCWG";
  }

  function SetButtons()
  {
    //$this->PrintButton("/writers/conference.html ", "Conference");
  }

  function Copyright()
  {
    print ('      <p><FONT SIZE="-1">Copyright &copy; Antelope Valley Christian Writers Guild. <br>'."\n");
  }
} // End of class
?>
