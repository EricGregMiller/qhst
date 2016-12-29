#!/usr/bin/perl 

$| = 1;                         # force flushes after every write to output.
require "cgi-lib.pl";           # from: http://www.bio.cam.ac.uk/cgi-lib/
use CGI;                        # from CPAN mirrors everywhere
use File::Basename;             # For getting the file name from a fully qualified path

use Cwd;
use File::Basename;

$currWorkDir = &Cwd::cwd();
$currWorkDir .= "/";

#use vars qw($VERSION);

#use Apache::Constants qw(:common);

# what is this script? Very site-specific.
$thisscript = basename ($0);

sub handler 
{
  my $r = shift;
  print "<p>filename = $r->filename</p>\n";
  return OK;
}
# print the header.

my $cgi = new CGI;
print ($cgi->header(-type=>'text/html'));
#print "<html>\n<head><title>Tree Walker</title></head>\n";
#print "<body>\n";
#print "<p>Hello World More</p>\n";
# get the base path of the document directory in.
$webRoot = $ENV{'DOCUMENT_ROOT'};
$webRoot .= "/";
#print "<p>webRoot = $webRoot</p>\n";
#print "<hr>\n";
# get the document.
$document = $ENV{'PATH_TRANSLATED'};
#print "<p>document = $document</p>\n";
# get the request uri.
$requestUri = $ENV{'REQUEST_URI'};
#print "<p>requestUri = $requestUri</p>\n";
# get the request uri.
$requestFilename = $ENV{'REQUEST_FILENAME'};
#print "<p>requestFilename = $requestFilename</p>\n";
#print "<hr>\n";
my $file = $requestUri;
    $fqfFile = $file;
    if ($fqfFile =~ m?^/?)
    {
      $fqfFile =~ s?^/?$webRoot?;
    }
    else
    {
      $fqfFile = $currWorkDir . $fqfFile;
    }
    #$exist = -e $fqfFile ? "Exist" : "**NOT";
  #print "<p>File $file</p>\n";
  #print "<p>fqfFile $fqfFile</p>\n";
  my($filename, $directories, $suffix) = fileparse($file);
  #print "Dir $directories\n";
if (-e $fqfFile)
{
  #print "<p>EXIST</p>\n<hr>";
  # Open input html file
  open (FIN,$fqfFile) || die "Could not open input $fqfFile";

  # Loop through lines in file.
  while ($line = <FIN>)
  {
    print $line;
  }
}


print "</body>\n";
print "</html>\n";
