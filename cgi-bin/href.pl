#!/usr/bin/perl -w

# Print href links for a file

if (m/href\s*=\s*"([^"]*)"/i)
{
  do
  {
    print "$1\n";
    s/href\s*=\s*"[^"]*"//i;
    #print $_;
  } while (m/href\s*=\s*"([^"]*)"/i);
}
  #chomp $line;
  #print "<!--$line-->\n";
  # Remove bgcolor attribute from tag.
  #s/bgcolor="\#\w*"//gi;
