#!/usr/bin/perl -w

# Print links for a file

sub AppendUnique
{
  my $iArray = shift;
  my $iNewElem = shift;
  #print "New element = $iNewElem\n";
  $inArray = 0;
  foreach $elem (@$iArray)
  {
    if ($elem eq $iNewElem)
    {
      $inArray = 1;
      last;
    }
  }
  if (!$inArray)
  {
    $$iArray[1+$#$iArray] = $iNewElem;
  }
}

use Cwd;
use File::Basename;

$currWorkDir = &Cwd::cwd();
$currWorkDir .= "/";
#print "This dir = $currWorkDir\n";
$webRoot = "/home/sites/site40/web/";

@htmFiles=@ARGV;
foreach $file (@htmFiles)
{
  print "File $file\n";
  my($filename, $directories, $suffix) = fileparse($file);
  print "Dir $directories\n";
  # Open input html file
  open (FIN,$file) || die "Could not open input $file";
  # Open temporary output file
  #$tempFileName = "$file.$$.temp";
  #open (FOUT,">$tempFileName") || die "Could not open output $tempFileName";

  my @htmLink = ();
  my @badLink = ();
  #print $0;

  # Loop through lines in file.
  while ($line = <FIN>)
  {

    while ($line =~ m/(href|src)\s*=\s*"([^"]*)"/i)
    {
      $link = $2;
      if ($link !~ m/^(mailto:|http:|www\.)/i)
      {
        $fqfLink = $link;
        if ($fqfLink =~ m?^/?)
        {
          $fqfLink =~ s?^/?$webRoot?;
        }
        else
        {
          $fqfLink = $currWorkDir . $directories . $fqfLink;
        }
        $exist = -e $fqfLink ? "Exist" : "**NOT";
        #print "$link\n";
        if ($exist ne "Exist")
        {
          print "fqfLink = $fqfLink\n";
          AppendUnique(\@badLink,$link);
        }
        elsif ($link =~ m/html?$/i)
        {
          AppendUnique(\@htmLink,$link);
        }
      }
      $line =~ s/(href|src)\s*=\s*"[^"]*"//i;
    }
  }

  if ($#badLink >= 0)
  {
    print "\n";
    print "$#badLink Bad Links *************************\n";
    foreach $blink (@badLink)
    {
      print "  $blink\n";
    }
  }
  if ($#htmLink >= 0)
  {
    print "\n";
    print "$#htmLink HTML Links:\n";
    foreach $hlink (@htmLink)
    {
      print "  $hlink\n";
    }
  }

  # Close files
  close (FIN);
  #close (FOUT);

  # Rename temp file to input file.
  #rename ($tempFileName, $file) || die "Could not rename $file.xx to $file";
}
