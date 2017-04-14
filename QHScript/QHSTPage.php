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
    $this->topImg = "QHSTLogo50.png";
    $this->topAlt = "Quartz Hill School of Theology";
    $this->tabSet = "QHST";
  }

  function SetButtons()
  {
    $this->PrintButton("/", "Home");
    $this->PrintButton("/QHST/welcome.html", "About Us");
    $this->PrintButton("/QHST/Bookstore/bookstore.html", "Bookstore");
    $this->PrintButton("/QHST/Catalog/catalog.html", "Catalog");
    $this->PrintButton("/QHST/onlinecourses.html", "Courses");
    $this->PrintButton("/QHST/Library/library.html", "Library");
    $this->PrintButton("/more.htm", "The Journal");
    //$this->PrintButton("/areopagus-3.0.7", "Areopagus");
    $this->PrintButton("/QHST/contact.html", "Contact Us");
  }

  function Copyright()
  {
    print ('      <p>Copyright &copy; Quartz Hill School of Theology. '."\n");
  }
} // End of class
?>
