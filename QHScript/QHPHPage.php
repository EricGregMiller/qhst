<?php
require 'QHPage.php';

class QHPHPage extends QHPage
{
  function ShortcutIcon()
  {
    print (' <link rel="shortcut icon" href="/Master/qhph.ico" />'."\n");
  }

  function StyleSheet()
  {
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n");
  }

  function SetTopImages()
  {
    $this->homeAdd = "/QHPH";
    $this->topImg = "QHPHLogo50.png";
    $this->topAlt = "Quartz Hill Publishing House";
    $this->tabSet = "QHPH";
  }

  function SetButtons()
  {
    $this->PrintButton("/QHPH", "Home");
    $this->PrintButton("/QHPH/contact.html", "Contact Us");
  }

  function Copyright()
  {
    print ('      <p>Copyright &copy; Quartz Hill Publishing House. '."\n");
  }
} // End of class
?>
