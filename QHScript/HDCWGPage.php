<?php
require 'QHPage.php';

class HDCWGPage extends QHPage
{
  function ShortcutIcon()
  {
    print (' <link rel="shortcut icon" href="/Master/hdcwg.ico" />'."\n");
  }

  function StyleSheet()
  {
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n");
  }

  function SetTopImages()
  {
    $this->homeAdd = "/writers/";
    $this->topImg = "HDCWGLogoTitle.png";
    $this->topAlt = "High Desert Christian Writers Guild";
    $this->tabSet = "HDCWG";
  }

  function SetButtons()
  {
    $this->PrintButton("/writers", "Home");
    $this->PrintButton("http://www.avwriters.com", "Conference");
    $this->PrintButton("/writers/contact.html", "Contact Us");
  }

  function Copyright()
  {
    print ('      <p>Copyright &copy; High Desert Christian Writers Guild. '."\n");
  }
} // End of class
?>
