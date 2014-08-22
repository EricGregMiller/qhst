<?php

  $argArray = $_SERVER["argv"];
  $args = array();
  if (sizeof($argArray) >= 1)
  {
    $args = explode('?', $argArray[0]);
  }

  $pageType = "qhst";
  if (sizeof($args) >= 2)
  {
    $pageType = $args[1];
  }
  //print "<p>page type = " . $pageType . "</p>\n";

  //var $r;  
  if (preg_match("/qhst/i", $pageType))
  {
    require 'QHSTPage.php';
    $r = new QHSTPage;
  }
  elseif (preg_match("/qhcc/i", $pageType))
  {
    require 'QHCCPage.php';
    $r = new QHCCPage;
  }
  elseif (preg_match("/qhph/i", $pageType))
  {
    require 'QHPHPage.php';
    $r = new QHPHPage;
  }
  elseif (preg_match("/avcwg/i", $pageType))
  {
    require 'AVCWGPage.php';
    $r = new AVCWGPage;
  }
  
  //$r->requestUri = $_SERVER['REQUEST_URI'];
  $r->requestUri = '/Master/FileNotFound.html';
  if (sizeof($args) >= 1)
  {
    $r->requestUri = $args[0];
  }
  //print "<p>filename = " . $r->requestUri . "</p>\n";

  $r->webRoot = $_SERVER['DOCUMENT_ROOT'];
  $r->handler();
?> 
