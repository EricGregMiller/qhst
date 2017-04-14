// Baptist Press feed

// Function to allow one JavaScript file to be included by another.
// Copyright (C) 2006-08 www.cryer.co.uk
function IncludeJavaScript(jsFile)
{
  document.write('<script type="text/javascript" src="' + jsFile + '"></script>'); 
}

// ***********************************************
// This code is subject to the copyright and terms
// of usage restrictions detailed at 
// http://www.bpnews.net/termsofuse.asp
// Copyright 2001 Baptist Press. 
// Southern Baptist Convention. All rights reserved.
// *************************************************
function BaptistPressTable()
{
  document.writeln('<table border=0 cellpadding=0 cellspacing=0>');
  document.writeln('<tr class="SectionHead"><td align=left valign=top></td><td><img src=http://bpnews.net/clear.gif></td><td align=right valign=top></td></tr>');
  document.writeln('<tr class="SectionHeadLeft"><td><img src=http://bpsports.net/clear.gif width=4><a href=http://bpnews.net target=bp><img src=http://bpnews.net/headlines/bplogo.gif border=0 align=absmiddle></a>');
  document.writeln('<span class="Small Bold">Baptist Press</span></td><td><img src=http://bpsports.net/clear.gif></td>');
  document.writeln('<td align=right><span class="xSmall Bold">'+todays_date+' </span></td></tr>');
  document.writeln('<tr height=3 class="SectionHead"><td colspan=3><img src=http://bpnews.net/clear.gif></td></tr>');
  document.writeln('<tr height=2 class="SectionHead"><td colspan=3><img src=http://bpnews.net/clear.gif></td></tr>');
  document.writeln('<tr class="Backlight"><td colspan=3><span class="xSmall">')
  if (total_news > 0) { for (var row=0; row<total_news; row++) { document.writeln('<li type=square><a href='+BPNews[row][0]+' target=bp>'+BPNews[row][1]+'</a> ');};
  } else { document.writeln('Sorry. Baptist Press Newsfeed<br/>is temporarily unavailable.'); }
  document.writeln('</span></td></tr><tr height=5 class="Backlight"><td colspan=3><img src=http://bpnews.net/clear.gif height=5></td></tr></table>');
}

function BaptistPressDiv()
{
  document.writeln('<div id="BpHead"><a href=http://bpnews.net target=bp><img src="http://bpnews.net/headlines/bplogo.gif" id="BpHeadLogo"/></a>');
  document.writeln('<div id="BpHeadTitle">Baptist Press</div>');
  document.writeln('<div id="BpHeadDate">'+todays_date+' </div></div>');
  document.writeln('<div id="BpFeed">')
  if (total_news > 0) { for (var row=0; row<total_news; row++) { document.writeln('<li type=square><a href='+BPNews[row][0]+' target=bp>'+BPNews[row][1]+'</a> ');};
  } else { document.writeln('Sorry. Baptist Press Newsfeed<br/>is temporarily unavailable.'); }
  document.writeln('</div>');
}

//var total_news = 0;		// initialize variable
//var todays_date = '';	// initialize variable
//
//IncludeJavaScript('http://bpnews.net/headlines/bpheadlines.js');
BaptistPressDiv();
