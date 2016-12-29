#!/usr/bin/perl 

use QHPage1;

# get the base path of the document directory in.
$webRoot = $ENV{'DOCUMENT_ROOT'};
#$webRoot = "/home/sites/site40/web";
#$webRoot .= "/";
#print "<p>webRoot = $webRoot</p>\n";

# get the request uri.
$requestUri = $ENV{'REQUEST_URI'};
#$requestUri = "/cgi-bin/test.htm";
#print "<p>requestUri = $requestUri</p>\n";

my $r = new QHPage1;
$r->requestUri($requestUri);
$r->webRoot($webRoot);
$r->pageType("qhst");
$r->handler;


# get the request uri.
#$requestFilename = $ENV{'REQUEST_FILENAME'};
#print "<p>requestFilename = $requestFilename</p>\n";
#print "<hr>\n";
