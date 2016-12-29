#!/usr/bin/perl
# AlienForm2 - Released 23 May, 1998. (v2.02)
# This version released 02 Jan, 1999
# Copyright 1997, 1998, 1999 Jon Hedley - jon@cgi.tj
# All Rights Reserved.
# Do not discribute this script without my express, written permission!
# Remember to upload in ASCII mode!
# Work hard, and be good to your mother.

# Set this to the required MIME type. The default should be fine.
$content_type   = "Content-Type: text/html\n\n";

# Set this to the base path of your templates. The files specified in
# the HTML and log template will be appended to this to make the real
# file name.

$base_path      = '/home/sites/www.theology.edu/web/cgi-bin/';

# Set this to the command to load your mailer, that will accept all info
# via STDIN.
$mail_cmd       = '/usr/sbin/sendmail -t';

# Set this to the list of Valid Referers- ie those sites & pages
# you want to be able to use the script. All others will be denied
# access. You can be very specific so only one page has access, or
# general so a whole site can use it. To allow any site at all to use
# the form, comment out this value entirely.
@Referers       = ('theology.edu','www.theology.edu','209.221.219.105');

## DON'T GO ANY FURTHER UNLESS YOU KNOW WHAT YOU ARE DOING! ##
##     NOTHING BELOW THIS LINE NEEDS TO BE CHANGED!!        ##


$error_loop     = 0;
$browser_out    = 0;

if ($ENV{'REQUEST_METHOD'} eq 'GET' and not $ENV{'QUERY_STRING'})
    {
    $ENV{'OUT_TITLE'} = "AlienForm2 Release Edition (v2.02)";
    $ENV{'OUT_MSG'}   = qq|The latest version of this script and the documentation is available
                           from <a href="http://www.cgi.tj">Jon's CGI-Scape.|;
    @msg = (<DATA>);
    @msg = ParseText(@msg);
    BrowserOut(@msg);
    exit(0);
    }
&CheckRef;
&ParseForm;

if (@missing_values or @bad_emails or @only_digits or @only_words) { Error('evil values') }


foreach $key (keys %FORM)
    {
    if ($key =~ /^_send_email/)
        {
        @lines = ReadFile('Email Template',$FORM{$key});
        @lines = ParseText(@lines);
        SendMail(@lines);
        }
    elsif ($key =~ /^_out_file/)
        {
        @lines = ReadFile('Log File',$FORM{$key});
        @lines = ParseText(@lines);
        LogFile('LogFile Template',@lines);
        }
    elsif ($key =~ /^_browser_out/ and $browser_out < 2)
        {
        $browser_out++;
        @lines = ReadFile('Browser Template',$FORM{$key});
        @lines = ParseText(@lines);
        BrowserOut(@lines);
        }
    elsif ($key =~ /^_redirect/ and $browser_out < 2)
        {
        $browser_out++;
        print "Location: $FORM{$key}\n\n";
        }
    }

unless ($browser_out)
    {
    @msg = (<DATA>);
    $ENV{'OUT_TITLE'} = "Submission Successful";
    $ENV{'OUT_MSG'}   = "Your submission was successful. Thank you.";
    @msg              = ParseText(@msg);
    BrowserOut(@msg);
    }

exit(0);

sub BrowserOut
    { print "$content_type@_\n" }

sub CheckRef
    {
    my ($valid_referer, @terms);
    if ((@Referers) and ($ENV{'HTTP_REFERER'}))
        {
        foreach $referer (@Referers)
            {
            if ($ENV{'HTTP_REFERER'} =~ m|http.*?://$referer|i)
                {
                $valid_referer++;
                last;
                }
            }
         }
    else {$valid_referer++;}
    unless ($valid_referer)
        {
        @terms = split(/\//,$ENV{'HTTP_REFERER'});
        Error
            (
            'Bad Referer',
            "'$ENV{'HTTP_REFERER'}' is not authorised to use this script. If you want them to be able to,
            you should add '$terms[2]' to the referer list."
            );
        }
    }

sub Error
    {
    ++$error_loop;
    my $title = shift @_;
    my $msg   = shift @_;
    my @error;

    if ($title eq 'evil values')
        {
        my $val;
        if (@missing_values)
            {
            $msg = qq|<p>The following field(s) are required to be filled in before successful submission:</p>\n<ol type="i">\n|;
            foreach $val (@missing_values) { $msg .= "<li>$val\n" }
            $msg .= "</ol>\n";
            }
        if (@bad_emails)
            {
            $msg .= qq|<p>The following field(s) are required to be filled in with valid email addresses before successful submission:</p>\n<ol type="i">\n|;
            foreach $val (@bad_emails) { $msg .= "<li>$val\n" }
            $msg .= "</ol>\n";
            }
        if (@only_digits)
            {
            $msg .= qq|<p>The following field(s) are required to be filled in only with digits (0-9) before successful submission:</p>\n<ol type="i">\n|;
            foreach $val (@only_digits) { $msg .= "<li>$val\n" }
            $msg .= "</ol>\n";
            }
        if (@only_words)
            {
            $msg .= qq|<p>The following field(s) are required to be filled in only with word characters (A-Z, 0-9) before successful submission:</p>\n<ol type="i">\n|;
            foreach $val (@only_words) { $msg .= "<li>$val\n" }
            $msg .= "</ol>\n";
            }
       $title = 'Error- Incorrect Values';
       $msg .= qq|<p>Please go back and fill in the fields accordingly.</p>\n|;
       }
    if    ($FORM{'_error_url'})  { print "Location: $FORM{'_error_url'}\n\n" }
    elsif ($FORM{'_error_path'} and $error_loop < 2)
        {
        $ENV{'OUT_TITLE'} = $title;
        $ENV{'OUT_MSG'}   = $msg;
        @error = ReadFile('Error Template',$FORM{'_error_path'});
        @error = ParseText(@error);
        BrowserOut(@error);
        }
    else
        {
        @error = (<DATA>);
        $ENV{'OUT_TITLE'} = $title;
        $ENV{'OUT_MSG'}   = $msg;
        @error = ParseText(@error);
        BrowserOut(@error);
        }
    exit(0);
    }

sub LogFile
    {
    my $msg  =  shift @_;
    my $file =  shift @_;
    $file    =~ s#\.\./##g;
    $file    =  $base_path . $file;
    open(FILE,">>$file") or Error('File Access Error',"An error occurred when trying to append to the $msg ($file): $!");
    flock(FILE,2)        or Error('File Lock Error',"An error occured when locking the $msg ($file): $!.");
    print FILE @_;
    close(FILE)          or Error('File Close Error',"An error occurred when close the $msg ($file): $!.");
    }

sub ReadFile
    {
    my $msg  =  shift @_;
    my $file =  shift @_;
    $file    =~ s#\.\./##g;
    $file    = $base_path . $file;
    open(FILE, "$file") or Error('File Access Error',"An error occurred when opening the $msg ($file): $!.");
    my @lines = (<FILE>);
    close(FILE)         or Error('File Close Error',"An error occurred when close the $msg ($file): $!.");
    return @lines;
    }

sub ParseForm
    {
    my ($key, $prefs, $buffer);
    if ($ENV{'REQUEST_METHOD'} eq 'GET')
        { @pairs = split(/&/, $ENV{'QUERY_STRING'}) }
    elsif ($ENV{'REQUEST_METHOD'} eq 'POST')
        {
        read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
        @pairs = split(/&/, $buffer)
        }
    else {Error('Bad or Unknown Request Method',
                "The form's request method must be either 'POST' or 'GET'. Please check your HTML.")}

    foreach $pair (@pairs)
        {
        local($name, $value) = split(/=/, $pair);
        $name =~ tr/+/ /;
        $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        $value =~ tr/+/ /;
        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        $value =~ s/<!--(.)*?-->//mg;
        $FORM{$name} = $value;
        if ($name =~ /_/ and $name !~ /^_/)
            {
            ($prefs, $key) = split /_/, $name, 2;
            if ($prefs =~ /r/i and not $value)                { push @missing_values, $key }
            if ($prefs =~ /e/i and $value and
                (($value =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/) or
                  ($value !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)))
                                                              { push @bad_emails, $key      }
            if ($prefs =~ /d/i and $value and $value =~ /\D/) { push @only_digits, $key     }
            if ($prefs =~ /w/i and $value and $value =~ /\W/) { push @only_words, $key      }
            if ($prefs =~ /s/i and $value)                    { $value =~ s/^(\s)*//;
                                                                $value =~ s/(\s)*$//;
                                                                $FORM{$name} = $value;       }
            }


        }
    }

sub ParseText
    {
    my ($line, $key, $value, $sub);
    foreach $line (@_)
        {
        while (($key => $value) = each %FORM)
            { $line =~ s/\[$key\]/$value/ig }
        while (($key => $value) = each %ENV)
            { $line =~ s/\[\%$key\]/$value/ig }
        $line =~ s/\[[^<](.)*?[^>]\]//g;
        }
    foreach $line (@_)
        {
        while ($line =~ /\[<((.)*?)>\]/)
            {
            $sub = $1;
            $sub =~ s/[^\d\+\*\/\-%\.x<>\(\)]//g;
            $sub = eval $sub;
            $line =~ s/\[<(.)*?>\]/$sub/
            }
        }
    return @_;
    }

sub SendMail
    {
    open(MAIL,"|$mail_cmd") or Error('Mailer Open Error',"An error occurred when trying to open the mailer ($mail_cmd): $!.");
    print MAIL @_;
    close(MAIL) or Error('Mail Send Error',"An error occurred when sending the email: $?. Please check the email's headers.");
    }

__END__
<html>
<head>
<title>[%OUT_TITLE]</title>
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#800080" alink="#FF0000">
<div align="center"><center>

<table border="2" cellpadding="0" cellspacing="0" bgcolor="#FFD26B" bordercolor="#699A69"
width="500">
  <tr>
    <td><h2 align="center">[%OUT_TITLE]</h2>
    <p align="center">[%OUT_MSG]</p></td>
  </tr>
</table>
<p><br><p>
<table border="2" cellpadding="0" cellspacing="0" bgcolor="#FFD26B" bordercolor="#699A69"
width="500">
  <tr>
    <td><h2 align="center"><a href="http://www.cgi.tj/">AlienForm<sup>2</sup></a></h2>
    <p align="center">Copyright 1997 - 1998 <a href="mailto:jon@cgi.tj">Jon Hedley</a>.<br>
    All Rights Reserved.</td>
  </tr>
</table>
</center></div>
</body>
</html>
