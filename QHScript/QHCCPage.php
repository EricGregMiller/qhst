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
    $this->homeAdd = "/QHCC";
    $this->topImg = "QHCCLogo50.png";
    $this->topAlt = "Quartz Hill Community Church";
    $this->tabSet = "QHCC";
  }

  function SetButtons()
  {
    $this->PrintButton("/QHCC", "Home");
    $this->PrintButton("/QHCC/services.html", "Services");
    $this->PrintButton("/QHCC/about.html", "About Us");
    $this->PrintButton("/QHCC/PeopleVideo.html", "Videos");
    $this->PrintButton("/QHCC/deacons.html", "Servants");
    $this->PrintButton("/QHCC/announcements.html", "Announcements");
    $this->PrintButton("/QHCC/messages.html", "Messages");
    $this->PrintButton("/QHCC/Finance", "Financial");
    $this->PrintButton("/QHCC/contact.html", "Contact Us");
  }

  function Copyright()
  {
    print ('      <p>Copyright &copy; Quartz Hill Community Church. '."\n");
  }
} // End of class
?>
