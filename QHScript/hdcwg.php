<?php
  require 'HDCWGPage.php';

  $r = new HDCWGPage;
  $r->requestUri = $_SERVER['REQUEST_URI'];
  $r->webRoot = $_SERVER['DOCUMENT_ROOT'];
  $r->handler();
?> 
