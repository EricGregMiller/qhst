// Manage QHCC people videos    
var VideoInfoMessage;
var VideoInfoSeries;

function PickNewVideoMessage(iAutoPlay)
{
  DebugLn("PickNewVideoMessage");

  list = GetObject("MessageSelect");
  videoIndex = list.selectedIndex
  DebugLn("videoIndex = " + videoIndex);
  PickNewVideo(VideoInfoMessage[videoIndex], iAutoPlay, 0);
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
  // Set up message select list.
  // -------------------
  DebugLn("Loading xml doc");
  xmlDoc = LoadXmlFile(seriesFile);
  DebugLn("Back from loading xml doc");
  xmlData = ParseXmlTag(xmlDoc, "MessageSeries")
  if (isArray(xmlData))
  {
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
