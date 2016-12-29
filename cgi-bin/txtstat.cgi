#!/usr/bin/perl

# *by Ranson Johnson - Email scripts@rlaj.com
# *Last Modified: 03/31/97
# *Statistics Program, for use with Server Side Includes Counter

############################################################################
#Feel free to copy, change, reference, sample, or borrow, the contents.    #  
#The script is provided as is, there is no warranty expressed or implied.  #
#If you would, email me and let me know you are using the script, so I can #
#show you on my list of links.                                             #
#If you would like to support public domain freeware, contributions are    #
#accepted.							           #
#Last but certainly not least, if you find a better way of doing something,#
#I would really like to know. Thanks and have fun.                         #
############################################################################


   #################### DEFINE VARIABLES FOR STATPAGE ####################							    

#$basedir = './';

# Enter the Real Web address for your Site
$baseurl = 'http://ro.com/~kryan/';

# Enter the Server URL
$server = 'http://ro.com';

# Enter the location for your log Files ( the default location is as below )
@files = ('counterLogs/*.log');

# Enter the Title for this page
$TITLE_OF_PAGE = 'Statistics for Text Counter';

# Enter a Page Header
$PAGE_HEADER = 'Statistics for Text Counter';

# Enter a BACKGROUND COLOR for the page ( default is white - FFFFFF )
$BGCOLOR = 'BGCOLOR="FFFFFF"';

# Enter the TEXT COLOR for the page
$TEXT = 'TEXT="000000"';

# If you want a background image, enter below
$BACKGROUND = '';

# Enter a copyrite - or any information for the bottom of the page
$COPY_RITE = '<P><HR><CENTER>Copyrite 1997 by<a href="http://www.rlaj.com/scripts"> Ranson\'s Scripts</a> all rights reserved.</CENTER>';

# Done									    #
#############################################################################


# Get all Log Files for this Site
&get_files;

# Go through all the logs and collect the stats
&CalculateStats;



# This section goes and finds all the log files and puts them into an array
# so we can use them in the next section.

sub get_files { 


   #chdir($basedir);
   foreach $file (@files) {
      $ls = `ls $file`;
      @ls = split(/\s+/,$ls);
      foreach $temp_file (@ls) {
         if (-d $file) {
            $filename = "$file$temp_file";
            if (-T $filename) {
               push(@FILES,$filename);
            }
         }
         elsif (-T $temp_file) {
            push(@FILES,$temp_file);
         }
      }
   }
}

# This section opens each log file and processes the information for each
# page. Then prints the information to the browser.

sub CalculateStats {

   print "Content-type: text/html\n\n";

   print "<html>\n <head>\n <title>$TITLE_OF_PAGE</title>\n </head>\n";
   print "<body $BGCOLOR $TEXT >\n";
   print "<CENTER>\n<H2>$PAGE_HEADER</H2>\n</CENTER>\n<P>\n";

   print "<TABLE CELLSPACING=5 CELLPADDING=5>\n";
   print "<TR><TD><B>Page Address</TD><TD><B>Totals</TD></TR>\n";


      $total = 0;
   foreach $FILE (@FILES) {

      open(FILE,"$FILE");
      @LINES = <FILE>;
      close(FILE);

      $string = join(' ',@LINES);
      #$string =~ s/\n//g;

      $total += $string;


        	
$Page = "$FILE";
$Page =~ s/counterLogs//g;
$Page =~ s/\.log//g;
$Page =~ s/\_/\//g;
$Page =~ s/\/\/\~//g;
$Page = substr($Page,1,100);


   print "<TR><TD>$Page</A></TD><TD ALIGN=right><B>$string</TD></TR>\n"; 
   

 } # End of foreach

   print "<TR><TH COLSPAN=2><HR></TH></TR>\n";

   print "<TR><TD><B>Total for all files</TD><TD ALIGN=right><B>$total</TD></TR>\n"; 

   print "</TABLE><P>\n"; 
 
   print "$COPY_RITE\n";
  
   print "</body>\n</html>\n";
      


}
  
exit;
 



   



   

   
