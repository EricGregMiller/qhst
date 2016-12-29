#!/usr/bin/perl
#################################
# Chat Script Version 1.0.4
#
# By Command-O Software
# http://www.command-o.com
#
# Copyright 1996
# All Rights Reserved
#
# This script has parts (form parsing) borrowed from and a lot 
# learned from the great scripts at Matt's Script Archive at 
# http://worldwidemart.com/scripts/
#
#If you find this script useful, we would appreciate a 
#donation to keep this service active for the community.
#Command-O Software, P.O. Box 12200, Jackson WY 83002
#################################
#
# Define Variables
#
$file_dir = "/var/home/theology/httpd/chatfiles"; 
# This is the directory path to the chat and visitor files.

$chat_file = "chat";
$visitor_file = "visitors";
$lock_file = "lock";
# If these files do not exist they will be created automatically, but you
# must have the directory set to chmod 777

$script_name = "chat.pl"; 
# This is the script as you have it named. The script must be set to 
# chmod 755

$page_title = "Quartz Hill School of Theology<BR>Virtual Classroom"; 
# This is the title of the chat page

$title_graphic = ""; 
# Leave blank if you don't have a title graphic. If you do, it should be 
# about 270 pixels wide and 30 pixels tall

$bgcolor = "ffffff";
# This is the background color for all the pages this script produces.
# Remember to use hex numbers (ffffff is white). Some browsers will
# accept literal color names such as "red".

$background = "";
# This is the url of a background texture for all the pages this script
# produces. Leave it blank if you don't want a background texture.

$schedule_file = "http://www.theology.edu/schedule.html";
# If you have a file detailing scheduled chats put the url of the schedule 
# file between the quotes. Otherwise leave them empty.

$leave_link = "http://www.theology.edu/";
# This is the url where you want people sent when they leave the chat page. 
# Probably your own main page.

$visitors_time = 900; 
# This is the time in seconds which people will remain in the visitors list
# since their last reload.

$chat_time = 18000;  
# This is the time in seconds which messages will remain in the chat file.

$lock_time = 5; 
# This is the time in seconds that the script will wait if the lock file 
#exists before running the script. If the lock file remains for a few seconds,
# it is probably a bogus file leftover from a previous error.

$timeout = 20; 
# This is the amount of time in seconds the script will wait before 
# automatically quitting, without this, for unknown reasons, it will 
# very rarely keep running without this and eat up server resources 
# without doing anything productive. 20 seconds is fine.

# That's it! You must get express written permission from Command-O 
# Software if you want to make changes on anything below. 
###############################################

$our_link = "http://www.command-o.com/";
$our_image = "http://www.command-o.com/pics/command-o-logo-sm.gif";

&cancel;
##############
# Set up to cancel script if it doesn't quit itself
sub cancel {
   $SIG{'ALRM'} = 'signal_handler';
   # turn on the alarm timer
   alarm($timeout);
   &lock;
}
###############
# Lock File
sub lock {

   $time = time();
   $quit = 0;
   while ($quit != 1) {
      if (-e "$file_dir/$lock_file") {
         if ($time + $lock_time < time()) {
            &parse_form;
         }
         else {
           sleep(1);
         }
      }
      else {
         open(LOCK,">$file_dir/$lock_file");
         close LOCK;
         &parse_form;
      }
   }
}

########################
# Parse Form
# This subroutine is taken from Matt Wright's WWWBoard script
# with a few minor modifications.

sub parse_form {

   # Get the input
   read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});

   # Split the name-value pairs
   @pairs = split(/&/, $buffer);

   foreach $pair (@pairs) {
      ($name, $value) = split(/=/, $pair);

      # Un-Webify plus signs and %-encoding
      $value =~ tr/+/ /;
      $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
      $value =~ s/<!--(.|\n)*-->//g;
      $value =~ s/<([^>]|\n)*>//g;

      $FORM{$name} = $value;
   }
   &get_variables;
}

###########
# Get variables from form

sub get_variables {

   if ($FORM{'where'}) {
      $where = "$FORM{'where'}";
   }   
   if ($FORM{'name'}) {
      $name = "$FORM{'name'}";
      $name =~ s/"//g;
      $name =~ s/<//g;
      $name =~ s/>//g;
      $name =~ s/\&//g;
      $name =~ s/\(//g;
      $name =~ s/\)//g;
      $name =~ s/\$/S/g;
   }
   if ($FORM{'mail'} =~ /.*\@.*\..*/) {
      $mail = "$FORM{'mail'}";
   }
   if ($FORM{'nummes'}) {
      $nummes = $FORM{'nummes'};
   }

   if ($FORM{'message'}) {
      $message = $FORM{'message'};
      $message =~ s/\cM//g;
      $message =~ s/\n\n/<p>/g;
      $message =~ s/\n/<br>/g;
      $message =~ s/&lt;/</g;
      $message =~ s/&gt;/>/g;
      $message =~ s/&quot;/"/g;
   }
   ($sec,$min,$hour) = localtime(time);

   if ($sec < 10) {
      $sec = "0$sec";
   }
   if ($min < 10) {
      $min = "0$min";
   }
   if ($hour < 10) {
      $hour = "0$hour";
   }

   $date = "$hour\:$min\:$sec";
   chop($date) if ($date =~ /\n$/);

   $time = time();
   &location;
}
##########
# Where are they coming from?

sub location {

   if ($name eq "mail") {
      &login;    # Print the registration page
      &unlock;   # Unlock the script
   }
   elsif ($where eq "register") {
      &register; # Add their information to the visitors file
      &reload;   # Reload the chat page with the latest information
      &unlock;   # Unlock the script
   }
   elsif ($where eq "  Post  ") {
      &old;      # Delete old entries from files      
      &post;     # Add their message to the chat file
      &update;   # Update the reload time in the visitors file
      &reload;   # Reload the chat page with the latest information
      &unlock;   # Unlock the script
   }
   elsif ($where eq "Reload") {
      &snag;     # Get the information in the message field
      &old;      # Delete old entries from files      
      &update;   # Update the reload time in the visitors file
      &reload;   # Reload the chat page with the latest information
      &unlock;   # Unlock the script
   }
   elsif ($where eq "Leave") {
      &leave;    # Remove person's name from visitors file and send them away
      &unlock;   # Unlock the script
   }
   else {
      &createv;  # Create chat and visitors files if needed
      &old;      # Delete old entries from files
      &login;    # Print the registration page
      &unlock;   # Unlock the script
   }
   exit;
}
########################
# Create files if they don't exist
sub createv {
   if (-e "$file_dir/$visitor_file") {
      &createc;
   }
   else {
      open (VISITORS,">$file_dir/$visitor_file");
      print VISITORS "<!--:$time:--><!--begin-->";
      close (VISITORS);
      &createc;
   }
}

sub createc {
   if (-e "$file_dir/$chat_file") {
   }
   else {
      open (CHAT,">$file_dir/$chat_file");
      print CHAT "<!--:$time:--><!--begin-->";
      close (CHAT);
   }
}


############
# Login

sub login {

   open (VISITORS,"$file_dir/$visitor_file");
   @visitors=<VISITORS>;
   $vnum=@visitors;
   if($vnum) {
      $vnum=$vnum - 1;
   }
   close (VISITORS);

   print "Content-type: text/html\n\n";
   print "<html><head><title>$page_title Login</title></head>\n";
   print "<ul><body bgcolor=$bgcolor background=\"$background\"><center>\n";
   if ($title_graphic eq "") {
      print "<H1>$page_title</h1>\n";
   }
   else {
      print "<h1><img src=\"$title_graphic\" alt=\"$page_title\"></h1>\n";
   }
   print "<h2>Registration Page</h2><p></center>\n";
   print "<b><font size=4 color=ff0000><center>YOU \n";
   print "MUST CLICK THE \"RELOAD\" BUTTON ON<br>THE PAGE TO SEE THE LATEST \n"; 
   print "CONVERSATION.</font></b></center><p>\n";
   print "Type a message and click \"Post\" to send it. Click \"Reload\" or \"Post\" to see the latest conversation.\n";
   print "Click \"Leave\" to leave the chat. The list of names show's you who is there and when they last reloaded.<p>\n";
   if ($vnum==0) {
      print "There are <b>no people</b> on the chat page right now, but don't let that stop you.<p>\n";
   }
   elsif ($vnum==1) {
      print "There is <b>one</b> person on the chat page. One is the loneliest number...<P>\n"; }
   else {
      print "There are <b>$vnum</b> people on the chat page.<P>\n";
   }
   print "You must enter your name below to enter the chat page, e-mail address is optional:<br>\n";
   print "<form method=POST action=\"$script_name\"><input type=hidden name=\"where\" value=\"register\">\n";
   print "<table><tr><td>\n";
   print "Name:</td>\n";
   print "<td><input type=text size=30 name=\"name\"><br></td></tr>\n";
   print "<tr><td>E-mail:</td>\n";
   print "<td><input type=text size=30 name=\"mail\"><br></td></tr></table>\n";
   print "<input type=submit value=\"Enter Chat\"></form>\n";
   if ($schedule_file) {
      print "This chat page has <a href=\"$schedule_file\">scheduled</a> meetings.<p>\n";
   }
   print "<center><a target=\"_top\" href=\"$our_link\"><img ";
   print "border=0 width=91 height=33 src=\"$our_image\">";
   print "</a></center>\n";
   print "</body></html>\n";
}
###########
# Register
sub register {
   $login = "$date";
   
   open (VISITORS,"$file_dir/$visitor_file") || die $!;
   @visitors = <VISITORS>;
   close (VISITORS);

   open(VISITORS,">$file_dir/$visitor_file") || die $!;
   foreach $visitors_line (@visitors) {
      if ($visitors_line =~ /<!--$name-->/) {
         print VISITORS "";
      }
      elsif ($visitors_line =~ /<!--begin-->/) {
         print VISITORS "<!--:$time:--><!--begin-->\n";
         if ($mail eq "") {
            print VISITORS "<!--:$time:--><tr><td><!--$name--><b>$name</b></td> <td> <br></td></tr>\n";
         }
         else {
            print VISITORS "<!--:$time:--><tr><td><!--$name--><a href=\"mailto:$mail\"><b>$name</b></a></td> <td><br> </td></tr>\n";
         }
      }
      else {
         print VISITORS "$visitors_line";
      }
   }
   close(VISITORS);

   open(MAIN,"$file_dir/$chat_file") || die $!;
   @main = <MAIN>;
   close(MAIN);

   open(MAIN,">$file_dir/$chat_file") || die $!;
   foreach $main_line (@main) {
      if ($main_line =~ /<!--begin-->/) {
         print MAIN "<!--:$time:--><!--begin-->\n";
         print MAIN "<!--:$time:--><b>$name</b> has joined the chat at $date<br>$name, you must hit reload on the page to see the latest conversation.<hr>\n";
      }

      else {
        print MAIN "$main_line";
      }
   }
   close(MAIN);

}
##########
# Modify chat page

sub post {
   if ($message eq "") {
   }
   else {

      open(MAIN,"$file_dir/$chat_file") || die $!;
      @main = <MAIN>;
      close(MAIN);

      open(MAIN,">$file_dir/$chat_file") || die $!;
      foreach $main_line (@main) {
         if ($main_line =~ /<!--begin-->/) {
            print MAIN "<!--:$time:--><!--begin-->\n";
            print MAIN "<!--:$time:--><b>$name</b> $date<br>$message<hr>\n";
         }

         else {
            print MAIN "$main_line";
         }
      }
      close(MAIN);
   }
}
#########
# Snag information when person hits reload

sub snag {
   $mess = $message;
}
##########
# Update Visitor's log

sub update {
   open (VISITORS,"$file_dir/$visitor_file") || die $!;
   @visitors = <VISITORS>;
   close (VISITORS);

   open(VISITORS,">$file_dir/$visitor_file") || die $!;
   foreach $visitors_line (@visitors) {
      if ($visitors_line =~ /<!--$name-->/) {
         print VISITORS "";
      }
      elsif ($visitors_line =~ /<!--begin-->/) {
         print VISITORS "<!--:$time:--><!--begin-->\n";
         if ($mail eq "") {
            print VISITORS "<!--:$time:--><tr><td><!--$name--><b>$name</b></td> <td>$date<br></td></tr>\n";
         }
         else {
            print VISITORS "<!--:$time:--><tr><td><!--$name--><a href=\"mailto:$mail\"><b>$name</a></b></td> <td>$date<br></td></tr>\n";
         }
      }
      else {
         print VISITORS "$visitors_line";
      }
   }
   close(VISITORS);
}
##########
# Delete old entries
sub old {

   open (VISITORS,"$file_dir/$visitor_file") || die $!;
   @visitors = <VISITORS>;
   close (VISITORS);

   open(VISITORS,">$file_dir/$visitor_file") || die $!;
   foreach $visitors_line (@visitors) {
      if ($visitors_line =~ /<!--begin-->/) {
         print VISITORS "<!--:$time:--><!--begin-->";
      }

      ($bogus,$load,$bogus2) = split(/:/,$visitors_line);
      if ($time - $load > $visitors_time) {
         print VISITORS "";
      }
      else {
         print VISITORS "$visitors_line";
      }
   }
   close (VISITORS);

   open(MAIN,"$file_dir/$chat_file") || die $!;
   @main = <MAIN>;
   close(MAIN);

   open(MAIN,">$file_dir/$chat_file") || die $!;
   foreach $main_line (@main) {
      if ($main_line =~ /<!--begin-->/) {
         print MAIN "<!--:$time:--><!--begin-->";
      }
      ($bogus,$entry,$bogus2) = split(/:/,$main_line);
      if ($time - $entry > $chat_time) {
         print MAIN "";
      }
      else {
         print MAIN "$main_line";
      }
   }
   close (MAIN);
}

############
# Reload
sub reload {
   open(MAIN,"$file_dir/$chat_file") || die $!;
   @main = <MAIN>;
   close(MAIN);

   open (VISITORS,"$file_dir/$visitor_file") || die $!;
   @visitors = <VISITORS>;
   close (VISITORS);

   print "Content-type: text/html\n\n";
   print "<html><head><title>$page_title</title></head>\n";
   print "<body bgcolor=$bgcolor background=\"$background\"><center>\n";
   print "<form method=POST action=\"$script_name\">\n";
   print "<table cellpadding=0><tr><td>\n";
   print "<table height=172 border=5><tr valign=middle><td><center>\n";
   print "<a href=\"#messages\">\n";
   if ($title_graphic eq "") {
      print "<H3>$page_title</h3></a></center>\n";
   }
   else {
      print "<h3><img src=\"$title_graphic\" border=0 alt=\"$page_title\"></a></h3></center>\n";
   }
   print "<input type=hidden name=\"loadtime\" value=\"$time\">\n";
   print "<input type=hidden name=\"mail\" value=\"$mail\">\n";
   print "<input type=hidden name=\"name\" value=\"$name\">\n";
   print "<b>Message:</b><br><textarea COLS=40 ROWS=4 name=\"message\" wrap>\n";
   print "$mess</textarea><br>\n";
   print "</td></tr><tr><td><table cellpadding=0 border>\n";
   print "<tr align=center><td>Last reload<br><b>$date</b><br></td>\n";
   print "<td><input type=submit name=\"where\" value=\"  Post  \"></td>\n";
   print "<td><input type=submit name=\"where\" value=\"Reload\"></td>\n";
   print "<td><input type=reset value=\" Clear \"></td>\n";
   print "<td><input type=submit name=\"where\" value=\"Leave\"><br></td></tr>\n";
   print "<tr></tr>\n";
   if ($nummes eq "10") {
      print "<tr align=center><td># of mesgs</td>\n";
      print "<td><input type=radio name=\"nummes\" value=\"10\" checked>10</td>\n";
      print "<td><input type=radio name=\"nummes\" value=\"20\">20</td>\n";
      print "<td><input type=radio name=\"nummes\" value=\"30\">30</td>\n";
      print "<td><input type=radio name=\"nummes\" value=\"40\">40<br></td>\n";
   }
   elsif ($nummes eq "20" || $nummes eq "") {
      print "<tr align=center><td># of mesgs</td>\n";
      print "<td><input type=radio name=\"nummes\" value=\"10\">10</td>\n";
      print "<td><input type=radio name=\"nummes\" value=\"20\" checked>20</td> \n";
      print "<td><input type=radio name=\"nummes\" value=\"30\">30</td>\n";
      print "<td><input type=radio name=\"nummes\" value=\"40\">40<br></td>\n";
   }
   elsif ($nummes eq "30") {
      print "<tr align=center><td># of mesgs</td>\n";
      print "<td><input type=radio name=\"nummes\"value=\"10\">10</td>\n";
      print "<td><input type=radio name=\"nummes\" value=\"20\">20</td> \n";
      print "<td><input type=radio name=\"nummes\" value=\"30\" checked>30</td>\n";
      print "<td><input type=radio name=\"nummes\" value=\"40\">40<br></td>\n";
   }
   elsif ($nummes eq "40") {
      print "<tr align=center><td># of mesgs</td>\n";
      print "<td><input type=radio name=\"nummes\"value=\"10\">10</td>\n";
      print "<td><input type=radio name=\"nummes\" value=\"20\">20</td>\n";
      print "<td><input type=radio name=\"nummes\" value=\"30\">30</td>\n";
      print "<td><input type=radio name=\"nummes\"value=\"40\" checked>40<br></td>\n";
   }
   print "</table></td></tr></table>\n";
   print "<td valign=top><table border=5 cellpadding=0><tr><td><b>Name</b>\n";
   print "</td> <td>Reload<br></td></tr><tr></tr>@visitors\n";
   print "</table></td></tr></table>\n";
   print "</center></form><hr> <a name=\"messages\"></a>\n";
   if ($nummes eq "10") {
      print "$main[1] $main[2] $main[3] $main[4] $main[5] \n";
      print "$main[6] $main[7] $main[8] $main[9] $main[10]\n";
   }
   elsif ($nummes eq "20" || $nummes eq "") {
      print "$main[1] $main[2] $main[3] $main[4] $main[5] \n";
      print "$main[6] $main[7] $main[8] $main[9] $main[10]\n";
      print "$main[11] $main[12] $main[13] $main[14] $main[15] \n";
      print "$main[16] $main[17] $main[18] $main[19] $main[20]\n";
   }
   elsif ($nummes eq "30") {
      print "$main[1] $main[2] $main[3] $main[4] $main[5] \n";
      print "$main[6] $main[7] $main[8] $main[9] $main[10]\n";
      print "$main[11] $main[12] $main[13] $main[14] $main[15] \n";
      print "$main[16] $main[17] $main[18] $main[19] $main[20]\n";
      print "$main[21] $main[22] $main[23] $main[24] $main[25] \n";
      print "$main[26] $main[27] $main[28] $main[29] $main[30]\n";
   }
   elsif ($nummes eq "40") {
      print "$main[1] $main[2] $main[3] $main[4] $main[5] \n";
      print "$main[6] $main[7] $main[8] $main[9] $main[10]\n";
      print "$main[11] $main[12] $main[13] $main[14] $main[15] \n";
      print "$main[16] $main[17] $main[18] $main[19] $main[20]\n";
      print "$main[21] $main[22] $main[23] $main[24] $main[25] \n";
      print "$main[26] $main[27] $main[28] $main[29] $main[30]\n";
      print "$main[31] $main[32] $main[33] $main[34] $main[35] \n";
      print "$main[36] $main[37] $main[38] $main[39] $main[40]\n";
   }
   print "<center><a target=\"_top\" href=\"$our_link\"><img ";
   print "border=0 width=91 height=33 src=\"$our_image\">";
   print "</a></center>\n";
   print "</body></html>\n";
}


###############
# Leave
sub leave {
      open(MAIN,"$file_dir/$chat_file") || die $!;
      @main = <MAIN>;
      close(MAIN);

      open(MAIN,">$file_dir/$chat_file") || die $!;
      foreach $main_line (@main) {
         if ($main_line =~ /<!--begin-->/) {
            print MAIN "<!--:$time:--><!--begin-->\n";
            print MAIN "<!--:$time:--><b>$name</b> left the chat at $date<br><hr>\n";
         }

         else {
            print MAIN "$main_line";
         }
      }
      close(MAIN);


   open (VISITORS,"$file_dir/$visitor_file") || die $!;
   @visitors = <VISITORS>;
   close (VISITORS);

   open(VISITORS,">$file_dir/$visitor_file") || die $!;
   foreach $visitors_line (@visitors) {
      if ($visitors_line =~ /<!--$name-->/) {
         print VISITORS "";
      }
      else {
         print VISITORS "$visitors_line";
      }
   }
   close(VISITORS);
   print "Location: $leave_link\n\n";
}

###########
# Unlock
sub unlock {
   unlink("$file_dir/$lock_file");
   $quit = 1;
}

#############
# Kill script if it keeps running
sub signal_handler {
        $SIG{'ALRM'} = 'signal_handler';
        die "exiting on alarm signal.\n";
}
