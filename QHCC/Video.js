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
  if (isUndefined(iAutoPlay))
    iAutoPlay = 1 ;
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
