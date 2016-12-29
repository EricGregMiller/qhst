#!/usr/bin/perl -w

# Add QHST code to html files.

foreach $file (@ARGV)
{
  print "File $file\n";
  # Open input html file
  open (FIN,$file) || die "Could not open input $file";
  # Open temporary output file
  $tempFileName = "$file.$$.temp";
  open (FOUT,">$tempFileName") || die "Could not open output $tempFileName";

  # Initialize file OK flag.
  $fileOk = 0;

  # Read and pass on lines before end of head.
  #
  $line = <FIN>;
  $lineNum = 1;
  while ($line !~ m"</head"i)
  {
    print FOUT $line;
    $line = <FIN>;
    $lineNum++;
  }

  print "  $lineNum: $line";
  if ($line =~ m"</head"i)
  {
    # Insert new lines in head.
    print FOUT '  <link rel="shortcut icon" href="/Master/qhst.ico" />'."\n";
    print FOUT '  <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n";
    print FOUT '  <script src="/Master/NavigateButtonSupport.js"></script>'."\n";

    # End head.
    print FOUT $line;

    # Read and pass on lines before body.
    $line = <FIN>;
    $lineNum++;
    while ($line !~ m"\<body"i)
    {
      print FOUT $line;
      $line = <FIN>;
      $lineNum++;
    }

    print "  $lineNum: $line";
    if ($line =~ m"\<body"i)
    {
      # Replace beginning of body with QHST begining of body.
      print FOUT '<body>'."\n";
      print FOUT '  <script src="/Master/QHSTPageBegin.js"></script>'."\n";

      # Read and pass on lines in body.
      $line = <FIN>;
      $lineNum++;
      while ($line !~ m"\</body"i)
      {
        print FOUT $line;
        $line = <FIN>;
        $lineNum++;
      }

      print "  $lineNum: $line";
      if ($line =~ m"\</body"i)
      {
        # Add QHST end of body.
        print FOUT '  <script src="/Master/QHSTPageEnd.js"></script>'."\n";
  
        # End body.
        print FOUT $line;

        # Read and pass on rest of file.
        while ($line = <FIN>)
        {
          $lineNum++;
          print FOUT $line;
        }

        # Mark that file is OK.
        $fileOk = 1;
      }
      else
      {
        warn "********** $file body does not end. **********\n";
      }
    }
    else
    {
      warn "********** $file has no body. **********\n";
    }
  }
  else
  {
    warn "********** $file has no head or head never ends. **********\n";
  }
  print "  $lineNum lines processed for $file\n";

  # Close files
  close (FIN);
  close (FOUT);

  $fileOk = 0;
  if ($fileOk)
  {
    # Rename temp file to input file.
    rename ($tempFileName, $file) || die "Could not rename $tempFileName to $file.";
  }
  else
  {
    # Remove temp file.
    unlink ($tempFileName) || die "Could not delete $tempFileName.";
  }
}
