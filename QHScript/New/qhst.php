<?php
  require 'QHSTPage.php';

  $r = new QHSTPage;
  $r->requestUri = $_SERVER['REQUEST_URI'];
  $r->webRoot = $_SERVER['DOCUMENT_ROOT'];
  $r->handler();
?> 
