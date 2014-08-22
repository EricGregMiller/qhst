<?php
  require 'AVCWGPage.php';

  $r = new AVCWGPage;
  $r->requestUri = $_SERVER['REQUEST_URI'];
  $r->webRoot = $_SERVER['DOCUMENT_ROOT'];
  $r->handler();
?> 
