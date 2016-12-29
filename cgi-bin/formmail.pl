#!/usr/bin/perl

# Define Variables
$mailprog = '/usr/sbin/sendmail';

require "ctime.pl";
require "cgi-lib.pl";

$MAILTO="rick\@curtis.net";
$SUBJECT="Diploma Form";

# Get the input
read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
 
# Split the name-value pairs
@pairs = split(/&/, $buffer);

foreach $pair (@pairs){
   ($name, $value) = split(/=/, $pair);

   $value =~ tr/+/ /;
   $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
   $name =~ tr/+/ /;
   $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;          
   $FORM{$name} = $value;
}

if ($FORM{'redirect'}) {
   print "Location: $FORM{'redirect'}\n\n";
}
else {
   # Print Return HTML
   print "Content-type: text/html\n\n";
   print "<html><head><title>Thank You</title></head>\n";
   print "<body><h1>Thank You For Your Inquiry!</h1>\n";
   print "Thank you for your inquiry! ";
   print "Below is what you submitted. <BR><BR>\n";
   print "";
   print "";


}

# Open The Mail

open(MAIL, "|$mailprog -s \"$SUBJECT\" $MAILTO") || die "Can't open $mailprog!\n";


foreach $pair (@pairs) {
   ($name, $value) = split(/=/, $pair);
 
   $value =~ tr/+/ /;
   $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
   $name =~ tr/+/ /;
   $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

   $FORM{$name} = $value;
   unless ($name eq 'recipient' || $name eq 'subject' || $name eq 'email' || $name eq 'redirect') {
      # Print the MAIL for each name value pair
      if ($value ne "") {        
         print MAIL "____________________________________________\n\n";
 				print MAIL "$name:  $value\n";
      }

      unless ($FORM{'redirect'}) {
         if ($value ne "") {
            print "$name = $value<hr>\n";
         }
      }
   }
}
close (MAIL);

unless ($FORM{'redirect'}) {   
		print "</body></html>";
}
