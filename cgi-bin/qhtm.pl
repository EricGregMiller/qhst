#!/usr/bin/perl -w

# Add QHST code to html files.

if (m"</head"i)
{
  # Insert new lines in head.
  print '  <link rel="shortcut icon" href="/Master/qhst.ico" />'."\n";
  print '  <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n";
  print '  <script src="/Master/NavigateButtonSupport.js"></script>'."\n";
}
if (m"\<body"i)
{
  # Replace beginning of body with a blank body tag to keep default format.
  $_ = "<body>\n";
}
if (m"\</body"i)
{
  # Add QHST end of body.
  print '  <script src="/Master/QHSTPageEnd.js"></script>'."\n";
}
if (m/bgcolor="\#\w*"/i)
{
  # Comment out any background color.
  # Print commented string.
  $line = $_;
  chomp $line;
  print "<!--$line-->\n";
  # Remove bgcolor attribute from tag.
  s/bgcolor="\#\w*"//gi;
}
{
  # Default: print current line.
  print;
}
if (m"\<body"i)
{
  # Add QHST begining of body.
  print '  <script src="/Master/QHSTPageBegin.js"></script>'."\n";
}
