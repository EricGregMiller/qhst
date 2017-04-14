<?php
  require 'QHPHPage.php';

  $r = new QHPHPage;
  $r->requestUri = $_SERVER['REQUEST_URI'];
  $r->webRoot = $_SERVER['DOCUMENT_ROOT'];
  $r->handler();
?> 
