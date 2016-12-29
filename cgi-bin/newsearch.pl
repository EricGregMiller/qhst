#!/usr/bin/perl

############################################
##                                        ##
##               WebSearch                ##
##           by Darryl Burgdorf           ##
##       (e-mail burgdorf@awsd.com)       ##
##                                        ##
##         last modified:  8/6/97         ##
##           copyright (c) 1997           ##
##                                        ##
##    latest version is available from    ##
##        http://awsd.com/scripts/        ##
##                                        ##
############################################

# COPYRIGHT NOTICE:
#
# Copyright 1997 Darryl C. Burgdorf.  All Rights Reserved.
#
# This program may be used and modified free of charge by anyone, so
# long as this copyright notice and the header above remain intact.  By
# using this program you agree to indemnify Darryl C. Burgdorf from any
# liability.
#
# Selling the code for this program without prior written consent is
# expressly forbidden.  Obtain permission before redistributing this
# program over the Internet or in any other medium.  In all cases
# copyright and header must remain intact.

# VERSION HISTORY:
#
# 1.07  08/06/97  Squashed "display by date" bug
#                 Fixed "Next X" if last set less than X
# 1.06  08/02/97  Added use of META description tags in search output
#                 Replaced UNIX-specific "ls" with calls to "find.pl"
#                 Allowed distinction of "only HTML" and "all text" dirs
#                 Allowed full recursion in directory searches
#                 Added ability to simply list files in search
#                 Added optional display by date rather than relevance
#                 Corrected $avoid format to allow regexs
# 1.05  05/25/97  Fixed bug in "Next/Previous Set" forms
# 1.04  05/21/97  Added META tags to searched material
#                 Revised search directory definition methodology
#                 Added ability to search within multiple URLs
#                 Set script to display only X matches per page
#                 Added "as a phrase" option to boolean choices
#                 Changed "value" count to "relevance" computation
#                 Eliminated incomplete "choose directory" option
# 1.03  04/03/97  Added ALT text to searched material
#                 Added display of total number of files searched
#                 Added $avoid to designate files not to be searched
#                 Fixed bug in the way titles are obtained
#                 Fixed bug introduced by "minor code shuffling"
# 1.02  02/17/97  Fixed bug in Get_Date subroutine
# 1.01  02/07/97  Minor code shuffling
# 1.00  02/03/97  Initial "public" release

####################
# GENERAL COMMENTS #
####################

# WebSearch allows users to search for key words in documents located
# on your Web site.  It searches the actual documents, rather than a
# master index file.  On the "up" side, that means the results it
# returns are always up-to-the minute.  On the "down" side, of course,
# it means that it takes a bit longer than some other scripts to return
# those results.  It's a tradeoff, but if you're working with relatively
# small file sets, the difference probably won't be too pronounced.
#
# The script scores the match URLs based upon the frequency with which
# the requested key terms appear in the documents, and also lists the
# date on which each file was last modified.  It searches the basic text
# of the documents, as well as ALT text and any information contained in
# META "keywords" and "description" tags.  It does *not* search HTML
# tags or comments, so, for example, a search for "HTML" won't key on
# every "A HREF" tag.

#########
# SETUP #
#########

# The script, of course, must be called from a search form on a Web
# page.  The form should look something like the form below.  The exact
# structure of the form is not too important, of course, so long as the
# correct fields and options exist.  If you leave out the "boolean" and
# "case" fields, the script will default to a case-insensitive boolean
# "OR" ("any terms") search.

# <FORM METHOD=POST ACTION="http://www.foo.com/cgi-bin/websearch.pl">
#
# <P><CENTER>Terms for which to search (separated by spaces):
# <BR><INPUT TYPE=TEXT NAME="terms" SIZE=60>
#
# <P>Find: <SELECT NAME="boolean">
# <OPTION>any terms<OPTION>all terms<OPTION>as a phrase</SELECT> 
# Case: <SELECT NAME="case">
# <OPTION>insensitive<OPTION>sensitive</SELECT>
#
# <P><INPUT TYPE=SUBMIT VALUE="Search">
#
# </CENTER></FORM></P>

# If you run the script with *none* of the expected form input values
# (in other words, if you run it from the command line or by calling
# it directly through your browser), it will simply return to you a list
# of the URLs of all the files it's currently set to search.  This can
# be handy to make sure (a) that you're searching all the files that you
# intend to and (b) that you're *not* searching any files that you
# *don't* intend to.

# A variety of variables need to be defined.  First, you should
# define @dirs as shown below with a list of the full (absolute) paths
# to the directories you wish the script to search.  (The absolute path
# of any directory can be found by issuing the UNIX "pwd" command while
# "sitting" in that directory.)

# By default, only HTML files in the specific directories you specify
# will be searched.  If you wish to search *all* text files in a given
# directory, instead of just HTML files, append a "/+" to the directory
# name.  If you want to search files in the listed directory *and* in
# all of its subdirectories, append a "/*" to the directory name.  If
# you want to search *all* text files in the directory *and* in all of
# its subdirectories, append a "/*+" to the directory name.

@dirs = ('/home/sites/www.theology.edu/web/*');

# If there are particular files you *don't* want included in the
# search, define them in the $avoid variable below.  You need only
# include enough of the file names to distinguish them from other files.
# For example, if you want to exclude all ".txt" files from the search,
# you can simply include "\.txt" as part of $avoid.

$avoid = '(\.backup|\.cgi|\.pl|\.txt)';

# Define the variable $cgiurl as the URL of the WebSearch script itself.

$cgiurl = 'http://209.221.219.105/cgi-bin/newsearch.pl';

# Define the variables $basepath and $baseurl with the absolute path
# and corresponding URL for a "base" directory under which the various
# directories to be searched all lie.  These variables are used to
# convert the UNIX paths to URLs for the results page.

$basepath = '/home/sites/www.theology.edu/web/';
$baseurl = 'http://209.221.219.105/';

# If you wish to be able to specify several other possible URLs -- if,
# for example, some of the files you wish to search fall under a
# different virtual domain or have to be referenced "through" a shopping
# cart or other CGI program -- uncomment the lines below and define
# %otherurls with the desired path/URL pairs.  Note that the script will
# check this variable for matches to convert paths to URLs *before* it
# checks the $basepath and $baseurl variables.

# %otherurls = (
#   '/usr/www/foo/scripts/dir2/sub1/',
#   'http://www.foo.com/cgi-bin/some.cgi?access=',
#   '/usr/www/foo/scripts/dir2/sub2/',
#   'http://www.foo.com/scripts/dir2/sub2/another.cgi?read='
#   );

# Define the variable $HitsPerPage with the number of matches you want
# to appear on each results page.

$HitsPerPage = 25;

# WebSearch will, by default, display search results in order by their
# "relevance" rating, with the most relevant pages first.  If, instead,
# you'd like the results displayed in order by date, with the most
# recently-modified files listed first, then set the $DisplayByDate
# variable to any value greater than 0!

$DisplayByDate = 0;

#####################
# THE ACTUAL SCRIPT #
#####################

# You shouldn't have to change anything in this section!

$version = "1.07";

require "find.pl";

@day = (Sun,Mon,Tue,Wed,Thu,Fri,Sat);
@month = (Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec);

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs){
	($name, $value) = split(/=/, $pair);
	$name =~ tr/+/ /;
	$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$value =~ tr/+/ /;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	if ($FORM{$name}) {
		$FORM{$name} = "$FORM{$name}, $value";
	}
	else {
		$FORM{$name} = $value;
	}
}

if (!$FORM{'boolean'} && !$FORM{'case'} && !$FORM{'terms'}) {
	$ListOnly = 1;
}

unless ($FORM{'boolean'}) { $FORM{'boolean'} = "any terms"; }
unless ($FORM{'case'}) { $FORM{'case'} = "insensitive"; }

$FORM{'terms'} =~ s/^\s*//;
$FORM{'terms'} =~ s/\s*$//;
if ($FORM{'boolean'} eq "as a phrase") {
	push (@terms,$FORM{'terms'});
}
else {
	@terms = split(/\s+/,$FORM{'terms'});
}

$terms = @terms;
$termscount = $terms;
$bestmatch = 5*$terms;

$matchcount=0;
$filecount=0;

foreach $file (@dirs) {
	undef (@AllFiles,$AllText);
	if ($file =~ s/\+$//) {
		$AllText = 1;
	}
	if ($file =~ s/\*$//) {
		&find ($file);
	}
	else {
		opendir(DIR,$file);
		@AllFiles = readdir(DIR);
		closedir(DIR);
	}
	$file =~ s/\/$//;
	foreach $subfile (@AllFiles) {
		unless ($subfile =~ /^$file/) {
			$subfile = $file."/".$subfile;
		}
		if ((-T "$subfile")
		  && ($AllText || ($subfile =~ /\.(s|p)*htm(l)*$/))
		  && (!$avoid || ($subfile !~ /$avoid/))) {
			push (@files,"$subfile");
		}
	}
}

if ($ListOnly) {
	@FILES = sort (@files);
	print "Content-type: text/html\n\n";
	print "<HTML><HEAD><TITLE>File List</TITLE></HEAD>\n";
	print "<BODY><PRE>\n\n";
	print "The following files are included in the search:\n\n";
	foreach $FILE (@FILES) {
		if (%otherurls) {
			foreach $path (keys %otherurls) {
				$FILE =~ s/$path/$otherurls{$path}/i;
			}
		}
		$FILE =~ s/$basepath/$baseurl/i;
		print "$FILE\n";
		$filecount ++;
		next;
	}
	print "\nTotal:  $filecount files.\n\n";
	print "</PRE></BODY></HTML>\n";
	exit;
}

foreach $FILE (@files) {
	open (FILE,"$FILE");
	@LINES = <FILE>;
	close (FILE);
	$filecount ++;
	$mtime = (stat($FILE))[9];
	$mtime{$FILE} = $mtime;
	$kbytesize = int((((stat($FILE))[7])/1024)+.5);
	$update{$FILE} = &Get_Date;
	$string = join(' ',@LINES);
	$string =~ s/\n/ /g;
	$val{$FILE} = 0;
	if ($string =~ /<TITLE>([^>]+)<\/TITLE>/i) {
		$title{$FILE} = "$1";
		$titlestring = "$title{$FILE}"x$kbytesize;
	}
	elsif ($string =~ /SUBJECT>(.+)POSTER>/i) {
		$title{$FILE} = "$1";
		$titlestring = "$title{$FILE}"x$kbytesize;
	}
	else {
		$title{$FILE} = "$FILE";
		$titlestring = "";
	}
	if ($string =~ /<[^>]*META[^>]+NAME\s*=[ "]*description[ "]+CONTENT\s*=\s*"(([^>"])*)"[^>]*>/i) {
		$description{$FILE} = "$1";
	}
	$title{$FILE} =~ s/^\s*//;
	$title{$FILE} =~ s/\s*$//;
	$string =~ s/<[^>]*\s+ALT\s*=\s*"(([^>"])*)"[^>]*>/$1/ig;
	$string =~ s/<[^>]*META[^>]+NAME\s*=[ "]*(description|keywords)[ "]+CONTENT\s*=\s*"(([^>"])*)"[^>]*>/$2/ig;
	$string =~ s/<([^>])*>//g;
	$string = $titlestring." ".$string;
	if ($FORM{'boolean'} eq 'all terms') {
		foreach $term (@terms) {
			unless (length($term) < 3) {
				if ($FORM{'case'} eq 'insensitive') {
					$test = ($string =~ s/$term//ig);
					if ($test < 1) {
						$val{$FILE} = 0;
						last;
					}
					else {
						$val{$FILE} = $val{$FILE}+$test;
					}
				}
				elsif ($FORM{'case'} eq 'sensitive') {
					$test = ($string =~ s/$term//g);
					if ($test < 1) {
						$val{$FILE} = 0;
						last;
					}
					else {
						$val{$FILE} = $val{$FILE}+$test;
					}
				}
			}
		}
	}
	else {
		$termscount = 0;
		foreach $term (@terms) {
			unless (length($term) < 3) {
				if ($FORM{'case'} eq 'insensitive') {
					$test = ($string =~ s/$term//ig);
				}
				elsif ($FORM{'case'} eq 'sensitive') {
					$test = ($string =~ s/$term//g);
				}
				$val{$FILE} = $val{$FILE}+$test;
				if ($test > 0) { $termscount++; }
			}
		}
	}
	if ($val{$FILE} > 0) {
		$truval{$FILE} = ($val{$FILE}*($termscount/$terms));
		if ($truval{$FILE} > $bestmatch) {
			$bestmatch = $truval{$FILE};
		}
		$matchcount++;
	}
}

##########
# OUTPUT #
##########

# The script's output can, of course, be modified to suit the specific
# "look" of the site being searched.  Don't try to make major changes,
# though, unless you're reasonably sure that you know what you're doing,
# as there are a *lot* of conditionals and variables in the output.

print "Content-type: text/html\n\n";
print "<HTML><HEAD><TITLE>Search Results</TITLE></HEAD>\n";
print "<BODY Background=\"water2.gif\" TEXT=\"#000000\">";
print "<B><font face=arial,helvetica,swiss size=+2 color=#008080>Search Results</font>\n";
print "<br><font face=arial,helvetica,swiss color=#000080>Keywords ($FORM{'boolean'}, ";
print "case $FORM{'case'}): <b>";
foreach $term (@terms) {
	unless (length($term) < 3) { print "$term "; }
}
print "</b>\n";
print "<br><font size=-1>";
print "(<b>$filecount</b> files searched; ";
print "<b>$matchcount</b> match";
if ($matchcount == 1) {
	print " found)";
}
else {
	print "es found)";
}
print "</font>\n";

unless ($FORM{'first'}) { $FORM{'first'} = 1; }
unless ($FORM{'last'}) { $FORM{'last'} = $HitsPerPage; }

if ($matchcount == 0) {
	print "<br>No documents match your search criteria!";
	print "<BR>You might want to revise them and try again.\n";
}
else {
	print "<br><b>Matches $FORM{'first'} ";
	if ($matchcount < $FORM{'last'}) {
		print "- $matchcount</b>\n";
	}
	else {
		print "- $FORM{'last'}</b>\n";
	}
	print "<HR size=2 noshade>\n";
	$Count = 0;
	print "</font><font face=arial,helvetica,swiss><br><oL>\n";
	if ($DisplayByDate > 0) {
		foreach $key (sort ByDate keys %truval) {
			&PrintEntry;
		}
	}
	else {
		foreach $key (sort ByValue keys %truval) {
			&PrintEntry;
		}
	}
	print "</oL>\n";
	print "<br><CENTER><TABLE><TR>\n";
	if ($FORM{'first'} > 1) {
		print "<TD><FORM METHOD=POST ACTION=\"$cgiurl\">\n";
		print "<INPUT TYPE=HIDDEN NAME=\"terms\" VALUE=\"";
		foreach $term (@terms) {
			unless (length($term) < 3) { print "$term "; }
		}
		print "\">\n";
		print "<INPUT TYPE=HIDDEN NAME=\"boolean\" ";
		print "VALUE=\"$FORM{'boolean'}\">\n";
		print "<INPUT TYPE=HIDDEN NAME=\"case\" ";
		print "VALUE=\"$FORM{'case'}\">\n";
		print "<INPUT TYPE=HIDDEN NAME=\"first\" ";
		print "VALUE=\"",($FORM{'first'}-$HitsPerPage),"\">\n";
		print "<INPUT TYPE=HIDDEN NAME=\"last\" ";
		print "VALUE=\"",($FORM{'last'}-$HitsPerPage),"\">\n";
		print "<INPUT TYPE=SUBMIT ";
		print "VALUE=\"Last $HitsPerPage Matches\">\n";
		print "</FORM></TD>\n";
	}
	if ($FORM{'last'} < $matchcount) {
		print "<TD><FORM METHOD=POST ACTION=\"$cgiurl\">\n";
		print "<INPUT TYPE=HIDDEN NAME=\"terms\" VALUE=\"";
		foreach $term (@terms) {
			unless (length($term) < 3) { print "$term "; }
		}
		print "\">\n";
		print "<INPUT TYPE=HIDDEN NAME=\"boolean\" ";
		print "VALUE=\"$FORM{'boolean'}\">\n";
		print "<INPUT TYPE=HIDDEN NAME=\"case\" ";
		print "VALUE=\"$FORM{'case'}\">\n";
		print "<INPUT TYPE=HIDDEN NAME=\"first\" ";
		print "VALUE=\"",($FORM{'first'}+$HitsPerPage),"\">\n";
		print "<INPUT TYPE=HIDDEN NAME=\"last\" ";
		print "VALUE=\"",($FORM{'last'}+$HitsPerPage),"\">\n";
		print "<INPUT TYPE=SUBMIT VALUE=\"";
		$nextset = $matchcount-$FORM{'last'};
		if ($nextset == 1) {
			print "Next Match";
		}
		elsif ($nextset < $HitsPerPage) {
			print "Next $nextset Matches";
		}
		else {
			print "Next $HitsPerPage Matches";
		}
		print "\">\n</FORM></TD>\n";
	}
	print "</TR></TABLE></CENTER>\n";
}

print "<FORM METHOD=POST ACTION=\"$cgiurl\">\n";
print "<hr size=2 noshade><B><font face=arial,helvetica,swiss size=+2 color=#008080>New Search</font></b>\n";
print "<br>Terms for which to search (separated by spaces):\n";
print "<BR><INPUT TYPE=TEXT NAME=\"terms\" SIZE=60 VALUE=\"";
foreach $term (@terms) {
	unless (length($term) < 3) { print "$term "; }
}
print "\">\n<br>Find: <SELECT NAME=\"boolean\"> ";
if ($FORM{'boolean'} eq 'any terms') {
	print "<OPTION SELECTED>any terms<OPTION>all terms";
	print "<OPTION>as a phrase</SELECT> ";
}
elsif ($FORM{'boolean'} eq 'all terms') {
	print "<OPTION>any terms<OPTION SELECTED>all terms";
	print "<OPTION>as a phrase</SELECT> ";
}
else {
	print "<OPTION>any terms<OPTION>all terms";
	print "<OPTION SELECTED>as a phrase</SELECT> ";
}
print "Case: <SELECT NAME=\"case\"> ";
if ($FORM{'case'} eq 'insensitive') {
	print "<OPTION SELECTED>insensitive<OPTION>sensitive</SELECT>\n";
}
else {
	print "<OPTION>insensitive<OPTION SELECTED>sensitive</SELECT>\n";
}
print "<br><INPUT TYPE=SUBMIT VALUE=\"Search\">";
print "</FORM><hr size=2 noshade>\n";

print "</SMALL></BODY></HTML>\n";

exit;

###############
# SUBROUTINES #
###############

# You shouldn't need to change these, either!

sub Get_Date {
	$mtime = time unless ($mtime);
	($mday,$mon,$yr) = (localtime($mtime))[3,4,5];
	$date = "$mday $month[$mon] 19$yr";
	return $date;
}

sub PrintEntry {
	$Count++;
	next if ($Count < $FORM{'first'});
	last if ($Count > $FORM{'last'});
	$fileurl = $key;
	if (%otherurls) {
		foreach $path (keys %otherurls) {
			$fileurl =~ s/$path/$otherurls{$path}/i;
		}
	}
	$fileurl =~ s/$basepath/$baseurl/i;
	print "<LI><b><A HREF=\"$fileurl\">";
	print "$title{$key}</A></b> ";
	$relevance = int(((100/$bestmatch)*$truval{$key})+.5);
	print "<font color=#1e90ff size=-2><i>(Relevance: $relevance%)\n</i></font>";
	if ($description{$key}) {
		print "<BR><EM>$description{$key}</EM>\n";
	}
	print "<BR><SMALL>Last updated: $update{$key}</SMALL><P>\n";
}

sub ByDate {
	$aval = $mtime{$a};
	$bval = $mtime{$b};
	$bval <=> $aval;
}

sub ByValue {
	$aval = $truval{$a};
	$bval = $truval{$b};
	$bval <=> $aval;
}

sub wanted {
	(push (@AllFiles, $name)) && -f $_;
}

