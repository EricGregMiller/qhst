#!/usr/bin/perl

##############################################################
#
#	Display.cgi for Database_Doctor.cgi
#	Mike Carville
#	www.web-bazaar.com
#	carville@web-bazaar.com
#
#	I originally wrote the Database Doctor to manage inventory files for webstores,
#	specifically Selena Sols. But since everyone has an imagination and is generally 
#	looking for the best fit of something existing to a custom project, people 
#	were constantly asking for a front end.  
#	
#	Ok, so now you have it.
#	
#	Display.cgi will display your flat file database made in Database Doctor,
#	or just about any I suppose. I believe I have given you a way to be really 
#	creative with the html as well. You be the judge, As always, to make something 
#	better, it gets more complicated.
#	
#	After we discuss the file setup here, read below, as there more comments placed
#	to help you use this to it's fullest.
#	
#	The working example of what I am using this for is at www.fsfprs.com
#	A database of Facial Plastic Surgeons.
#	
#	Main CGI Directory
#	--------------
#	display.cgi (permission 755)
#	
#	Data
#	--------------
#	Set this line to the location of the data file you wish to search and display
#	*This is a server path without a slash on the end.*

$datafile = "/home/home/sites/siteXX/web/cgi-bin/doctor/data/rawdata.dat";

#	HTML Files
#	--------------
# 	This script uses templates for the header of the page, 
#	the footer of the page, and a search form. Note the Usage of the 
#	example files provided. These are SECTIONS of a page...
#	not the whole page...hint hint.
#
#	Set the location of the html directory here. 
#	*This is a server path without a slash on the end.*

$data_path = "/home/sites/siteXX/web/cgi-bin/doctor/html";

#	HTML Files Required
#	-------------------
# 	These files must exist, even if empty. They must be in the directory set above.
#	
#	display_header.dat 
#	-html for the top of the web page created. Starts with <html> and has a full head.
#
#	display_footer.dat
#	-html for the bottom of the page. Ends with </html> DOES NOT INCLUDE THE <HTML> tag.
#
#	search_form.dat
#	-this is a custom little search form. Starts and ends with a form tag...completely
#	 self contained. More on how to set this up below.
#	
#	Search Terms
#	-------------------
#
#	This is my little concept. Lets see if I can explain. The search works on
#	a whittling down process. It starts with the whole file as a result, and the performs
#	a progreesive amount of searches against each result.
#	
#	The results from the first search term are used in the next search. Thats
#	how it whittles down the results.
#	
#	Number one the keyword filed in your search MUST be named searchtext. That is
#	what the script is looking for.
#	
#	After that you may have as many different search terms as you like, and you will
#	set them in the array (an @ variable) below. On the Search form itself you will make 
#	a field with the matching name listed here. Leave the first option with a value
#	of nothing if you want people to be able to ignore the field. (<option value=""></option>)
#	
#	So what this allows is a search on any number of terms the user decides on. In the case of an
#	address book this may mean the search for a city, or a state, or both by choosing 
#	something form each list. The best way to do this is to use drop down lists. 
#	This will allow you to TELL THE USER WHAT TO LOOK FOR. This is the important 
#	part of the concept. By telling them what they can look for, you help them find results.
#	
#	You can look at my auction site for an example of how to use this. Look at the 
#	Quick List Search Form on this page...http://www.auction-network.com/html/categories.htm
#	
#	Syntax is important here...you are setting a perl variable. A long list would look like this...
#	@searchterms = ("city","state","zip");
#	
#	remember that the search term must match the field name in the form for it to be checked.

@searchterms = ("city");

#	Revolving Color Option
#	----------------------
#	
#	If you want a Table of results to use rotating colors, set the hex color values here.


$bgcolor1 = "#F8F1F1";
$bgcolor2 = "#ffffff";

#	
#	The next Four parts are the html for the search results. This is set to use tables, but
#	you could easily not use them. Have fun...this is VERY flexible with a little imagination.
#	
#	A note about print qq! statements.
#	----------------------------------
#	
#	we use the print qq! statement to print large blocks of html here. 
#	This changes the rules a little..for the better.
#	
#	-you do not need to precede a quotation (") with a slash as you would in a normal print satement.
#	-you still need to precede the @ sign not used as a variable...like an email address...like this \@
#	-in a print qq! you need to precede the exclamation point with a slash, 
#	 as it is looking for that as the end of the print statement.... use \!
#	
#	Table Header or Top of Display
#	------------------------------
#	
#	really basic here...just html
#	


sub table_header
{
print qq!
<CENTER><TABLE cellspacing="" cellpadding="5" COLS=2 WIDTH="90%" border=0>
<TR BGCOLOR="#800000">
<TD WIDTH="50%"><FONT face=Arial,Helvetica" size="3" color="ffffff">Name</FONT></TD>

<TD WIDTH="50%"><FONT face=Arial,Helvetica" size="3" color="ffffff">Comment</font></TD>
</TR>
!; # end of print statement
}

#	Not So Basic...the individual search result
#	-------------------------------------------
#	
#	You have a lot of options here, and a little perl knowledge will help. However, I will try to
#	tell you everything you need to know. At the bottom is a specific example of a customization I used. 
#	Don't be afraid to try!
#	
#	The program is taking the result and splitting it up into an array. You can then display
#	whatever parts of this individual line here by using a variable.
#	
#	We have split the line into the array @field. Individual parts of the array are accessed by
#	telling it what number you want.
#	
#	VERY IMPORTANT...arrays start counting from zero!  
#	
#	So the first field in the line is $field[0], the fifth $field[4] etc...
#	
#	The variable name field is case sensitive!
#	
#	Include any html you want, and place your fields in any order. If you want to use rotating
#	rows of color, set your table row to include <TR bgcolor=$bgcolor>, and set the colors above.
#	The use of other variables is explained below. Otherwise $email and others have no value.

sub table_row
{
	$email="";$website="";$name="";
	
	if ($field[2] ne "")
	{$name="<BR>$field[2]";}
	
	if ($field[4] ne "")
	{$email="<BR>Email: <a href=\"mailto:$field[4]\">$field[2]</a>";}
	
	if ($field[5] ne "")
	{$website="<BR>Website: <a href=\"$field[5]\">$field[5]</a>";}

print qq!
<TR bgcolor=$bgcolor>
<TD WIDTH="50%" valign=top>
<BR>$field[0] $field[1] of $field[3]
$name
$email
$website
</TD>

<TD WIDTH="50%" valign=top>
$field[6]</TD>
</TR>


!;
}

#	Table Footer or Bottom of Display
#	------------------------------
#	
#	really basic here...just html
#	but I would caution you that Netscape will not show incomplete tables
#	...so make sure you close it out.

sub table_footer
{
print qq!
<TR BGCOLOR="#800000">
<TD><font size="1">&nbsp;</font></TD><TD><font size="1">&nbsp;</font></TD>
</TR>
</TABLE></CENTER>


!;
}

#	Customization Example
#	------------------------------
#	
#	In my original usage for the script I have email and website addresses. 
#	Some lines have them, and some don't. I only want to show them if they exist.
#	You can do this for as many of the fields as you like.
#	So we make a little if statement...
#
#	if ($field[5] ne "")
#
#	This is using a double negative...and reads if the 4th 
#	field is not equal to nothing, then it is something and do this...
#
#	{$address2="<BR>$field[5]";}
#
#	What we do next is set the value of the field to a variable name. We then put the variable name
#	in the the table row html where we would want it if it existed. If it exists, it will show up there.
#	If it does have no value, nothing will appear.
#
#	But Perl Programmers..this leaves us open to a lttle programming problem.
#	...if one line has a value, and the next does not, we need to clear 
#	out the value of our variable beforehand. We do this by setting the value of the variable
#	we are using before we ask the if question and possible set a value.
#
#	Below is the all of this put together. Remember to take out the comments (#) if you try it out.


#	$address2="";$email="";$website="";$name="";
#	
#	
#	if ($field[5] ne "")
#	{$address2="<BR>$field[5]";}
#	
#	if ($field[3] ne "")
#	{$name="$field[3]";}
#	
#	if ($field[12] ne "")
#	{$email="<BR>Email: <a href=\"mailto:$field[12]\">$field[12]</a>";}
#	
#	if ($field[13] ne "")
#	{$website="<BR>Website: <a href=\"$field[13]\">$field[13]</a>";}


##############################################################
##############################################################
# End Of configure
##############################################################
##############################################################


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


print "Content-type: text/html\n\n";

##############################################################
#  Read in data and decide what to do
##############################################################



open (FILE, "$data_path/display_header.dat") || die print "$html_path/display_header.dat";
while(<FILE>)
{$row = $_;chop $row;
$header .= "$row\n";}
close (FILE);

open (FILE, "$data_path/display_footer.dat") || die print "$data_path/display_footer.dat";
while(<FILE>)
{$row = $_;chop $row;
$footer .= "$row\n";}
close (FILE);


open (FILE, "$data_path/search_form.dat") || die print "$data_path/search_form.dat";
while(<FILE>)
{$row = $_;chop $row;
$search_form .= "$row\n";}
close (FILE);



	open (DATABASE, "$datafile") || die print "$datafile";
	@data=<DATABASE>;
	close (DATABASE);



##############################################################
#  Search if necessary
##############################################################

if ($form{'search'} eq "search")
{

foreach $searchterms(@searchterms)
{


if ($form{$searchterms} ne "")
	{
	foreach $data(@data)
		{
		if ($data =~ /\b$form{$searchterms}\b/i)
		{
		$found = "N";
		foreach $results(@results)
		{
		if ($results eq $data)
			{$found ="Y";}
		}

		if ($found eq "N")
		{push (@results,$data);}

		}
		}
@data=@results;
@results=();
	}

}





@searchText = split(/\x20/,$form{'searchtext'});
    foreach $test (@searchText)
    { if ($test =~ /\S{2,}/)
      { push @searchKey, $test;}
    }

if ($form{'searchtext'} ne "")
	{



	foreach $data(@data)
		{

        foreach $test(@searchKey)
        { if ($data =~ /\b$test\b/i){
		$found = "N";
		foreach $results(@results)
		{
		if ($results eq $data)
			{$found ="Y";}
		}

		if ($found eq "N")
		{push (@results,$data);}
		
		}
	   }

		}
@data=@results;
@results=();
	}


}

##############################################################
#  Begin the page of results
##############################################################
print "$header";


if (@data > 0)
{
&table_header;


	foreach $data(@data)
	{
	@field = split (/\|/, $data);


	if ($bgcount > 1)
	{$bgcolor=$bgcolor2;$bgcount=1;}
	else
	{$bgcolor=$bgcolor1;$bgcount=2;}

	&table_row;
	}

&table_footer;
}
else
{
print "<P><ul><ul>Sorry, nothing has matched what you are searching for. Please try again.</ul></ul><P>";
}

print "<P>$search_form<P>";
print "<P>$footer<P>";



