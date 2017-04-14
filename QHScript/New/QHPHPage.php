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
    $this->homeAdd = "/publishing.html";
    $this->topImg = "QHPHLogoTitle.gif";
    $this->tabSet = "QHPH";
  }

  function SetButtons()
  {
  }

  function Copyright()
  {
    print ('      <p><FONT SIZE="-1">Copyright &copy; Quartz Hill Publishing House. <br>'."\n");
  }
} // End of class
?>
