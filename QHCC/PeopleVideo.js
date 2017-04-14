// Manage QHCC people videos
var VideoInfoLike;
var VideoInfoOther;

function DisplayVideoInfo(iVideoInfo)
{
  DebugLn("DisplayVideoInfo");
  if (isObject(iVideoInfo))
  {
    DebugLn("iVideoInfo.Name = " + iVideoInfo.Name);
  
    // Put name with video.
    videoName = iVideoInfo.Name;
    DebugLn("videoName = " + videoName);
    SetElementHtml("VideoName", videoName);
    
    // Put description with video.
    videoDesc = "";
    if (StringLength(iVideoInfo.Quote) > 0)
    {
      DebugLn("iVideoInfo.Quote = " + iVideoInfo.Quote);
      videoDesc = '"' + iVideoInfo.Quote +'"';
    }
    else if (StringLength(iVideoInfo.Description) > 0)
    {
      DebugLn("iVideoInfo.Description = " + iVideoInfo.Description);
      videoDesc = iVideoInfo.Description;
    }
    
    if (StringLength(iVideoInfo.Date) > 0)
    {
      DebugLn("iVideoInfo.Number = " + iVideoInfo.Number);
      DebugLn("iVideoInfo.Date = " + iVideoInfo.Date);
      DebugLn("iVideoInfo.Speaker = " + iVideoInfo.Speaker);
      if (StringLength(iVideoInfo.Number) > 0)
        videoDesc += "Message " + iVideoInfo.Number;
      videoDesc += "<br/>" + iVideoInfo.Date;
      if (StringLength(iVideoInfo.Speaker) > 0)
        videoDesc += "<br/>" + iVideoInfo.Speaker;
    }
    DebugLn("videoDesc = " + videoDesc);
    SetElementHtml("VideoDesc", videoDesc);
  }
}

function PickNewVideoLike(iAutoPlay)
{
  DebugLn("PickNewVideoLike");
  // Blank other list
  var list = GetObject("OtherSelect");
  if (list)
    list.selectedIndex = 0;
  list = GetObject("LikeSelect");
  videoIndex = list.selectedIndex - 1;
  DebugLn("videoIndex = " + videoIndex);
  PickNewVideo(VideoInfoLike[videoIndex], iAutoPlay);
  DisplayVideoInfo(VideoInfoLike[videoIndex]);
}

function PickNewVideoOther(iAutoPlay)
{
  DebugLn("PickNewVideoOther");
  // Blank other list
  var list = GetObject("LikeSelect");
  if (list)
    list.selectedIndex = 0;

  list = GetObject("OtherSelect");
  videoIndex = list.selectedIndex - 1;
  DebugLn("videoIndex = " + videoIndex);
  PickNewVideo(VideoInfoOther[videoIndex], iAutoPlay);
  DisplayVideoInfo(VideoInfoOther[videoIndex]);
}

function InitializePage()
{
  //DebugInitialize("QHCC People Video", "VideoDebug.html");
  DebugLn("InitializePage");

  // -------------------
  // Load like select list.
  // -------------------
  DebugLn("Loading xml doc");
  xmlDoc = LoadXmlFile("PeopleLikeQhccVideos.xml");
  DebugLn("Back from loading xml doc");
  xmlData = ParseXmlTag(xmlDoc, "VideoList")
  if (isArray(xmlData))
  {
    if (isArray(xmlData[0].Video))
    {
      VideoInfoLike = xmlData[0].Video;
    }
    else
    {
      VideoInfoLike = new Array();
      VideoInfoLike.push(xmlData[0].Video);
    }
  }
  
  // -------------------
  // Set up like select list.
  // -------------------
  var list = GetObject("LikeSelect");
  if (list)
  {
    list.options[0] = new Option("");
    for (iiLike = 0; iiLike < VideoInfoLike.length; iiLike++)
      list.options[iiLike+1] = new Option(VideoInfoLike[iiLike].Name);

    // Pick random first video.
    // (Skip first blank record)
    var selectIndex = Math.floor((list.options.length-1) * Math.random())+1;
    if (selectIndex < 1)
      selectIndex = 1;
    else if (selectIndex >= list.options.length)
      selectIndex = VideoInfoLike.length - 1;
    list.selectedIndex = selectIndex;
  }
    
  PickNewVideoLike(0);
    
  // -------------------
  // Load other select list.
  // -------------------
  DebugLn("Loading xml doc");
  xmlDoc = LoadXmlFile("OtherPeopleVideos.xml");
  DebugLn("Back from loading xml doc");
  xmlData = ParseXmlTag(xmlDoc, "VideoList")
  if (isArray(xmlData))
  {
    if (isArray(xmlData[0].Video))
    {
      VideoInfoOther = xmlData[0].Video;
    }
    else
    {
      VideoInfoOther = new Array();
      VideoInfoOther.push(xmlData[0].Video);
    }
  }
  
  // -------------------
  // Set up other select list.
  // -------------------
  var list = GetObject("OtherSelect");
  if (list)
  {
    list.options[0] = new Option("");
    for (iiOther = 0; iiOther < VideoInfoOther.length; iiOther++)
      list.options[iiOther+1] = new Option(VideoInfoOther[iiOther].Name);
  }
}
