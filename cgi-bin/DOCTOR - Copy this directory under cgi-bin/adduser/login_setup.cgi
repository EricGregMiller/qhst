#!/usr/bin/perl


#Path to Users Database
$users = "/home/sites/siteXX/web/cgi-bin/doctor/users.dat";


##############################################################
#  Parse from the web form
##############################################################
read (STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@cgiPairs = split(/&/,$buffer);
foreach $cgiPair (@cgiPairs)
{
  ($name,$value) = split(/=/,$cgiPair);
  $value =~ s/\+/ /g;
  $value =~ s/%(..)/pack("c",hex($1))/ge;
  $form{$name} .= "\0" if (defined($form{$name}));
  $form{$name} .= "$value";
}


$username = $form{'new_user'};
 $password = $form{'new_pass'};
$username =~ tr/A-Z/a-z/;
$password = crypt($password, "MM");

open (PEOPLE, ">>$users");
print PEOPLE "$username $password \n";
close (PEOPLE);
print "Content-type: text/html\n\n";
print "<html>\n<head><title>Database Manager</title></head>\n";
print "<BODY TEXT=\"008080\" BGCOLOR=\"FFFFFF\" LINK=\"800000\" VLINK=\"666666\" ALINK=\"FF0000\">\n";
print "<h1>Database Director</h1>\n";
print "</body></html>\n";


