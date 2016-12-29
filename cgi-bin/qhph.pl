#!/usr/bin/perl 

use QHPage;

# get the base path of the document directory in.
$webRoot = $ENV{'DOCUMENT_ROOT'};
#print "<p>webRoot = $webRoot</p>\n";

# get the request uri.
$requestUri = $ENV{'REQUEST_URI'};
#print "<p>requestUri = $requestUri</p>\n";

my $r = new QHPage;
$r->requestUri($requestUri);
$r->webRoot($webRoot);
$r->pageType("qhph");
$r->handler;


# get the request uri.
#$requestFilename = $ENV{'REQUEST_FILENAME'};
#print "<p>requestFilename = $requestFilename</p>\n";
#print "<hr>\n";
