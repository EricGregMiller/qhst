#! /usr/bin/perl


$| = 1;				# force flushes after every write to output.
require "cgi-lib.pl";		# from: http://www.bio.cam.ac.uk/cgi-lib/
use CGI;			# from CPAN mirrors everywhere
use File::Basename;		# For getting the file name from a fully qualified path

# what is this script? Very site-specific.
#$thisscript = "dirs.pl";
$thisscript = basename ($0);

# print the header.

my $cgi = new CGI; 
print ($cgi->header(-type=>'text/html'));
print "<html>\n<head><title>Tree Walker</title></head>
<body bgcolor=\"#ffffff\" text=\"#000000\" link=\"#0000ff\" vlink=\"#ff0000\"
alink=\"#00ff00\">\n";

# Now tell the user what we have here.

print"<center><h1>Tree Walker</h1></center>\n";

#print"This is a script to display all graphics in a directory.<p>\n";

#print"Use it to walk the directory structure of this web page, and view every graphic (.jpeg, .png, or .gif) in each directory. Use the \"Back\" button on your bowser to return, and click on directories as you wish to descend into the tree.<p>";

#print"Files are sorted alphabetically in ASCII sort order.<p>\n";

# start printing debug data
#  print"<pre>\n";

# get the argument, the string that comes after the file name in the
# url. This will be a path offset from the virtual root.

$query = $ENV{'QUERY_STRING'};

#print "Length of \$query is " . length($query) . "\n";
#print "Raw query is $query<p>\n";

# now strip out the hex values (%2f, etc.) and replace them with the ASCII
# characters they indicate.

#$query =~ s//pack ("C", hex($1))/ieg;

# we need this variable so we can handle directories with spaces in the
# names. Dang Windows idiots.

$spacecleanquery = $query;
$spacecleanquery =~ s/ /\%20/g;

#print "filtered query is $query\n";

# use some of cgi-lib.pl's routines to debug.

# $result = &ReadParse;
#print("Result of ReadParse is $result\n");

#print "Environment: " . &PrintEnv;

# print "Variables: " . &PrintVariables;

# get the base path of the document directory in.
$path = $ENV{'DOCUMENT_ROOT'};
$webpath = $ARGV[0];
$webpath .= "/";
$path .= $webpath;


print"\n<hr>This is the end of the script.";
print"</body></html>\n";
  
