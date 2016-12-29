// Manage QHCC people videos    
var VideoInfoSermon = new Array ({Name: "", 
                                  Link: "", 
                                  Description: ""}, 
                                 {Name: "1 Corinthians 7:1-24", 
                                  Link: "/QHCC/sermons/RecentSermons.xspf", 
				  Description: "Sunday Morning, July 9, 2006<br/>Don Patterson", 
                                  AudioPlayer: "/Master/xspf_player.swf"});

var VideoInfoOther = new Array ({Name: "", 
                                 Link: "", 
                                 Description: ""}, 
                                {Name: "Islam Theology and History, Seminar 1", 
                                 Link: "http://video.google.com/googleplayer.swf?docId=1344514861472859754&hl=en", 
                                 Description: "Sunday Evening September 9, 2006<br/>Robin Nettelhorst"}, 
                                {Name: "Islam Theology and History, Seminar 2", 
                                 Link: "http://video.google.com/googleplayer.swf?docId=-3150750844460694843&hl=en", 
                                 Description: "Sunday Evening September 16, 2006<br/>Robin Nettelhorst"});

function PickNewVideoSermon(iAutoPlay)
{
  DebugLn("PickNewVideoSermon");
  // Blank other list
  var list = GetObject("OtherSelect");
  if (list)
    list.selectedIndex = 0;
  list = GetObject("SermonSelect");
  videoIndex = list.selectedIndex
  DebugLn("videoIndex = " + videoIndex);
  PickNewVideo(VideoInfoSermon[videoIndex], iAutoPlay, 0);
}

function PickNewVideoOther(iAutoPlay)
{
  DebugLn("PickNewVideoOther");
  // Blank other list
  var list = GetObject("SermonSelect");
  if (list)
    list.selectedIndex = 0;

  list = GetObject("OtherSelect");
  videoIndex = list.selectedIndex
  DebugLn("videoIndex = " + videoIndex);
  PickNewVideo(VideoInfoOther[videoIndex], iAutoPlay, 0);
}

function InitializePage()
{
  //DebugInitialize("QHCC Sermon Videos", "VideoDebug.html");
  DebugLn("InitializePage");

  // -------------------
  // Set up like select list.
  // -------------------
  var list = GetObject("SermonSelect");
  if (list)
  {
    for (iiSermon = 0; iiSermon < VideoInfoSermon.length; iiSermon++)
      list.options[iiSermon] = new Option(VideoInfoSermon[iiSermon].Name);

    // Pick first video.
    // (Skip zeroth blank record)
    list.selectedIndex = 1;
  }
    
  PickNewVideoSermon(0);
    
  // -------------------
  // Set up other select list.
  // -------------------
  var list = GetObject("OtherSelect");
  if (list)
  {
    for (iiOther = 0; iiOther < VideoInfoOther.length; iiOther++)
      list.options[iiOther] = new Option(VideoInfoOther[iiOther].Name);
  }
}
