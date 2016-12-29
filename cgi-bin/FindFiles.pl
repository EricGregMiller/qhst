#!/usr/bin/perl -w

# Find all files in a directory that match a template.

use Cwd;
use File::Find;

$dir = shift(@ARGV);
print "Directory: $dir\n";
$template = shift(@ARGV);
print "Template: $template\n";
$currWorkDir = &Cwd::cwd();
print "This dir = $currWorkDir\n";

finddepth(\&filehandler, $dir);

sub filehandler
{
  if (/$template/)
  {
    $fileName = $File::Find::name;
    $fileName =~ s/^$dir\///;
    print "$fileName\n";
  }
}
