#!/usr/bin/perl 

use QHPage;

# get the request uri.
#$requestUri = $ENV{'REQUEST_URI'};
$requestUri = "/cgi-bin/test.htm";
print "<p>requestUri = $requestUri</p>\n";

my $r = new QHPage;
$r->filename($requestUri);
$r->handler;


# get the request uri.
#$requestFilename = $ENV{'REQUEST_FILENAME'};
#print "<p>requestFilename = $requestFilename</p>\n";
#print "<hr>\n";
