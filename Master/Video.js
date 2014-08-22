// Manage videos

// Video info: 
//  http://www.permadi.com/tutorial/flashjscommand/ Some good stuff. But does it only apply to shockwave. His commands
//    do not seem to work with YouTube videos.
//  http://blog.deconcept.com/swfobject/#download A fancy flash object. Didn't take time to learn how to use it.

/*Adobe flash template
<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"
WIDTH="550" HEIGHT="400" id="myMovieName"><PARAM NAME=movie VALUE="myFlashMovie.swf"><PARAM NAME=quality VALUE=high><PARAM NAME=bgcolor VALUE=#FFFFFF><EMBED src="/support/flash/ts/documents/myFlashMovie.swf" quality=high bgcolor=#FFFFFF WIDTH="550" HEIGHT="400"
NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash"
PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED></OBJECT>
*/

/* Adobe talks about a difference between flash and shockwave flash. This seems to have a lot of shockwave stuff
        <object
          classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
          codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"
          id="MovieLike" 
          width="425" height="355">
          <param name="movie" value="http://www.youtube.com/v/tVDFsiVOeHc&rel=1"></param>
          <param name="wmode" value="transparent"></param>
          <embed 
            play=false 
            swliveconnect="true" 
            name="MovieLike" 
            src="http://www.youtube.com/v/tVDFsiVOeHc&rel=1" 
            type="application/x-shockwave-flash" 
            pluginspage="http://www.macromedia.com/go/getflashplayer"
            wmode="transparent" 
            width="425" height="355">
          </embed>
        </object>
*/

// Archive Adobe Flash players.
// http://kb.adobe.com/selfservice/viewContent.do?externalId=tn_14266&sliceId=2

function GetFlashMovieObject(iMovieName)
{
  if (window.document[iMovieName]) 
  {
      return window.document[iMovieName];
  }
  if (navigator.appName.indexOf("Microsoft Internet")==-1)
  {
    if (document.embeds && document.embeds[iMovieName])
      return document.embeds[iMovieName]; 
  }
  else // if (navigator.appName.indexOf("Microsoft Internet")!=-1)
  {
    return document.getElementById(iMovieName);
  }
}

function VideoHtml(iVideoLink, iAutoPlay, iWidth, iHeight, iWmode,        videoObject)
{
  DebugLn("VideoHtml");
  DebugLn("iVideoLink = " + iVideoLink);
  if (isUndefined(iWidth))
    iWidth = 425;
  if (isUndefined(iHeight))
    iHeight = 355;
  if (isUndefined(iWmode))
    iWmode = "transparent";
    
  autoPlay = "";
  if (iAutoPlay)
    autoPlay = "&autoplay=1";
  videoObject = '<object width="' + iWidth + '" height="' + iHeight + '">';
  videoObject += '<param name="movie" value="' + iVideoLink + autoPlay + '"></param>';
  videoObject += '<param name="wmode" value="transparent"></param>';
  videoObject += '<embed src="' + iVideoLink + autoPlay + '" ';
  videoObject += 'type="application/x-shockwave-flash" ';
  videoObject += 'wmode="' + iWmode +  '" ';
  videoObject += 'width="' + iWidth + '" height="' + iHeight + '">';
  videoObject += '</embed></object>';
  return videoObject;
}

function VideoNotLoadedHtml(iNotLoadedHtml)
{
  divHtml = "";
  if (isString(iNotLoadedHtml) && 
      iNotLoadedHtml.length > 0)
  {
    divHtml = "<div class=\"VideoNotLoaded\">";
    divHtml += iNotLoadedHtml;
    divHtml += "</div>";
  }
  return divHtml;
}

function JavascriptErrorHtml()
{
  errorHtml = "<h3>There was an error with the Javascript on this page.</h3>";
  errorHtml += "<p>We apologize for the error.";
  errorHtml += "Please contact our <href=\"mailto:administrator@theology.edu\">web administrator</a> so the problem can be corrected.</p>";
  return VideoNotLoadedHtml(errorHtml);
}

function BadFlashErrorHtml()
{
  errorHtml = "<h3>You need to upgrade your Flash player to play our videos.</h3>";
  errorHtml += "<p>";
  errorHtml += "  Our videos are streamed through an Adobe Flash player. ";
  errorHtml += "  We could not load the video because you do not have the Flash player ";
  errorHtml += "  or your Flash player is old or broken. ";
  errorHtml += "  Please upgrade your Adobe Flash player.";
  errorHtml += "</p>";
  errorHtml += "<p>";
  errorHtml += "  <a href=\"/Master/FlashHelp.html\">Click here for help upgrading your Flash player.</a>";
  errorHtml += "</p>";
  return VideoNotLoadedHtml(errorHtml);
}

function LoadingHtml()
{
  errorHtml = "<h3><center>Loading Video</center></h3>";
  return VideoNotLoadedHtml(errorHtml);
}

function DebugInitialize(iTitle, iDebugUrl)
{
  //document.writeln("<h2>DebugInitialize</h2>");
  try
  {
    if (isString(iTitle) && 
        isString(iDebugUrl))
    {
      gDebugWindow = window.open(iDebugUrl);
      if (gDebugWindow)
      {
        Debug("<html>\n");
        Debug("<head>\n");
        Debug("  <title>Debug Window: " + iTitle + "</title>\n");
        Debug("</head>\n");
        Debug("<body>\n");
        Debug("<h1>Debug Window: " + iTitle + "</h1>\n");
        DebugLn("Test body line");
      }
    }
  }
  catch(err)
  {
    DebugError(err);
  }
}

// Picks a new video based on input info.
// iVideoInfo: An object with a Name, Link (to video) and Description.
//   Name: Name of video
//   Link: Url of video
//   Description: Description of video
// iAutoPlay: If true video starts playing immediately.
// iQuote: If true puts quote marks around information.
// iPageObjectIds: IDs of objects on web page that receive video info.
//   VideoDiv: Div to hold video (default VideoDiv)
//   NamePar: Paragraph for name (default VideoName)
//   DescPar: Paragraph for description (default VideoDesc)
//
// YouTube (people) videos are 425 x 355
// Google videos (Robin's seminars) are 400 x 326
//
function PickNewVideo(iVideoInfo, iAutoPlay, iQuote, iPageObjectIds)
{
  DebugLn("PickNewVideo");
  if (isObject(iVideoInfo))
  {
    DebugLn("iVideoInfo.Description = " + iVideoInfo.Description);
    DebugLn("iVideoInfo.Link = " + iVideoInfo.Link);
  
    if (iVideoInfo.Link && 
        iVideoInfo.Link.length > 0)
    {
      pageObjectIds = {VideoDiv: "VideoDiv", 
                       NamePar: "VideoName", 
                       DescPar: "VideoDesc"};
                       
      if (isObject(iPageObjectIds))
      {
        if (StringLength(iPageObjectIds.VideoDiv) > 0)
          pageObjectIds.VideoDiv = iPageObjectIds.VideoDiv;
        if (StringLength(iPageObjectIds.NamePar) > 0)
          pageObjectIds.NamePar = iPageObjectIds.NamePar;
        if (StringLength(iPageObjectIds.DescPar) > 0)
          pageObjectIds.DescPar = iPageObjectIds.DescPar;
      }
      
      // Reset video division
      SetElementHtml(pageObjectIds.VideoDiv,LoadingHtml());

      // Set video link      
      DebugLn("iVideoInfo.AudioPlayer = " + iVideoInfo.AudioPlayer);
      videoLink = iVideoInfo.Link;
      if (StringLength(iVideoInfo.AudioPlayer) > 0)
      {
        videoLink = iVideoInfo.AudioPlayer;
      }
      DebugLn("videoLink = " + videoLink);

      // Put video on page.
      var so = new SWFObject(videoLink, "VideoEmbed", "425", "355", "9", "#6f7a9e");
      if (so)
      {
        DebugLn("Have swf object.");

        if (iVideoInfo.Attribute)
	{
          DebugLn("iVideoInfo.Attribute.length = " + iVideoInfo.Attribute.length);
          for (iiAtt=0; iiAtt<iVideoInfo.Attribute.length; iiAtt++)
          {
            DebugLn('iiAtt = ' + iiAtt + ": " + 
                    iVideoInfo.Attribute[iiAtt].Name + " = " + iVideoInfo.Attribute[iiAtt].Value);
            so.addVariable(iVideoInfo.Attribute[iiAtt].Name, iVideoInfo.Attribute[iiAtt].Value);
          }
	}

        if (iAutoPlay)
          so.addVariable("autoplay", 1);

        if (StringLength(iVideoInfo.AudioPlayer) > 0)
          so.addVariable("playlist_url", iVideoInfo.Link);

        swfHtml = so.getSWFHTML();
        if (swfHtml && 
            swfHtml.length > 0)
	{
          DebugLn("swfHtml = " + swfHtml.replace(/</, "@"));
          SetElementHtml(pageObjectIds.VideoDiv,swfHtml);
          //so.write(pageObjectIds.VideoDiv);
        }
        else
        {
          SetElementHtml(pageObjectIds.VideoDiv,BadFlashErrorHtml());
        }
      }
      else
      {
        SetElementHtml(pageObjectIds.VideoDiv,JavascriptErrorHtml());
      }

      // Put name with video.
      videoName = iVideoInfo.Name;
      DebugLn("videoName = " + videoName);
      SetElementHtml(pageObjectIds.NamePar, videoName);
      
      // Put description with video.
      videoDesc = "";
      if (StringLength(iVideoInfo.Description) > 0)
      {
        videoDesc = iVideoInfo.Description;
        if (iQuote)
          videoDesc = '"' + videoDesc +'"';
        else
          videoDesc = videoDesc;
      }
      else if (StringLength(iVideoInfo.Date) > 0)
      {
        if (StringLength(iVideoInfo.Number) > 0)
          videoDesc += "Message " + iVideoInfo.Number;
        videoDesc += "<br/>" + iVideoInfo.Date;
        if (StringLength(iVideoInfo.Speaker) > 0)
          videoDesc += "<br/>" + iVideoInfo.Speaker;
      }
      DebugLn("videoDesc = " + videoDesc);
      SetElementHtml(pageObjectIds.DescPar, videoDesc);
    }
  }
}
