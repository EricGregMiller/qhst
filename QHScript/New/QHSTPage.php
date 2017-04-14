<?php
require 'QHPage.php';

class QHSTPage extends QHPage
{
  function ShortcutIcon()
  {
    print (' <link rel="shortcut icon" href="/Master/qhst.ico" />'."\n");
  }

  function StyleSheet()
  {
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n");
  }

  function SetTopImages()
  {
    $this->homeAdd = "/";
    $this->topImg = "QHSTLogoTitle.gif";
    $this->tabSet = "QHST";
  }

  function SetButtons()
  {
    $this->PrintButton("/welcome-.htm", "About Us");
    $this->PrintButton("/bookstor.htm", "Bookstore");
    $this->PrintButton("/catalog.htm", "Catalog");
    $this->PrintButton("/onlinecourses.html", "Courses");
    $this->PrintButton("/library.htm", "Library");
    $this->PrintButton("/more.htm", "The Journal");
    $this->PrintButton("/forum", "Areopagus");
  }

  function Copyright()
  {
    //print ('    <a href="/"><img alt="Return to QHST Homepage" border=0 src="/graphix/return.gif"></a>'."\n");
    print ('      <p><font size="-1">Copyright &copy; Quartz Hill School of Theology. <br>'."\n");
  }
} // End of class
?>
