<HTML>
<head>
<TITLE>Php Info</TITLE>
  <link rel="shortcut icon" href="/Master/qhst.ico" />
  <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />
</head>
<body>
  <h1>Php Info</h1>
  <a href="/cgi-bin/qh1.pl?/index.html">QHST</a><br>
  <a href="/cgi-bin/qh1.pl?/QHCC/church.htm">QHCC</a><br>
  <br>
  <hr>
  <?php
  
    print "Test line<br>\n";
    $argArray = $_SERVER["argv"];
    $args = array();
    if (sizeof($argArray) >= 1)
    {
      $args = explode('?', $argArray[0]);
    }

    foreach ($args as $arg)    
    {
      print $arg . "<br>\n";
    }
    
    print "<br>\n";
    print "<hr>\n";

    // Show all information, defaults to INFO_ALL
    phpinfo();

    // Show just the module information.
    // phpinfo(8) yields identical results.
    //phpinfo(INFO_MODULES);

  ?> 
  <hr>
</body>
</HTML>
  