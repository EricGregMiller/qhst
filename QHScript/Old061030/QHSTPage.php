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
    $this->topImg = "top1";
    $this->leftTopImg = "lefttop";
  }

  function SetButtons()
  {
    $this->PrintButton("/welcome-.htm", "about", 1);
    $this->PrintButton("/becomeachristian.html", "christian", 2);
    $this->PrintButton("/bookstor.htm", "bookstore", 3);
    $this->PrintButton("/catalog.htm", "catalog", 4);
    $this->PrintButton("/schedule.html", "classroom", 5);
    $this->PrintButton("/onlinecourses.html", "courses", 6);
    $this->PrintButton("/doctrinalstatement.html", "doctrinestatement", 7);
    $this->PrintButton("/guestbook.html", "guestbook", 8);
    $this->PrintButton("/library.htm", "library", 9);
    $this->PrintButton("/more.htm", "journal", 10);
    $this->PrintButton("/search.html", "search", 11);
    $this->PrintButton("/QHCC/church.htm", "church", 12);
  }

  function Copyright()
  {
    //print ('    <a href="/"><img alt="Return to QHST Homepage" border=0 src="/graphix/return.gif"></a>'."\n");
    print ('      <P><FONT SIZE="-1">Copyright &copy; Quartz Hill School of Theology. <BR>'."\n");
  }
} // End of class
?>
