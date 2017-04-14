<?php
require 'QHPage.php';

class RemataPage extends QHPage
{
  function ShortcutIcon()
  {
    print (' <link rel="shortcut icon" href="/Master/remata.ico" />'."\n");
  }

  function StyleSheet()
  {
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n");
    print (' <link rel="stylesheet" type="text/css" href="/Master/Remata.css" />'."\n");
  }

  function SetTopImages()
  {
    $this->homeAdd = "/Remata";
    $this->topImg = "RemataLogo50.png";
    $this->topAlt = "Remata";
    $this->tabSet = "Remata";
  }

  function SetButtons()
  {
    $this->PrintButton("/Remata", "Home");
    $this->PrintButton("/Remata/Spreadsheet", "Spreadsheet");
    $this->PrintButton("/Remata/Web", "Web");
    $this->PrintButton("/Remata/Android", "Android");
  }

   function PrintAdSenseSearchClient()
  {
    print ('        <input type="hidden" name="client" value="pub-6271644264619174"/>'."\n");
  }

  function PrintAdSenseClient()
  {
    //print ('  google_ad_client = "pub-6271644264619174";'."\n");
    print ('  google_ad_client = "pub-1971528834274288";'."\n");
  }

 function Copyright()
  {
    print ('      <p>Copyright &copy; Eric Miller. '."\n");
  }
} // End of class
?>
