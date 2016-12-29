#!/usr/bin/perl

# Counter CGI for Server Side Includes
# *Version 2.0
# *Ranson Johnson 
# *Last Modified: 03/29/97

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

# This program should be easy to set up on your server, just follow these
# step-by-step instructions

# 1. Create a cgi-bin, if you don't already have one, copy the counter.cgi
# to that directory. 
# EXAMPLE - /~your_main_directory/cgi-bin
# chmod the counter.cgi to 755
# If you don't know how to chmod a file, Ask your system administrator.
# Or see the chmod FAQ at - http://www.rlaj.com/scripts

# 2. Create a directory under the cgi-bin called - counterLogs -
# You may have to chmod this directory to 777 on some systems in order to
# automatically generate the log files. Ask your system administrator.

# 3. Put the code below in your HTML pages that you want to count
# <!--exec cgi="cgi-bin/counter.cgi"--> 
# Be sure to get the path correct to the cgi-bin for your system.

# 4. You may have to change the name of your HTML page to - your_page.shtml
# for it to work on your server. OR on some servers you can keep the page
# page.html and give the page 755 permission. ( chmod 755 page.html )
# Ask your system administrator.

# 5. Set up the configuration section below.
  
# NOTE :  The counter logs need to have 666 permisions on some systems.
# Ask your system administrator.

        ############## CONFIGURATION SECTION #############


# Enter the name of the logs directory
$log_dir = "/home/sites/site1/web/cgi-bin/counterLogs";


# Do you want the count to appear in a table? 1=yes 0=no
$table = '0';

# If you want the count in a table, enter the BORDER WIDTH
$BORDER = '5';

# Text that appears before the count number
$before = "You are visitor number";

# Text that appears after the count number
$after = "";

# You can change the font color for the counter 000000 = Black
$font_color = "<FONT COLOR=\"000080\">";

# You can chang the font size of the counter text
$font_size = "<FONT SIZE=\"2\">";

# Do you want the counter text centered? 1=yes 0=no
$center = '0';

# Text that appears at the bottom of the page, copyright etc.
$bottom_of_page = "";

      ################ END OF CONFIGURATION ###################

# Get the page location from the DOCUMENT_URI environment variable.
$count_page = "$ENV{'DOCUMENT_URI'}";

# Chop off any trailing / 's
if ($count_page =~ /\/$/) {
   chop($count_page);
}

$count_page =~ s/\//_/g;
$count_page = substr($count_page,1,100);



################## This section is the page counter ####################
&GetFileLock;
         
# Open log and get count
               
	open LOG,"$log_dir/$count_page.log";  
	@log_lines = <LOG>;
	close LOG;

	foreach $line (@log_lines){

# Add 1 to the log number for current hit
        	
        $next_number = $line +1; 
      }
     
# If this is the 1st hit then write the number 1 to the log.

	if ($next_number < 1){   
	$next_number = 1;        
	}

# Open log and print new count

	open LOG,">$log_dir/$count_page.log";  
        print LOG "$next_number";
	close LOG;

&ReleaseFileLock;
################################################################

   print "Content-Type: text/html\n\n";

     if ($center eq '1'){
	print "<CENTER>";
	}
	else{
	print "</CENTER>";
	}
        print "<BR><NOBR>$font_color\n";
        print "<B>$font_size $before</FONT>\n";
     if ($table eq '1'){
	print "<TABLE BORDER=$BORDER CELLPADDING=0 CELLSPACING=0><TR><TD>\n";
	}

     print "<B>$next_number</B>";
    

     if ($table eq '1'){
	print "</TD></TR></TABLE>\n";
	}
        print "$font_size $after</FONT></FONT></B></NOBR>\n";
	

     if ($center eq '1'){
	print "</CENTER>";
	}
	print "$bottom_of_page\n";

#######################################################################
#                            GetFileLock                              #
#######################################################################

sub GetFileLock {  
    local ($lock_file) = @_;

    local ($endtime);  
    $endtime = 10;
    $endtime = time + $endtime;
#   We set endtime to wait 10 seconds

    while (-e $lock_file && time < $endtime) {
        # Do Nothing
    }
#    open(LOCK_FILE, ">$lock_file");    
    flock(LOCK_FILE, 2); # 2 exclusively locks the file
} # end of get_file_lock

#######################################################################
#                            ReleaseFileLock                          #
#######################################################################

sub ReleaseFileLock {
    local ($lock_file) = @_;
       
# 8 unlocks the file
    flock(LOCK_FILE, 8);
#    close(LOCK_FILE);
#    unlink($lock_file);

} # end of ReleaseFileLock   



exit;  


