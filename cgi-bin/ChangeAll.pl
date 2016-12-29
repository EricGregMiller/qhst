#!/usr/bin/perl -w

# Change all occurance of first string to second string in input files.

$searchStr = shift(@ARGV);
print "Search string: $searchStr\n";
$replaceStr = shift(@ARGV);
print "Replace string: $replaceStr\n";

foreach $file (@ARGV)
{
  print "File $file\n";
  # Open input html file
  open (FIN,$file) || die "Could not open input $file";
  # Open temporary output file
  $tempFileName = "$file.$$.temp";
  open (FOUT,">$tempFileName") || die "Could not open output $tempFileName";

  # Loop through lines in file and make replacements.
  while ($line = <FIN>)
  {
    $line =~ s/$searchStr/$replaceStr/g;
    print FOUT $line;
  }

  # Close files
  close (FIN);
  close (FOUT);

  # Rename temp file to input file.
  rename ($tempFileName, $file) || die "Could not rename $file.xx to $file";
}
