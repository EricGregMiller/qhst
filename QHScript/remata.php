<?php
  require 'RemataPage.php';

  $r = new RemataPage;
  $r->requestUri = $_SERVER['REQUEST_URI'];
  $r->webRoot = $_SERVER['DOCUMENT_ROOT'];
  $r->handler();
?> 
