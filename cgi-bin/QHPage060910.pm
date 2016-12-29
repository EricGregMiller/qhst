package QHPage;

use Class::Struct;

struct(requestUri => '$', 
       webRoot => '$', 
       pageType => '$');

$| = 1;                         # force flushes after every write to output.
#require "cgi-lib.pl";           # from: http://www.bio.cam.ac.uk/cgi-lib/
use CGI;                        # from CPAN mirrors everywhere
use File::Basename;             # For getting the file name from a fully qualified path

use Cwd;

sub HeadEnd
{
  my $r = shift;

  if ($r->pageType =~ m/qhst/i)
  {
    print (' <link rel="shortcut icon" href="/Master/qhst.ico" />'."\n");
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n");
  }
  elsif ($r->pageType =~ m/qhcc/i)
  {
    print (' <link rel="shortcut icon" href="/Master/qhcc.ico" />'."\n");
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n");
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHCC.css" />'."\n");
  }
  elsif ($r->pageType =~ m/qhph/i)
  {
    print (' <link rel="shortcut icon" href="/Master/qhph.ico" />'."\n");
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n");
  }
  elsif ($r->pageType =~ m/avcwg/i)
  {
    print (' <link rel="shortcut icon" href="/Master/avcwg.ico" />'."\n");
    print (' <link rel="stylesheet" type="text/css" href="/Master/QHST.css" />'."\n");
  }

  print (' <script src="/Master/NavigateButtonSupport.js"></script>'."\n");

}

sub PrintButton
{
  my $r = shift;
  my $href = shift;
  my $buttonImage = shift;
  my $buttonNum = shift;
  print("        <a href=\"$href\" onMouseOver=\"ChangeButtonImage(this,$buttonNum,'on')\" ");
  print("onMouseOut=\"ChangeButtonImage(this,$buttonNum)\">\n");
  print("          <img src=/Master/button/$buttonImage.jpg width=\"151\" height=\"33\" border=\"0\"></A><br>\n");
}

sub PageBegin
{
  my $r = shift;

  my $homeAdd = "/";
  my $topImg = "top1";
  my $leftTopImg = "lefttop";
  if ($r->pageType =~ m/qhst/i)
  {
    $homeAdd = "/";
    $topImg = "top1";
    $leftTopImg = "lefttop";
  }
  elsif ($r->pageType =~ m/qhcc/i)
  {
    $homeAdd = "/QHCC/church.htm";
    $topImg = "QHCCTop";
    $leftTopImg = "QHCCLeftTop";
  }
  elsif ($r->pageType =~ m/qhph/i)
  {
    $homeAdd = "/";
    $topImg = "top1";
    $leftTopImg = "lefttop";
  }
  elsif ($r->pageType =~ m/avcwg/i)
  {
    $homeAdd = "/writers/";
    $topImg = "AVCWGTop";
    $leftTopImg = "AVCWGLeftTop";
  }

  print('<table width="100%" border="0" cellspacing="0" cellpadding="0">'."\n");
  print('  <tr> '."\n");
  print("    <td colspan=\"2\" background=\"/Master/topbg.jpg\">\n");
  print("      <a href=\"$homeAdd\"><img src=\"/Master/$topImg.jpg\" width=\"383\" height=\"92\" border= \"0\"></td>\n");
  print('  </tr>'."\n");
  print('  <tr> '."\n");
  print('    <td width="11%" background="/Master/left.jpg" valign="top"> '."\n");
  print("      <p><a href=\"/\"><img src=\"/Master/$leftTopImg.jpg\" width=\"151\" height=\"134\" border=\"0\"></a><br>\n");


  if ($r->pageType =~ m/qhst/i)
  {
    $r->PrintButton("/welcome-.htm", "about", 1);
    $r->PrintButton("/becomeachristian.html", "christian", 2);
    $r->PrintButton("/bookstor.htm", "bookstore", 3);
    $r->PrintButton("/catalog.htm", "catalog", 4);
    $r->PrintButton("/schedule.html", "classroom", 5);
    $r->PrintButton("/onlinecourses.html", "courses", 6);
    $r->PrintButton("/doctrinalstatement.html", "doctrinestatement", 7);
    $r->PrintButton("/guestbook.html", "guestbook", 8);
    $r->PrintButton("/library.htm", "library", 9);
    $r->PrintButton("/more.htm", "journal", 10);
    $r->PrintButton("/search.html", "search", 11);
    $r->PrintButton("/QHCC/church.htm", "church", 12);
  }
  elsif ($r->pageType =~ m/qhcc/i)
  {
    $r->PrintButton("/welcome-.htm", "about", 1);
    $r->PrintButton("/becomeachristian.html", "christian", 2);
    $r->PrintButton("/bookstor.htm", "bookstore", 3);
    $r->PrintButton("/catalog.htm", "catalog", 4);
    $r->PrintButton("/schedule.html", "classroom", 5);
    $r->PrintButton("/onlinecourses.html", "courses", 6);
    $r->PrintButton("/doctrinalstatement.html", "doctrinestatement", 7);
    $r->PrintButton("/guestbook.html", "guestbook", 8);
    $r->PrintButton("/library.htm", "library", 9);
    $r->PrintButton("/more.htm", "journal", 10);
    $r->PrintButton("/search.html", "search", 11);
    $r->PrintButton("/index.html", "theology", 15);
  }
  elsif ($r->pageType =~ m/qhph/i)
  {
    $r->PrintButton("/welcome-.htm", "about", 1);
    $r->PrintButton("/becomeachristian.html", "christian", 2);
    $r->PrintButton("/bookstor.htm", "bookstore", 3);
    $r->PrintButton("/catalog.htm", "catalog", 4);
    $r->PrintButton("/schedule.html", "classroom", 5);
    $r->PrintButton("/onlinecourses.html", "courses", 6);
    $r->PrintButton("/doctrinalstatement.html", "doctrinestatement", 7);
    $r->PrintButton("/guestbook.html", "guestbook", 8);
    $r->PrintButton("/library.htm", "library", 9);
    $r->PrintButton("/more.htm", "journal", 10);
    $r->PrintButton("/search.html", "search", 11);
    $r->PrintButton("/QHCC/church.htm", "church", 12);
  }
  elsif ($r->pageType =~ m/avcwg/i)
  {
    $r->PrintButton("/writers/conference.html ", "conference", 13);
    $r->PrintButton("/becomeachristian.html", "christian", 2);
    $r->PrintButton("/publishing.html", "publishing", 14);
    $r->PrintButton("/more.htm", "journal", 10);
    $r->PrintButton("/index.html", "theology", 15);
    $r->PrintButton("/QHCC/church.htm", "church", 12);
  }

  print('        <img src="/Master/bot.jpg" width="151" height="60"><br>'."\n");
  print('      </p>'."\n");
  print('      <p>&nbsp;</p>'."\n");
  print('      <p>&nbsp;</p>'."\n");
  print('      <p>&nbsp;</p>'."\n");
  print('      <p>&nbsp;</p>'."\n");
  print('      <p>&nbsp; </p>'."\n");
  print('    </td>'."\n");
  print('    <td width="95%" valign="top"> '."\n");

}

sub PageEnd
{
  my $r = shift;

  # Google ad code
  print ('    <script type="text/javascript"><!--'."\n"); 
  print ('      google_ad_client = "pub-1971528834274288"'."\n");
  print ('      google_ad_width = 728'."\n");
  print ('      google_ad_height = 90'."\n");
  print ('      google_ad_format = "728x90_as"'."\n");
  print ('      google_ad_type = "text_image"'."\n");
  print ('      google_ad_channel =""'."\n");
  print ('      google_color_border = "C3D9FF"'."\n");
  print ('      google_color_bg = "6F7A9E"'."\n");
  print ('      google_color_link = "C3D9FF"'."\n");
  print ('      google_color_text = "C3D9FF"'."\n");
  print ('      google_color_url = "C3D9FF"'."\n");
  print ('    //--></script>'."\n"); 
  print ('    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"> </script>'."\n"); 

  # End of QH page.
  print ('      <hr>'."\n");

  if ($r->pageType =~ m/qhst/i)
  {
    #print ('    <a href="/"><img alt="Return to QHST Homepage" border=0 src="/graphix/return.gif"></a>'."\n");
    print ('      <P><FONT SIZE="-1">Copyright &copy; Quartz Hill School of Theology. <BR>'."\n");
  }
  elsif ($r->pageType =~ m/qhcc/i)
  {
    print ('      <P><FONT SIZE="-1">Copyright &copy; Quartz Hill Community Church. <BR>'."\n");
  }
  elsif ($r->pageType =~ m/qhph/i)
  {
    print ('      <P><FONT SIZE="-1">Copyright &copy; Quartz Hill Publishing House. <BR>'."\n");
  }
  elsif ($r->pageType =~ m/avcwg/i)
  {
    print ('      <P><FONT SIZE="-1">Copyright &copy; Antelope Valley Christian Writers Guild. <BR>'."\n");
  }

  print ('      All Rights Reserved. <BR>'."\n");
  print ('      Graphics by <A href="http://www.webpagedesign.com.au">Art for the web</A></FONT></center></P>'."\n");
  print ('      </td>'."\n");
  print ('  </tr>'."\n");
  print ('</table>'."\n");

}

sub handler 
{
  my $r = shift;
  my $fn = $r->requestUri;
  #print "<p>filename = $fn</p>\n";

  $currWorkDir = &Cwd::cwd();
  $currWorkDir .= "/";

  my $cgi = new CGI;
  print ($cgi->header(-type=>'text/html'));

  # get the base path of the document directory in.
  my $webRoot = $r->webRoot;
  $webRoot .= "/";
  #print "<p>webRoot = $webRoot</p>\n";
  my $fqfFile = $r->requestUri;
  
  # Change web address to complete file path.
  #print "<p>fqfFile = $fqfFile</p>\n";
  if ($fqfFile =~ m?^/?)
  {
    $fqfFile =~ s?^/?$webRoot?;
  }
  else
  {
    $fqfFile = $currWorkDir . $fqfFile;
  }

  # Add index.htm(l) to file name if needed.
  #print "<p>fqfFile = $fqfFile</p>\n";
  if ($fqfFile =~ m?/$?)
  {
    if (-e $fqfFile . "index.html")
    {
      $fqfFile .= "index.html";
    }
    elsif (-e $fqfFile . "index.htm")
    {
      $fqfFile .= "index.htm";
    }
  }
  #print "<p>fqfFile = $fqfFile</p>\n";

  #my($filename, $directories, $suffix) = fileparse($file);
  #print "Dir $directories\n";
  if (-e $fqfFile)
  {
    #print "<p>EXIST</p>\n<hr>";
    # Open input html file
    open (FIN,$fqfFile) || die "Could not open input $fqfFile";
  
    # Loop through lines in file.
    while ($line = <FIN>)
    {
      $printLine = 1;
      $printLine = 0 if ($line =~ m/link.*rel.*"shortcut icon".*href.*=.*Master.*\.ico/i);
      $printLine = 0 if ($line =~ m'link.*rel.*"stylesheet".*href.*=.*/Master/(QHST|QHCC)\.css'i);
      $printLine = 0 if ($line =~ m'"/Master/NavigateButtonSupport\.js"'i);
      $printLine = 0 if ($line =~ m'"/Master/(QHST|QHCC|AVCWG)PageBegin\.js"'i);
      $printLine = 0 if ($line =~ m'"/Master/(QHST|QHCC|AVCWG)PageEnd\.js"'i);
      $r->HeadEnd if ($line =~ m"</head"i);
      $r->PageEnd if ($line =~ m"\</body"i);
      print $line if $printLine;
      $r->PageBegin if ($line =~ m"\<body"i);
    }
  }
}

"true";
