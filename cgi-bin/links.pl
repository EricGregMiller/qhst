#!/usr/bin/perl -w

# Print links for a file

BEGIN
{
  my @htmLink = ();
  print $0;
}
if (m/(href|src)\s*=\s*"([^"]*)"/i)
{
  do
  {
    $link = $2;
    $exist = -e $link ? "Exist" : "**NOT";
    print "$link\n";
    if ($link =~ m/html?$/i)
    {
      $htmLink[$#htmLink+1] = $link;
    }
    s/(href|src)\s*=\s*"[^"]*"//i;
    #print $_;
  } while (m/(href|src)\s*=\s*"([^"]*)"/i);
}
END
{
  print "$#htmLink html links:\n";
  for ($iiLink=0; $iiLink<=$#htmLink; $iiLink++)
  {
    print "  $exist: $htmLink[$iiLink]\n";
  }
}
