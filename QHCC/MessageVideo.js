// Manage QHCC people videos    
var VideoInfoMessage;
var VideoInfoSeries;

function DisplaySeriesInfo(iSeriesInfo)
{
  DebugLn("DisplaySeriesInfo");
  if (isObject(iSeriesInfo))
  {
    DebugLn("iSeriesInfo.Name = " + iSeriesInfo.Name);
  
    // Put name with series.
    seriesName = iSeriesInfo.Name;
    DebugLn("seriesName = " + seriesName);
    SetElementHtml("SeriesName", seriesName);
    
    // Put tag line with series.
    tagLine = "";
    if (StringLength(iSeriesInfo.TagLine) > 0)
      tagLine = iSeriesInfo.TagLine;
    DebugLn("iSeriesInfo.TagLine = " + tagLine);
    SetElementHtml("SeriesTagLine", tagLine);
    
    // Put description with series.
    seriesDesc = "";
    if (StringLength(iSeriesInfo.Description) > 0)
      seriesDesc = iSeriesInfo.Description;
    DebugLn("iSeriesInfo.Description = " + seriesDesc);
    SetElementHtml("SeriesDesc", seriesDesc);
  }
}

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
      if (StringLength(iVideoInfo.ExtraInfo) > 0)
        videoDesc += "<br/>" + iVideoInfo.ExtraInfo;
    }
    DebugLn("videoDesc = " + videoDesc);
    SetElementHtml("VideoDesc", videoDesc);
  }
}

function PickNewVideoMessage(iAutoPlay)
{
  DebugLn("PickNewVideoMessage");

  list = GetObject("MessageSelect");
  videoIndex = list.selectedIndex
  DebugLn("videoIndex = " + videoIndex);
  PickNewVideo(VideoInfoMessage[videoIndex], iAutoPlay);
  DisplayVideoInfo(VideoInfoMessage[videoIndex]);
}

function PickNewVideoSeries()
{
  DebugLn("PickNewVideoSeries");
  DebugLn("PickNewVideoSeries 2");

  var seriesFile = "";
  DebugLn("PickNewVideoSeries 3");
  list = GetObject("SeriesSelect");
  DebugLn("PickNewVideoSeries 4");
  if (list)
  {
    seriesFile = list.options[list.selectedIndex].value;
  }
  DebugLn("seriesFile = " + seriesFile);

  // -------------------
  // Load series file.
  // -------------------
  DebugLn("Loading xml doc");
  xmlDoc = LoadXmlFile(seriesFile);
  DebugLn("Back from loading xml doc");
  xmlData = ParseXmlTag(xmlDoc, "MessageSeries")
  
  // Set up message array
  if (isArray(xmlData))
  {
    // Display series data
    DisplaySeriesInfo(xmlData[0].SeriesInfo);
  
    if (isArray(xmlData[0].Message))
    {
      VideoInfoMessage = xmlData[0].Message;
    }
    else
    {
      VideoInfoMessage = new Array();
      VideoInfoMessage.push(xmlData[0].Message);
    }
  }

  // -------------------
  // Set up message select list.
  // -------------------
  var list = GetObject("MessageSelect");
  if (VideoInfoMessage && 
      list)
  {
    list.options.length = 0;
    for (iiMessage = 0; iiMessage < VideoInfoMessage.length; iiMessage++)
      list.options[iiMessage] = new Option(VideoInfoMessage[iiMessage].Name);

    // Pick first video.
    // list.selectedIndex = VideoInfoMessage.length - 1;
  }
    
  PickNewVideoMessage(0);
}

function InitializePage()
{
  //DebugInitialize("QHCC Message Videos", "VideoDebug.html");
  DebugLn("InitializePage");

  // -------------------
  // Set up series select list.
  // -------------------
  DebugLn("Loading xml doc");
  var xmlDoc = LoadXmlFile("MessageSeries.xml");
  DebugLn("Back from loading xml doc");
  var xmlData = ParseXmlTag(xmlDoc, "MessageSeriesList")
  DebugLn("Back from parsing xml doc");
  if (isArray(xmlData))
  {
    DebugLn("xmlData is array");
    if (isArray(xmlData[0].MessageSeries))
    {
      VideoInfoSeries = xmlData[0].MessageSeries;
    }
    else
    {
      VideoInfoSeries = new Array();
      VideoInfoSeries.push(xmlData[0].MessageSeries);
    }
  }
  DebugLn("VideoInfoSeries.length = " + VideoInfoSeries.length);

  var list = GetObject("SeriesSelect");
  if (list)
  {
    list.options.length = 0;
    for (iiSeries = 0; iiSeries < VideoInfoSeries.length; iiSeries++)
      list.options[iiSeries] = new Option(VideoInfoSeries[iiSeries].Name, VideoInfoSeries[iiSeries].Link);
  }

  PickNewVideoSeries();

}
