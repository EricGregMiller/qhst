#! /usr/bin/perl

# Time-stamp: <2000-07-21 16:19:04 ccurley>

# graphics.pl: A program to do two things. First, show any .gifs, .pngs or
# .jpegs in the given directory. Second, to show links to lower
# directories, so the user can explore them.

# The intent is to have a live file system and build a catalog in real
# time. This will eliminate the need to manually edit catalog web pages
# for graphics collections.

# In order to print a directory, we have to handle greater thans, less
# thans and certain other characters correctly.

# call it from a web page like this: <a
# href="/cgi-bin/graphics.pl?">graphics tree program</a> to start at the
# virtual root.

# some debug statements are included, but commented out. You may find them
# useful when you install this script.

# version 0.2 Added a regex to filter for user directories. Very site
# specific, of course. 31 December 1997

# 1998 11 15 C^2: added a detector for links, which will follow links to
# directories.

#
# 2000/06/27 DTG (David T-G, http://www.bigfoot.com/~davidtg/): made some changes
#   started conversion to CGI.pm
#   case-ignored the hex unpack
#   case-ignored the jpeg-jpg-gif match
#   converted script /path/name to variable
#   enabled handling of embedded-spaces filenames (should use opendir, tho)
#

# 2000 07 03 C^2: added support for .pngs.

#       Cleaned up (?) the space handling for embedded spaces in file
#       names works. Directories with embedded spaces don't work. Yet.

#	Converted to use openfile, et al.

#	We now print all the directories first, then do the graphics. It's
#	easier to navigate a tree that way.

#	Changed some of the HTML to be a bit more standard and easier on the eye.

# 2000 07 20 C^2: added a filter to be sure a file actually is a graphics
# file before displaying it. N.B: This is probably somewhat system
# dependent, as it uses Unix/Linux' "file" program, and greps on the
# output. The grep option --silent is a gnu style, so gnu grep is assumed.

# Also, got directories and file names with spaces working correctly.

# Added a count of the graphics displayed so I could check it against the
# number of graphics in the directory, to be sure I got them all. You may
# find it useful also.




# To do: 1) convert completely to CGI module so we only need one
# library.


$| = 1;				# force flushes after every write to output.
require "cgi-lib.pl";		# from: http://www.bio.cam.ac.uk/cgi-lib/
use CGI;			# from CPAN mirrors everywhere
use File::Basename;		# For getting the file name from a fully qualified path

# what is this script? Very site-specific.
#$thisscript = "graphics.pl";
$thisscript = basename ($0);

# print the header.

my $cgi = new CGI; print ($cgi->header(-type=>'text/html'));
print "<html>\n<head><title>Graphics Tree Walker</title></head>
<body bgcolor=\"#ffffff\" text=\"#000000\" link=\"#0000ff\" vlink=\"#ff0000\"
alink=\"#00ff00\">\n";

# Now tell the user what we have here.

print"<center><h1>Graphics Tree Walker</h1></center>\n";

print"This is a script to display all graphics in a directory.<p>\n";

print"Use it to walk the directory structure of this web page, and view
every graphic (.jpeg, .png, or .gif) in each directory. Use the
\"Back\" button on your bowser to return, and click on directories as you
wish to descend into the tree.<p>";

print"Files are sorted alphabetically in ASCII sort order.<p>\n";

# start printing debug data
#  print"<pre>\n";

# get the argument, the string that comes after the file name in the
# url. This will be a path offset from the virtual root.

$query = $ENV{'QUERY_STRING'};

print "Length of \$query is " . length($query) . "\n";
print "Raw query is $query<p>\n";

# now strip out the hex values (%2f, etc.) and replace them with the ASCII
# characters they indicate.

$query =~ s//pack ("C", hex($1))/ieg;

# we need this variable so we can handle directories with spaces in the
# names. Dang Windows idiots.

$spacecleanquery = $query;
$spacecleanquery =~ s/ /\%20/g;

print "filtered query is $query\n";

# use some of cgi-lib.pl's routines to debug.

# $result = &ReadParse;
print("Result of ReadParse is $result\n");

print "Environment: " . &PrintEnv;

# print "Variables: " . &PrintVariables;

# get the base path of the document directory in.
$path = $ENV{'DOCUMENT_ROOT'};

# now get the command line into the path, so we know where we are.
$path .= $query . "/";

print("The real path before filtering is: $path\n");


# filter out user directories and provide the correct path. This is *very*
# site specific! This should take a path like
# \home\httpd\html\~username\foo.bar and produce
# \home\username\public_html\foo.bar

$path =~ s/httpd\/html\/\~(\w*)\/(.*)/\1\/public_html\/\2/g;

print("The real path after filtering is: $path\n");

#  print("The virtual path is: $query/\n");

# stop printing debug data.
#  print "</pre>\n\n";

opendir (DIRHANDLE, $path) or &CgiDie ("Couldn't open $path<p>\n");

while ( defined ($fname = readdir (DIRHANDLE))) {
    @fnames = (@fnames, $fname);
}

@sorted = sort (@fnames);


# now process directories.

$directories_seen = 0;

foreach $fname (@sorted) {

#      print ("Inside $path is $fname.<p>");

    $fqfname = $path . $fname;
#      print ("$fqfname<br>");

    # Now check for directories
    if(-d $fqfname && $fname ne "." && $fname ne ".." ){

	# If we got here, we have at least one directory. Print out our
	# header, then disable the message.

	if (!$directories_seen) {
	    print ("See the graphics in these Directories: <ul>\n");
	    $directories_seen = 1;
	}

	# figure out the fully qualified path name

#  	print ("Showing $fname now:<br>");
	$url = $fname;
	$url =~ s/([\W_])/sprintf("%%%x", ord($1))/eg;

#      print (" URL is $url.<br>");

	print "<li> <a href=\"$thisscript?$ENV{'QUERY_STRING'}%2f$url\">$fname</a>\n";
    }
}


if ($directories_seen) {
    print ("</ul><p>");
}

# Now images

$ImagesDisplayed = 0;

foreach $fname (@sorted) {

#      print ("Inside $path is $fname.<p>");

    $fqfname = $path . $fname;
#    print ("$fqfname<br>");

    # check for gifs, pngs or jpegs, and show them to the user as we find them.
    if($fname =~/.jpeg$|.jpg$|.gif$|.png$/i &&
       -f $fqfname &&

       # Warning: quite likely system specific! "which file" and "which
       # grep" are your friends.

       !(system ("/usr/bin/file \"$fqfname\" \| /bin/grep --silent \"image data\""))
       ) {

	# figure out the fully qualified path name
	$url = $fname;
	$url =~ s/([\W_])/sprintf("%%%x", ord($1))/eg;

#      print (" URL is $url.<br>");

	print "<img border=1 src=\"$spacecleanquery/$url\" alt=\"$query/$fname\"><br>\n";
	print "The file name for this graphic is: $query/$fname<p><p>";

	$ImagesDisplayed++;
    }
}

if ($ImagesDisplayed) {
    if ($ImagesDisplayed == 1) {
	print ("One graphic is displayed.<p>\n");
    } else {
	print ("$ImagesDisplayed graphics are displayed.<p>\n");
    }
}

print"\nThis is the end of the script.";
print"</body></html>\n";
  
