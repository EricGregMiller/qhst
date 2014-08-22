#!/usr/bin/perl -w
# ----------------------------------------------------------------------------
# MyDiary.pl - a Perl Diary Script
# Copyright (c) 2001 Jason M. Hinkle. All rights reserved. This script is
# free software; you may redistribute it and/or modify it under the same
# terms as Perl itself.
# For more information see: http://www.verysimple.com/scripts/
#
# LEGAL DISCLAIMER:
# This software is provided as-is.  Use it at your own risk.  The
# author takes no responsibility for any damages or losses directly
# or indirectly caused by this software.
# 
# VERSION HISTORY
# 1.2.5 - fixed result page weirdness & lots of display options
# 1.2.4 - patch for FNF bug & better error reporting
# 1.2.3 - fixed date formatting bug
# 1.2.2 - fixed result paging bug
# 1.2.1 - added DescendingSort and BannerText
# 1.2.0 - combined private.pl, public.pl and setup.pl into one file
# 1.1.0 - original release
# ----------------------------------------------------------------------------

my $VERSION = "1.2.5";

BEGIN {
########################################################################
#                       Config Variables                                                                                  #
########################################################################
    
	# this is the relative path to the config file.  update only if necessary
    $ENV{"CONFIG_FILE"} = "/data/MyDiary.cfg";

    # This is the installation path for the script.  If you recieve an error telling you to manually set
    # the path, replace GetCwd($ENV{"CONFIG_FILE"}) with the full path to your script for example:
    #		$ENV{"CWD"} = "C:/wwwroot/cgi-bin/myscript";
    # Leave off any trailing slashes, and replace all backslashes "\" with forward slashes "/"
    
    $ENV{"CWD"} = GetCwd($ENV{"CONFIG_FILE"});
    
    # uncomment this line if you are experiencing 404 errors
    # $ENV{"SCRIPT_NAME"} = "MyDiary.pl";
    
    # uncomment for faster perceived performance (warning: may cause some browsers to hang)
    # $| = 1;  

########################################################################
#                       End Config Variables                                                                            #
########################################################################
    
    # add the current directory to the perl path so our libraries can be found
    push(@INC,$ENV{"CWD"});

    sub GetCwd {
		# this function tries various methods to get the installation directory.  if it is not found,
		# an error is displayed telling the user to edit the script manually
		my ($testFile) = shift || "";
		# try to get install path from env vars first, if that doesn't work, try Cwd, otherwise, fail.
		# all the wierd || business is to prevent uninitialized var warnings
		my ($fullPath) = $ENV{"PATH_TRANSLATED"} || $ENV{"SCRIPT_FILENAME"} || ( ($ENV{"DOCUMENT_ROOT"} || "") . ($ENV{"SCRIPT_NAME"} || "") ) || "./";
		$fullPath =~ s|\\|\/|g;
		my ($filePath) = substr($fullPath,0, rindex($fullPath,"/"));
		if (-e "$filePath/$testFile") {
			return $filePath
		}
		# fist method failed, now try Cwd
		use Cwd;
		$filePath = Cwd::cwd();
		if (-e "$filePath/$testFile") {
			return $filePath
		}
		# both methods failed.  Print a friendly error
		print "Content-type: text/html\n\n";
		print "<b>Installation path could not be determined.</b>\n";
		print "<p>Please edit the script and set \$ENV{\"CWD\"} to the full path in which the script is installed.";
		exit 1;
    }
} # / BEGIN
# ----------------------------------------------------------------------------


print "Content-type: text/html\n\n";

eval 'use vsDB';
eval 'use CGI';

# --- get the configuration settings 
my ($configFilePath) = $ENV{"CWD"} . $ENV{"CONFIG_FILE"};
my ($objConfig) = new vsDB(
	file => $configFilePath,
	delimiter => "\t",
);
if (!$objConfig->Open) {
	print "<b>An error occured while opening the configuration file!</b>";
	print "<p>Make sure that you have specified the correct path and that file permissions are set correctly.";
	print "<p>Details: " . $objConfig->LastError;
	exit 1;
}
my ($title) = $objConfig->FieldValue("Title");
my ($bannerText) = $objConfig->FieldValue("BannerText");
my ($backgroundImage) = $objConfig->FieldValue("BackgroundImage");
my ($headerColor) = $objConfig->FieldValue("HeaderColor");
my ($headerTextColor) = $objConfig->FieldValue("HeaderTextColor");
my ($textColor) = $objConfig->FieldValue("TextColor");
my ($fontFace) = $objConfig->FieldValue("FontFace");
my ($tableColor) = $objConfig->FieldValue("TableColor");
my ($privateIcon) = $objConfig->FieldValue("PrivateIcon");
my ($publicIcon) = $objConfig->FieldValue("PublicIcon");
my ($fileName) = $objConfig->FieldValue("FileName") || "calendar.tab";
my ($delimiter) = $objConfig->FieldValue("Delimiter") || "\t";
my ($descOrder) = $objConfig->FieldValue("DescendingOrder") || 0;
my ($authUserId) = $objConfig->FieldValue("UserId") || "*";
my ($authPassword) = $objConfig->FieldValue("Password") || "*";
# -- end config

my ($filePath) = $ENV{"CWD"} . "/" . $fileName;

# print the header
print "
	<html>
	<head><title>$title</title></head>
	<body bgcolor='#FFFFFF' background='$backgroundImage' text='$textColor' link='$textColor' vlink='$textColor'>
	<font face='$fontFace' size='2' color='$textColor'>
";
if ($headerColor || $headerTextColor) {
	print "<table ";
	print "bgcolor='$headerColor' " if ($headerColor);
	print "border='0' width='100%'><tr><td><b><font color='$headerTextColor'>$title</font></b></td></tr></table>\n";
}
print "<p>\n";
print "$bannerText \n";
print "<p>\n";


my ($scriptName) = $ENV{'SCRIPT_NAME'} || "private.pl";
my ($objCGI) = new CGI;

my ($command) = $objCGI->param('vsCOM') || "";
my ($id) = $objCGI->param('vsID') || "";
my ($activePage) = $objCGI->param('vsAP') || "";
my ($userId) = $objCGI->param('vsUserId') || "";
my ($password) = $objCGI->param('vsPassword') || "";
my ($dontPrintAll) = 0;
my ($isAdministrator) = 0;
$isAdministrator = 1 if ($userId eq $authUserId && $password eq $authPassword);

my ($objDB) = new vsDB(
	file => $filePath,
	delimiter => $delimiter,
);

# if datafile is not found, go to setup screen, or allow login
if (!$objDB->Open) {
	print "<b>An error occured while opening the data file!</b>";
	print "<p>Make sure that you have specified the correct path and that file permissions are set correctly.";
	print "<p>Details: " . $objDB->LastError;
	$command = "SETUP" unless ($command eq "SETUPUPDATE" || $command eq "LOGIN") ;
}

if ($command eq "ADD") {
	PrintBlankRecord();
	$dontPrintAll = 1;

} elsif ($command eq "LOGIN") {
	PrintLogin();
	$dontPrintAll = 1;

} elsif ($command eq "EDIT") {
	$objDB->Filter("Id","eq",$id);
	if ($isAdministrator) {
		PrintCurrentRecord($objDB);
	} else {
		PrintCurrentRecordReadOnly($objDB);
	}		
	$dontPrintAll = 1;

} elsif ($command eq "UPDATE" && $isAdministrator) {
	$objDB->Filter("Id","eq",$id);
	UpdateCurrentRecord($objDB,$objCGI);

} elsif ($command eq "SETUP" && $isAdministrator) {
	PrintSetup($objConfig);
	$dontPrintAll = 1;

} elsif ($command eq "SETUPUPDATE" && $isAdministrator) {
	UpdateSetup($objConfig,$objCGI);
	$dontPrintAll = 1;

} elsif ($command eq "DELETE" && $isAdministrator) {
	$objDB->Filter("Id","eq",$id);
	$objDB->Delete;
	$objDB->Commit;

} elsif ($command eq "INSERT" && $isAdministrator) {
	$objDB->AddNew;
	my ($newId) = $objDB->Max("Id") || 0;
	$newId = int($newId) + 1;
	$objDB->FieldValue("Id",$newId);
	UpdateCurrentRecord($objDB,$objCGI);
}

# show the default screen if specified
unless ($dontPrintAll) {
	$objDB->RemoveFilter;
	$objDB->Sort("Date",$descOrder);

	# only the administrator can view private posts
	$objDB->Filter("Private","ne","checked") unless ($isAdministrator);
	
	$objDB->MoveFirst;
	PrintAllRecords($objDB,$activePage);
}


# --- print the html footer ---
print "
	<p>
	<hr><font size='1'>
	My Diary $VERSION &copy 2001, <a href='http://www.verysimple.com/'>VerySimple</a><br>
";
print "vsDB Module Version " . $objDB->Version;
print "
	</font><p>
	</font>
	</body>
	</html>
";

$objDB->Close;
undef($objDB);

$objConfig->Close;
undef($objConfig);

#_____________________________________________________________________________
sub PrintLogin {
	print "<script>\n";
	print "function ValidateForm(objForm) {\n";
	print "	if (objForm.vsUserId.value == '' || objForm.vsPassword.value == '') {\n";
	print "		alert('Please enter your User ID and Password.');\n";
	print "		return false;\n";
	print "	} else {\n";
	print "		return true;\n";
	print "	}\n";
	print "}\n";
	print "</script>\n";
	print "<b>Please login to continue:</b>\n";
	print "<p>\n";
	print "<form action='$scriptName' method='post' onsubmit=\"return ValidateForm(this);\">\n";
	print "<table border='0' cellspacing='1' cellpadding='2' style=\"FONT-SIZE: 10pt;FONT-FAMILY: '$fontFace';\">\n";
	print "<tr valign='top' ";
	print "bgcolor='$tableColor'" if $tableColor;
	print">\n";
	print "<td>User ID:</font></td>\n";
	print "<td><input type='text' size='40' name='vsUserId'></td>\n";
	print "</tr>\n";
	print "<tr valign='top' ";
	print "bgcolor='$tableColor'" if $tableColor;
	print">\n";
	print "<td>Password:</font></td>\n";
	print "<td><input type='password' size='40' name='vsPassword'></td>\n";
	print "</tr>\n";
	print "</table>\n";
	print "<p>\n";
	print "<input type='submit' value='Login'> <input type='reset'>\n";
	print "</form>\n";
}

#_____________________________________________________________________________
sub PrintAllRecords {
	my ($objMyDB) = shift || return 0;
	my ($activePage) = shift || 1;
	my ($pageSize) = shift || 10;
	my ($fieldName);
	my ($count) = 0;

	my (@fieldNames) = ['Code','Category','Description'];

	$objMyDB->ActivePage($activePage);
	my ($pageCount) = $objMyDB->PageCount;

	print "<table cellspacing='2' cellpadding='2' border='0' style=\"FONT-SIZE: 10pt; COLOR: $textColor FONT-FAMILY: '$fontFace';\">\n";
	#print "<tr valign='top' bgcolor='#CCCCCC'>\n";
	#print "<td>&nbsp;</td>\n";
	#print "<td><b>Date</b></td>\n";
	#print "<td><b>Title</b></td>\n";
	#print "</tr>\n";
	while (!$objMyDB->EOF && $count < $pageSize) {
		print "<tr valign='top' ";
		print "bgcolor='$tableColor'" if $tableColor;
		print">\n";
		print "<td><a href='" . $scriptName . "?vsCOM=EDIT&vsID=" . $objMyDB->FieldValue("Id") . "&vsUserId=$userId&vsPassword=$password' ";
		print "onmouseover=\"window.status='Edit This Entry';return true;\" onmouseout=\"window.status='Done';return true;\">";
		if ($objMyDB->FieldValue("Private") eq "checked") {
			print "<img src='$privateIcon' alt='Edit This Entry' border='0'</a></td>\n";
		} else {
			print "<img src='$publicIcon' alt='Edit This Entry' border='0'</a></td>\n";
		}
		print "<td>" . FormatDate($objMyDB->FieldValue("Date")) . "</td>\n";
		print "<td>" . $objMyDB->FieldValue("Title") . "</td>\n";
		print "</tr>\n";
		$objMyDB->MoveNext;
		$count++;
	}	
	print "</table>\n";
	print "<p>\n";

	print "Page " . $activePage . " of " . $pageCount;
	if ($activePage > 1) {
		print " <a href='?vsAP=" . ($activePage - 1) . "&vsUserId=$userId&vsPassword=$password' onmouseover=\"window.status='Previous';return true;\" >Previous</a>";
	}
	if ($activePage < $pageCount) {
		print " <a href='?vsAP=" . ($activePage + 1) . "&vsUserId=$userId&vsPassword=$password' onmouseover=\"window.status='Next';return true;\" >Next</a>";
	}
	print " (" . $objMyDB->RecordCount . " Entries)\n";
	print "<p>\n";
	print "<form action='$scriptName' method='post'>\n";
	if ($isAdministrator) {
		print "<input type='submit' value='New Diary Entry' onclick=\"this.form.vsCOM.value='ADD';return true;\">\n";
		print "<input type='reset' value='Logout' onclick=\"self.location='$scriptName';return false;\">\n";
		print "<input type='submit' value='Setup' onclick=\"this.form.vsCOM.value='SETUP';return true;\">\n";
		print "<input type='hidden' name='vsCOM' value='ADD'>\n";
		print "<input type='hidden' name='vsUserId' value='$userId'>\n";
		print "<input type='hidden' name='vsPassword' value='$password'>\n";
		print "<p>\n";
		print "<font size='1'>You are currently logged in as Author</font>\n";
	} else {
		print "<p>\n";
		print "<font size='1'>You are currently logged in as <a href='$scriptName?vsCOM=LOGIN'>Guest</a></font>\n";
	}		
	print "</form>\n";
}



#_____________________________________________________________________________
sub PrintCurrentRecord {
	my ($objMyDb) = shift || return 0;
	print "<form action='$scriptName' method='post'>\n";
	print "<input type='hidden' name='vsCOM' value='UPDATE'>\n";
	print "<input type='hidden' name='vsUserId' value='$userId'>\n";
	print "<input type='hidden' name='vsPassword' value='$password'>\n";
	print "<input type='hidden' name='vsID' value='" . $objMyDb->FieldValue("Id") . "'>\n";
	print "<input type='hidden' name='Date' value='" . $objMyDb->FieldValue("Date") . "'>\n";
	print "<b>Title:</b> <input type='text' name='Title' size='65' value='" . $objMyDb->FieldValue("Title") . "'>\n";
	print "<p>\n";
	print "<textarea name='DiaryEntry' cols='65' rows='20'>" . $objMyDb->FieldValue("DiaryEntry") . "</textarea>\n";
	print "<p>\n";
	print "<b>Make This Entry Private:</b> <input type='radio' name='Private' value='checked' " . $objMyDb->FieldValue("Private") . ">Yes\n";
	print "<input type='radio' name='Private' value=' ' ";
	print "checked" if ($objMyDb->FieldValue("Private") ne "checked");
	print ">No\n";
	print "<p>\n";
	print "<input type='submit' value='Update This Entry'>\n";
	print "<input type='submit' value='Delete This Entry' onclick=\"if( confirm('Are you sure?')) {this.form.vsCOM.value='DELETE';return true;} else {return false;};\">\n";
	print "<input type='reset' value='Cancel' onclick=\"self.history.go(-1);return false;\">\n";
	print "</form>\n";
}	

#_____________________________________________________________________________
sub PrintCurrentRecordReadOnly {
	my ($objMyDb) = shift || return 0;
	my ($dataEntry) = $objMyDb->FieldValue("DiaryEntry");
	$dataEntry =~ s/\n/<br>/g;
	print "<form action=''>\n";
	print "<table border='0' cellspacing='2' width='100%' cellpadding='2' style=\"FONT-SIZE: 10pt;FONT-FAMILY: '$fontFace';\">\n";
	print "<tr valign='top' ";
	print "bgcolor='$tableColor'" if $tableColor;
	print">\n";
	#print "<td>Title:</td>";
	print "<td><b>" . $objMyDb->FieldValue("Title") . "</b></td>";
	print "</tr>\n";
	print "<tr valign='top' ";
	print "bgcolor='$tableColor'" if $tableColor;
	print">\n";
	#print "<td>Date</td>";
	print "<td><i>" . FormatDate($objMyDb->FieldValue("Date")) . "</i></td>";
	print "</tr>\n";
	print "<tr valign='top'><td>&nbsp;</td></tr>";
	print "<tr valign='top' ";
	print "bgcolor='$tableColor'" if $tableColor;
	print">\n";
	#print "<td>Entry:</td>";
	print "<td>" . $dataEntry . "</td>";
	print "</tr>\n";
	print "</table>\n";
	print "<p>\n";
	print "<input type='reset' value='Back...' onclick=\"self.history.go(-1);return false;\">\n";
	print "</form>\n";
}	

#_____________________________________________________________________________
sub PrintSetup {
	my ($objMyDB) = shift;
	my ($fieldName, $fieldValue);
	print "<form action='$scriptName' method='post' onsubmit=\"if (this.Password.value != this.PasswordConfirm.value) {alert('Passwords do not match.'); return false;}\">\n";

	print "<table cellspacing='2' cellpadding='2' border='0'>\n";
	foreach $fieldName ($objMyDB->FieldNames) {
		print "<tr valign='top' bgcolor='$tableColor'>\n";
		print "<td><font face='$fontFace' size='2'>" . $fieldName . "</font></td>\n";
		print "<td>\n";


		$fieldValue = $objMyDB->FieldValue($fieldName);
		$fieldValue =~ s/\"/&quot;/g;		

		if ($fieldName eq "Password") {
			print "<input type=\"password\" size=\"50\" name=\"Password\" value=\"" . $fieldValue . "\">";
		} elsif ($fieldName eq "BannerText") {			
			print "<textarea cols=\"45\" rows=\"5\" name=\"" . $fieldName . "\" >" . $fieldValue . "</textarea>";
		} else {			
			print "<input size=\"50\" name=\"" . $fieldName . "\" value=\"" . $fieldValue . "\">";
		}

		print "</td>\n";
		print "</tr>\n";
	}

	print "<tr valign='top' ";
	print "bgcolor='$tableColor'" if $tableColor;
	print">\n";

	print "<td><font face='arial' size='2'>Confirm Password</font></td>\n";
	print "<td><input type=\"password\" size=\"50\" name=\"PasswordConfirm\" value=\"". $objMyDB->FieldValue("Password") . "\">";
	print "</tr>\n";
	
	print "</table>\n";
	print "<p>\n";
	print "<input type='hidden' name='vsCOM' value='SETUPUPDATE'>\n";
	print "<input type='hidden' name='vsUserId' value='$userId'>\n";
	print "<input type='hidden' name='vsPassword' value='$password'>\n";
	print "<input type='submit' value='Apply'>\n";
	print "<input type='reset' value='Cancel' onclick=\"window.history.go(-1);return false;\">\n";
	print "</form'>\n";
}
#_____________________________________________________________________________
sub PrintBlankRecord {
	print "<form action='$scriptName' method='post'>\n";
	print "<input type='hidden' name='vsCOM' value='INSERT'>\n";
	print "<input type='hidden' name='vsUserId' value='$userId'>\n";
	print "<input type='hidden' name='vsPassword' value='$password'>\n";
	print "<input type='hidden' name='Date' value='" . &GetDate(3) . "'>\n";
	print "<b>Title:</b> <input type='text' name='Title' size='65'>\n";
	print "<p>\n";
	print "<textarea name='DiaryEntry' cols='65' rows='20'></textarea>\n";
	print "<p>\n";
	print "<b>Make This Entry Private:</b> <input type='radio' name='Private' value='checked'>Yes\n<input type='radio' name='Private' value=' ' checked>No\n";
	print "<p>\n";
	print "<input type='submit' value='Add This Entry'>\n";
	print "<input type='reset' value='Reset' onclick=\"return confirm('Are you sure?');\">\n";
	print "<input type='reset' value='Cancel' onclick=\"self.history.go(-1);return false;\">\n";
	print "</form>\n";
}

#_____________________________________________________________________________
sub UpdateSetup {
	my ($objMyDB) = shift;
	my ($objMyCGI) = shift;
	my ($fieldName,$fieldValue);
	foreach $fieldName ($objMyDB->FieldNames) {
		$fieldValue = $objMyCGI->param($fieldName);
		$objMyDB->FieldValue($fieldName,$fieldValue);
	}
	if (!$objMyDB->Commit) {
		print "<b>An error occured while writing to the configuration file!</b>";
		print "<p>Make sure that the file permissions are correct on the configuration file.";
		print "<p>Details: " . $objMyDB->LastError;
		exit 1;
	};
	print "<script>\n";
	print "self.location='$scriptName?vsUserId=$userId&vsPassword=$password';\n";
	print "</script>\n";
}

#_____________________________________________________________________________
sub UpdateCurrentRecord {
	my ($objMyDB) = shift;
	my ($objMyCGI) = shift;
	$objMyDB->FieldValue("Date",$objMyCGI->param("Date"));
	$objMyDB->FieldValue("Title",$objMyCGI->param("Title"));
	$objMyDB->FieldValue("Private",$objMyCGI->param("Private"));
	$objMyDB->FieldValue("DiaryEntry",$objMyCGI->param("DiaryEntry"));
	if (!$objMyDB->Commit) {
		print "<b>An error occured while writing to the data file!</b>";
		print "<p>Make sure that the file permissions are correct on the data file.";
		print "<p>Details: " . $objMyDB->LastError;
		exit 1;
	};
}

#______________________________________________________________________________
sub FormatDate {
	my ($date) = shift || return 0;
	my ($mode) = shift || 0;
	my (@months) = ('','January','February','March','April','May','June','July','August','September','October','November','December');
	my (@days) = ('','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

	my ($year,$month,$day) = split("\/",$date);
	
	return $months[$month] . "&nbsp;" . $day . ",&nbsp;" .  $year;
}

#______________________________________________________________________________
sub GetDate {
	# version 2.0
	# Usage:
	#	&GetDate	# returns mm/dd/yyyy 
	#	&GetDate(1)	# returns mm/dd/yy 
	#	&GetDate(2,	# returns yy/mm/dd 
	#	&GetDate(3)	# returns yyyy/mm/dd 
	my ($mode) = shift || 0;
	my (@months) = ('01','02','03','04','05','06','07','08','09','10','11','12');
	my ($sec,$min,$hour,$mday,$mon,$year,$wday) = (localtime(time))[0,1,2,3,4,5,6];
	$mday = "0" . $mday if (length($mday) < 2);
	my $date = "";
	$year += 1900;
	if ($mode == 1) {
		$year = substr($year,2);
		$date = "$months[$mon]\/$mday\/$year";
	} elsif ($mode == 2) {
		$year = substr($year,2);
		$date = "$year\/$months[$mon]\/$mday";	
	} elsif ($mode == 3) {
		$date = "$year\/$months[$mon]\/$mday";	
	} else {
		# mode = 0 
		$date = "$months[$mon]\/$mday\/$year";	
	}
	return $date;
}

