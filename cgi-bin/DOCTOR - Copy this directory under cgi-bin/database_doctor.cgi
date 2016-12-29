#!/usr/bin/perl
$| = 1;

##############################################################
#
#	Database_Doctor.cgi 1.22
#	Mike Carville
#	www.web-bazaar.com
#	carville@web-bazaar.com
#
#
#	The Database Doctor is a tool designed to help manage
#	Pipe Delimited Databases.(|) The script is designed to
#	add to, edit and delete, sort and prepare printouts of
#	databases. Many scripts, especially web stores utilize
#	these types of data files.
#
#	The script is password protected, and has a user addition
#	form. 
#
#	Earlier versions of this script supported multiple users.
#	Nobody seemed to care, and it messed up a lot of people.
#	Out like the cat. In with the new.
#
#	Even though this was written to manage a webstore database,
#	everybody seemed to want a front end to this. Display.cgi
#	was written to address this. The Database Doctor will still
#	work wonderfully to create and maintain databases for an
#	inventory file. With display.cgi now it becomes flexible
#	and can easily handle address books, directories or whatever
#	you can imagine. And imagination is the key.
#
#
#	A key feature of the script is that it will edit any
#	number of fields in a database. 
#
#	-the database you make will have as many fields 
# 	 as you have headings in fields.dat
#
#	-if you subsequently add a field to the middle you 
# 	 will need to adjust your  database
#
#     -The Titles for the fields need to match the names
#	on the input form, and are contained within fields.dat .
# 
# 	-The input form for new items is an html form module located in html.dat. 
#
#	-The Form can be whatever you like...you can have drop down 
#	 and so forth to speed up entry.
#
#	-The absolute key though is that the name of the fields in the form
#	 must match the headings for the fields in fields.dat . This is how
#	 the script knows where the data is coming in from, and where to put it. 
#	 If you are missing data from an entry form you are having a matching problem
#
#	-Don't add an opening or closing form tag to html.dat...as that is in
#	the script itself.
#
#	FILES
#	-----
#	In the main CGI Directory place database_doctor.cgi(755)
#	Make a subdirectory named data(777)
#
# 	Contents (permissions in ())...	html.dat(666)
#					fields.dat(666)
#					DATABASE (name whatever you like)(666)
#
#	Place login_setup.cgi and users.dat wherever you want.
#	Login Setup will create the encrypted password.
#	There is a path to adjust the users.dat location on
#	the first line of login_setup.cgi
#
#	There are two logon pages included as well. Remember to changes the
#	paths to the scripts, and to leave the form input names alone.
#	One accesses the Database Doctor, the other will add users to users.dat.
#
#	One Other Option...
#	By setting the $check_items variable to Y the script will verify that the
#	first field in the entry you are adding is unique from all the others.
#	Most web store scripts require a unique item id.
#
#	ALWAYS BACK UP YOUR DATA THE FIRST TIME THROUGH!!!!
#
# 	This script is made available free of charge.
# 	Please leave my name in the header section.
# 	You may not sell this script for any reason.
#
# 	We of course are not responsible if this script blows
# 	up your computer. We can, however, sell you a new one.
# 	At the point of this writing my computer has failed to blow up.
#
#
#	And lastly, thanks to Joe DePasquale for the search routine I
#	borrowed from the linkmatic script before modifying. Check
#	out Joes great site at the link through mine...
#	http://www.1-web-bazaar-plaza.com/help/cgi/
#
#
#
#	Improvements in version 1.2
#
#	-fixed a typo in the search routine that caused an internal
#	 server error on some systems. It was bad perl..
#	 I have no idea why it worked at all!
#
#	-reworked the listing of the headers. Previous version would 
# 	 sometimes display out of order.
#
#	Fixed row editing bug in 1.21
#	Fixed printout bug in 1.22
#
#	SET THESE SERVER PATHS...

$database = "rawdata.dat";   #just the name of the file

$data_location = "/home/sites/siteXX/web/cgi-bin/doctor/data";
$users = "/home/home/sites/siteXX/web/cgi-bin/doctor/users.dat";

#change to Y if you would like the first field compared
#to the other first fields in the database during preview
#to insure a unique ID if you need that for a webstore

$check_items = "N";



##################################################################################################
#####Thats that. You change below here and you mess with the guts...feel free but be careful######

print "Content-type: text/html\n\n";
print "<html>\n<head><title>Database Doctor</title></head>\n";
print "<BODY basefont=-1>\n";
print "<font size=+1><font color=\"0000ff\"><b><i>Database Doctor</b></i></font></font>\n";
print "<FORM method=post action=\"database_doctor.cgi\">\n";


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



##############################################################
#  Validate User
##############################################################
	if ($form{'pass'} eq "ok")
	{$passwd="Y";}

	else
	{
	open (PEOPLE, "$users");

		while (<PEOPLE>)
		{
		$row=$_;
		@user = split(/ /,$row);

		if ($form{'user'} eq $user[0])
		{
		$password = crypt($form{'password'}, "MM");

		if ($password eq "$user[1]" )
		{$passwd="Y";}
		}
	}
	close (PEOPLE);

	}
##############################################################
#  Set Hidden Tags for Re-entry
##############################################################
print "<INPUT type=\"hidden\"  name=\"pass\" Value=\"ok\">\n";
print "<INPUT type=\"hidden\"  name=\"user\" Value=\"$form{'user'}\">\n";



##############################################################
#  Display the Addition Form if necessary
##############################################################
if ($form {'startup'})
{&display;}


##############################################################
#  Read the Fields, Set the Variables if User Passes Check
##############################################################
if ($passwd eq "Y")
{


	open (DATABASE, "$data_location/fields.dat");
	while (<DATABASE>)
	{$table_fields = $_;	}
	close (DATABASE);

	@split_table_fields = split (/\,/, $table_fields);

##############################################################
#  Preview the Addition
##############################################################

if ($form {'preview'})
{

	if ($check_items eq "Y")
	{&check_items;}

	print "<center><font size=4><b>Preview</b></font><table border=1 cellspacing =5 width=500>\n";

	foreach $split_table_fields (@split_table_fields)
	{

	if ($form{$split_table_fields} =~ /\n/)
	{
	print "<tr><th width=100>$split_table_fields</td>\n";
	print "<td><font size=-1><TEXTAREA  name=\"$split_table_fields\"  ROWS=8 COLS=60 wrap=physical>$form{$split_table_fields}</TEXTAREA></td></tr>\n";
	}

	else
	{
	print "<tr><th width=100>$split_table_fields</td>\n";
	print "<td width=400><INPUT type=\"text\"  name=\"$split_table_fields\" Value=\"$form{$split_table_fields}\" SIZE = \"40\" MAXSIZE = \"80\"></td></tr>\n";
	}

	}


	print "</tr></table>\n";
	print "<center><INPUT type=\"submit\"  name=\"add\" Value=\"  Add this to the Database  \">\n";

}



##############################################################
#  Make the Addition
##############################################################
if ($form {'add'})
{

	if ($check_items eq "Y")
	{&check_items;}

	$form{'Description'} =~ (s/\r\n/<br>/g);

	foreach $split_table_fields (@split_table_fields)
	{push (@row, "$form{$split_table_fields}");}

	$new_row = join ("\|", @row);


	open (DATABASE, ">>$data_location/$database");
	print DATABASE "$new_row\n";
	close (DATABASE);



print "<center><h2>$form{$split_table_fields[1]} Item added to the Database</h2>";
&display;

}


##############################################################
#  Edit the Auction Database--Select an item
##############################################################

if ($form {'edit'})
{


	print"<table border=1 >\n";
	print"<tr><td><font size=-1><b>Edit</td><td><font size=-1><b>Delete</td>\n";

	foreach $split_table_fields (@split_table_fields)
	{print"<td><font size=-1><b>$split_table_fields</td>\n";}
	print"</tr>\n";

	$count=1;

	open (DATABASE, "$data_location/$database");
	while (<DATABASE>)
	{
	$row = $_;
	chop $row;
	@fields = split (/\|/, $row);

	print "<tr><td align=center><font size=-1><input type=radio name=\"row_to_edit\" value=\"$count\"></td><td align=center><font size=-1><input type=checkbox name=\"delete$count\" value=\"$count\" ></td>\n";

	foreach $fields (@fields)
	{print"<td><font size=-1>$fields &nbsp;</td>\n";}

	print"</tr>\n";

	$count++;
	}
	close (DATABASE);

	$count--;

	print "</table>\n";
	print "<center><p><INPUT type=\"submit\"  name=\"edit_row\" Value=\"  Edit this row  \">\n";
	print "<center><INPUT type=\"submit\"  name=\"delete_row\" Value=\"  Delete this row  \"><P>\n";
      print " <p><b>Your search returned $count entries.</b><p>\n";


}
##############################################################
#  Edit--Print the web Page for changes
##############################################################
if ($form {'edit_row'})
{

	$count=1;

	open (DATABASE, "$data_location/$database");
	while (<DATABASE>)
	{
	$row = $_;
	chop $row;
	@fields = split (/\|/, $row);


	if ($form{'row_to_edit'} eq $count)
	{
	$counter=0;

	foreach $split_table_fields (@split_table_fields)
	{
	$DATA{$split_table_fields} = "$fields[$counter]";
	$counter++;
	}

	print "<center><b>Correct any changes and press \"Change This Row\" to edit</b><p>\n";
	print "<table border=1 cellspacing =5 width=500>\n";

	foreach $split_table_fields (@split_table_fields)
	{

	if ($split_table_fields eq "Description")
	{
	print "<tr><th width=100>$split_table_fields</td>\n";
	print "<td><font size=-1><TEXTAREA  name=\"$split_table_fields\"  ROWS=8 COLS=40 wrap=physical>$DATA{$split_table_fields}</TEXTAREA></td></tr>\n";
	}

	else
	{
	print "<tr><th width=100>$split_table_fields</td>\n";
	print "<td width=400><INPUT type=\"text\"  name=\"$split_table_fields\" Value=\"$DATA{$split_table_fields}\" SIZE = \"40\" MAXSIZE = \"80\"></td></tr>\n";
	}

	}


	}
	$count++;
	}
	close (DATABASE);

	print "</table>\n";
	print "<INPUT type=\"hidden\"  name=\"row\" Value=\"$form{'row_to_edit'}\"><BR>\n";
	print "<center><INPUT type=\"submit\"  name=\"change_row\" Value=\"  Change this row  \"><P>\n";
}

##############################################################
#  Edit--Change Modified Row
##############################################################
if ($form {'change_row'})
{

	$count=1;
	$form{'Description'} =~ (s/\r\n/<br>/g);

	open (DATABASE, "$data_location/$database");

	while (<DATABASE>)
	{
	$row = $_;
	chop $row;
	@fields = split (/\|/, $row);

	if ($form{'row'} ne $count)
	{$new_row .= "$row\n";}

	else
	{

	foreach $split_table_fields (@split_table_fields)
	{push (@row, "$form{$split_table_fields}");}

	$row = join ("\|", @row);
	$new_row .= "$row\n";
	}
	$count++;
	}
	close (DATABASE);


	open (DATABASE, ">$data_location/$database");
	print DATABASE "$new_row";
	close (DATABASE);

	print "<center><h2>$form{$split_table_fields[1]} Item Modified</h2>";

}
##############################################################
#  Edit--Confirm Delete
##############################################################
if ($form {'delete_row'})
{
$count=1;


	print "<center><h1>Confirm Delete...Check box to delete...</h1>\n";
	print "<table border=1>\n";

	open (DATABASE, "$data_location/$database");
	while (<DATABASE>)
	{
	$row = $_;
	chop $row;
	@fields = split (/\|/, $row);

	$selected="delete" . "$count";

	if ($form{$selected} eq $count)
	{print"<tr><td><font size=-1><input type=checkbox name=\"row$count\" value=\"$count\" checked></td><td><font size=-1>$fields[0]</td><td><font size=-1>$fields[1]</td><td><font size=-1>$fields[2]</td><td><font size=-1>$fields[3]</td><td><font size=-1>$fields[4]</td>\n";}

	$count++;
	}
	close (DATABASE);

	print "</table>\n";
	print "<INPUT type=\"hidden\"  name=\"data\" Value=\"$database\"><BR>\n";
	print "<center><INPUT type=\"submit\"  name=\"delete\" Value=\"  Purge!  \"><P>\n";

}

##############################################################
#  Edit--Delete Row
##############################################################
if ($form {'delete'})
{


	$count=1;

	open (DATABASE, "$data_location/$database");
	while (<DATABASE>)
	{
	$row = $_;
	chop $row;
	@fields = split (/\|/, $row);

	$selected="row" . "$count";

	if ($form{$selected} ne $count)
	{$new_row .= "$row\n";}

	$count++;
	}
	close (DATABASE);


	open (DATABASE, ">$data_location/$database");
	print DATABASE "$new_row";
	close (DATABASE);

	print "<center><h2>$form{$split_table_fields[1]} Item(s) Deleted</h2><P>\n";

}
##############################################################
#  Search Form
##############################################################
if ($form {'search'})
{

	print "Choose any combination of Search terms to locate entries to edit.<p>\n";
	print "SEARCH by Keywords:<BR>\n";

	print "<INPUT type=\"text\" name=\"searchtext\" size=60 maxlength=60>\n";
	print "<BR>Search for documents containing <INPUT type=\"radio\" name=\"searchtype\" value=\"any\" checked> ANY or <INPUT type=\"radio\" name=\"searchtype\" value=\"all\"> ALL of these words or phrases.\n";
	print "<br>Search only in this Field\n";
	print "<SELECT NAME = \"field\">\n";
	print "<OPTION value=\"\">\n";

	$count=0;
	foreach $split_table_fields (@split_table_fields)
	{
	print "<OPTION value =\"$count\">$split_table_fields\n";
	$count++;
	}

	print "<\select>\n";
	print "<CENTER><BR><INPUT type=\"submit\" name=\"find\" value=\"START SEARCH\"><p>\n";
}

##############################################################
#  Find Items and Display in Editor
##############################################################
if ($form {'find'})
{
	if ($form{'searchtext'})
	{ 
	@searchText = split(/\x20/,$form{'searchtext'});

	foreach $test (@searchText)
	{
 	if ($test =~ /\S{2,}/)
      {push (@searchKey, $test);}
	}


	if (! @searchKey)
	{print " <b>ERROR: No valid keywords were entered.</b><br>\n";}

	else
	{

	print"<table border=1 aline=center>\n";
	print"<tr><th><font size=\"-1\">Edit</th><th><font size=\"-1\">Delete</th>\n";

	foreach $split_table_fields (@split_table_fields)
	{print"<th><font size=\"-1\">$split_table_fields</th>\n";}

	print"</tr>\n";
	$count=1;

	open (DATABASE, "$data_location/$database");
	while ($inLine = <DATABASE>)
	{
	$line=$inLine;

	if ( $form{'field'} ne "")
	{
	@fields = split (/\|/, $inLine);
	$inLine=$fields[$form{'field'}];
	}

	if ($form{'searchtype'} eq "any")
	{$foundFlag = "N";}
	else
	{$foundFlag = "Y";}

	foreach $test (@searchKey)
	{

	if ($inLine =~ /$test/i)
	{
	
		if ($form{'searchtype'} eq "any")
		{
		$foundFlag = "Y";
		last;
		}
	}
	else
	{

		if ($form{'searchtype'} eq "all")
		{
		$foundFlag = "N";
		last;
		}
	}

# end If InLine

	}
# end ForEach Test

	if ($foundFlag eq "Y")
	{
	@fields = split(/\|/,$line);
	$hitCount++;
	print "<tr><td><input type=radio name=\"row_to_edit\" value=\"$count\"></td><td><input type=checkbox name=\"delete$count\" value=\"$count\"></td>\n";

	foreach $fields (@fields)
	{print"<td><font size=\"-1\">$fields</td>\n";}
	print"</tr>\n";

	}

	$count++;
	
      } # end While InLine
      close(LINK);

	print "</table>\n";


	print "<center><INPUT type=\"submit\"  name=\"edit_row\" Value=\"  Edit this row  \">\n";
	print "<center><INPUT type=\"submit\"  name=\"delete_row\" Value=\"  Delete this row  \"><P>\n";
      print " <p><b>Your search returned $hitCount entries.</b><p>\n";

	}
	}
	 else # end Else StartSearch
	{print " ERROR: No keywords were entered.<p>\n";}

}

##############################################################
# Display the Sort Form
##############################################################
if ($form {'sort'})
{

	print "<BR>Field to sort by:\n";
	print "<SELECT NAME = \"sortby\">\n";

	$count=0;
	foreach $split_table_fields (@split_table_fields)
	{
	print "<OPTION value =\"$count\">$split_table_fields\n";
	$count++;
	}

	print "<\select><br>\n";

	print "Alphabetical <INPUT type=\"checkbox\" name=\"order\" value=\"alpha\" checked><BR>
	(Unchecking this box will result in reverse sort ...Z  to
	A or high to low in regards to prices.)<BR>\n";

	print "<center><INPUT type=\"Submit\"  name=\"sort_items\" Value=\"   Sort the Database \"><P>\n";

}
##############################################################
# Sort The Fields
##############################################################
if ($form {'sort_items'})
{


$index_of_field_to_be_sorted_by = $form{'sortby'};
$start_display = $form{'startdisplay'};
$display_end = $form{'displayend'};




#  First pick out the field, and move it to the beginning of the line

open(FILE, "$data_location/$database");
flock(FILE, $LOCK_EX);
$count=0;
@row1 =<FILE>;
close (FILE);

while (@row1[$count] ne "")

	{
	$row = @row1[$count];
	@row = split (/\|/, $row);
	$sortable_field = $row[$index_of_field_to_be_sorted_by];
	unshift (@row, $sortable_field);
	$new_row = join ("\|", @row);
	push (@new_rows, $new_row);
	$count++
        }

# Next, sort the lines of the database

	if ($form{'order'} eq "alpha")
	{
	@sorted_rows = sort (@new_rows);
	}
	else
	{
	@sorted_rows = reverse sort (@new_rows);
	}

#now put the field back where it belongs

@database_rows = ();
 foreach $sorted_row (@sorted_rows)
    {
    @row = split (/\|/, $sorted_row);
    $sorted_field = shift (@row);
    $old_but_sorted_row = join ("\|", @row);
    push (@database_rows, $old_but_sorted_row);
    }


# print the results into the database

	open(FILE, ">$data_location/$database");
     	print FILE (@database_rows);
	close(FILE);

print "<center><h2>Sorting Complete...</h2><P>\n";

}
##############################################################
# Display the Print Form
##############################################################
if ($form {'print'})
{

	print "<BR>Fields to Display:\n";
	print "<BR>Uncheck to remove from Printout Page...\n";

	$count=0;

	foreach $split_table_fields (@split_table_fields)
	{
	print "<br><INPUT type=\"checkbox\" name=\"$count\" value=\"$split_table_fields\" checked>$split_table_fields\n";
	$count++;
	}

	print "<center><INPUT type=\"Submit\"  name=\"print_display\" Value=\"   Prepare the Printout \"><P>\n";

}

##############################################################
# Display the Database for Printing
##############################################################
if ($form {'print_display'})
{


	print "<center><table border=0 cellspacing =5 width=500>\n";
	print "<tr>\n";

	$count=0;


	foreach $split_table_fields (@split_table_fields)
	{

	if ($form{$count} ne "")
	{print "<th width=100>$split_table_fields</td>\n";}

	$count++;

	}

	print "</tr>\n";


	open(DATABASE , "$data_location/$database");
	while (<DATABASE>)
	{
	$row = $_;
	chop $row;
	@fields = split (/\|/, $row);

	print "<tr>\n";

	$count=0;

	foreach $fields(@fields)
	{

	if ($form{$count} ne "")
	{print "<td><font size=-1>$fields</td>\n";}

	$count++;

	}

	print "</tr>\n";

	}
	close (DATABASE);

	print "</table>\n";

	print "<p>\n";
}

##############################################################
# Display the Addition Form Subroutine
##############################################################
sub display
{
	open (DATABASE, "$data_location/html.dat");

	while (<DATABASE>)
	{$html .= $_;}
	close (DATABASE);

	print "$html";
	print "<center><P><INPUT type=\"submit\"  name=\"add\" Value=\"  Add this directly to the Database  \">\n";
	print "<center><INPUT type=\"submit\"  name=\"preview\" Value=\"  Preview  \"><P>\n";
}
##############################################################
# Check Items for Duplicity in Item Number
##############################################################
sub check_items
{
	open (DATABASE, "$data_location/$database");
	while (<DATABASE>)
	{
	$row = $_;
	chop $row;

	@fields = split (/\|/, $row);

	if ( $form{$split_table_fields[0]} eq $fields[0])
	{
	print "  <center><h2>Your Product-ID must be different from all the others.<br>Please use your back button to correct this...</h2>\n";
	print "</body>\n";
	print "</html>\n";
	exit;
	}

	}
	close (DATABASE);

}

##############################################################
# Display the footer
##############################################################

	print "<center><P><hr><p>\n";
	print "<center><P><INPUT type=\"Submit\"  name=\"startup\" Value=\"   Enter New Items Form\">\n";
	print "<INPUT type=\"Submit\"  name=\"edit\" Value=\"   Edit the Database \"><p>\n";
	print "<INPUT type=\"Submit\"  name=\"sort\" Value=\"   Sort the Database \">\n";
	print "<INPUT type=\"Submit\"  name=\"search\" Value=\"   Search the Database \"><p>\n";
	print "<INPUT type=\"Submit\"  name=\"print\" Value=\"   Prepare a Printout \"><p>\n";
	print "<a href=\"display.cgi\" target=\"_new\">See the Data in Display.cgi Front End</a><p>\n";
	print "</body></html>\n";




}
	else
	{
	print "Incorrect logon. Use your back button to try again.";
	print"</body></html>\n";
	}

