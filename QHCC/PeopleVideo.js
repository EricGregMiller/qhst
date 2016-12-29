// Manage QHCC people videos

var VideoInfoLike = new Array ({Name: "", 
                                Link: "", 
                                Description: ""}, 
                               {Name: "Beth", 
                                Link: "http://www.youtube.com/v/tVDFsiVOeHc&rel=1", 
                                Description: "I grew up here. I've recently gone off to college and come back ... I can feel like I'm coming home." }, 
                               {Name: "Brittany", 
                                Link: "http://www.youtube.com/v/bXu9iQdI_d4&rel=1", 
                                Description: "I get to sing in the choir" }, 
                               {Name: "Bubba", 
                                Link: "http://www.youtube.com/v/EcEIbWhn-gA&rel=1", 
                                Description: "diversified worship ... uninhibited ... eclectic ... can instantly walk through the doors and become a piece of our family" }, 
                               {Name: "Carmen and Zoann", 
                                Link: "http://www.youtube.com/v/bZl3Xs78qj8&rel=1", 
                                Description: "We like everything about the church, it's awesome. ... The pastor's great, I love his teachings." }, 
                               {Name: "Carolina", 
                                Link: "http://www.youtube.com/v/MoQdj7JpB4A&rel=1", 
                                Description: "... really good music ... a very good preacher who is interesting, relevant and truthful to the Bible. ... Our church is very laid back and accepting ..." }, 
                               {Name: "Corey", 
                                Link: "http://www.youtube.com/v/LUYhXUWaHuY&rel=1", 
                                Description: "It's my favorite church ... ever." }, 
                               {Name: "Dana", 
                                Link: "http://www.youtube.com/v/tEFP6IRLbbQ&rel=1", 
                                Description: "Our youth is one of the stronger points of our church. We don't discriminate ... tatted up or pierced up ... this church has never had a problem looking at people and turning them away because of what they have on the outside." }, 
                               {Name: "Dave", 
                                Link: "http://www.youtube.com/v/I8lUcH0oofI&rel=1", 
                                Description: "We can come here and get recharged, rejuvenated for the week." }, 
                               {Name: "Faye and Lucille", 
                                Link: "http://www.youtube.com/v/klf4pYsc16o&rel=1", 
                                Description: "The people are real friendly. ... We just love the church." }, 
                               {Name: "Ivan", 
                                Link: "http://www.youtube.com/v/9ue9JkapTYU&rel=1", 
                                Description: "It's like a large family" }, 
                               {Name: "Jim and Eula", 
                                Link: "http://www.youtube.com/v/naXO8LJ_-3E&rel=1", 
                                Description: "... small and intimate ... like the teaching ..." }, 
                               {Name: "Judy", 
                                Link: "http://www.youtube.com/v/9PlN2nq2QyQ&rel=1", 
                                Description: "I love the family atmosphere. Your children are safe here. We've raised each other's children." }, 
                               {Name: "Kathy", 
                                Link: "http://www.youtube.com/v/t7kpWHqTQjg&rel=1", 
                                Description: "We can be honest and share who we really are and get the support that we need spiritually ..." }, 
                               {Name: "Lupe", 
                                Link: "http://www.youtube.com/v/i6Za7FzYW5w&rel=1", 
                                Description: "Our church is about caring for each other and bringing our things to the Lord ..." }, 
                               {Name: "Marla", 
                                Link: "http://www.youtube.com/v/KF8ZWOWqxOw&rel=1", 
                                Description: "Everyone here is part of your family -- good parts and bad parts of your family sometimes. ... There is never a question or an attitude or a feeling that is not accepted ... or dealt with." }, 
                               {Name: "Marla's Girls", 
                                Link: "http://www.youtube.com/v/PLzJUEsA-b8&rel=1", 
                                Description: "As they grow up they get to take over." }, 
                               {Name: "Rex and Iris", 
                                Link: "http://www.youtube.com/v/gVW7Ntgs078&rel=1", 
                                Description: "The fellowship, the pastor, the pastor's theology, worship service, family ... the perfect combination. ... The relationships here are not only long term but are just where they need to be ..." }, 
                               {Name: "Ruth", 
                                Link: "http://www.youtube.com/v/zv4--q1MG1s&rel=1", 
                                Description: "It's the kind of church where people can belong that don't belong in other churches." }, 
                               {Name: "Sherman", 
                                Link: "http://www.youtube.com/v/wcGiRg8M_Hg&rel=1", 
                                Description: "The truth of the message as it's preached. ... This is the only place where a square peg can fit in a round circle." }, 
                               {Name: "Wes", 
                                Link: "http://www.youtube.com/v/UWK5Gjbp400&rel=1", 
                                Description: "... great environment, great praise and worship band ... pastor speaks to your heart ..." });

var VideoInfoOther = new Array ({Name: "", 
                                 Link: "", 
                                 Description: ""}, 
                                {Name: "Adult Sunday School", 
                                 Link: "http://www.youtube.com/v/irpcdZhmRKY&rel=1", 
                                 Description: "A few excerpts from our adult Sunday School class."}, 
                                {Name: "Fellowship Time", 
                                 Link: "http://www.youtube.com/v/a1xEDgsH_tw&rel=1", 
                                 Description: "During most services we have a short fellowship time. This is what it looks like."}, 
                                {Name: "Music", 
                                 Link: "http://www.youtube.com/v/1EehA1YFXp4", 
                                 Description: "A couple of examples of our praise band music."}, 
                                {Name: "Youth", 
                                 Link: "http://www.youtube.com/v/p5nypA0uwJE&rel=1", 
                                 Description: "A few of our youth hanging out around church."});

function PickNewVideoLike(iAutoPlay)
{
  DebugLn("PickNewVideoLike");
  // Blank other list
  var list = GetObject("OtherSelect");
  if (list)
    list.selectedIndex = 0;
  list = GetObject("LikeSelect");
  videoIndex = list.selectedIndex
  DebugLn("videoIndex = " + videoIndex);
  PickNewVideo(VideoInfoLike[videoIndex], iAutoPlay, 1);
}

function PickNewVideoOther(iAutoPlay)
{
  DebugLn("PickNewVideoOther");
  // Blank other list
  var list = GetObject("LikeSelect");
  if (list)
    list.selectedIndex = 0;

  list = GetObject("OtherSelect");
  videoIndex = list.selectedIndex
  DebugLn("videoIndex = " + videoIndex);
  PickNewVideo(VideoInfoOther[videoIndex], iAutoPlay, 0);
}

function InitializePage()
{
  //DebugInitialize("QHCC People Video", "VideoDebug.html");
  DebugLn("InitializePage");

  // -------------------
  // Set up like select list.
  // -------------------
  var list = GetObject("LikeSelect");
  if (list)
  {
    for (iiLike = 0; iiLike < VideoInfoLike.length; iiLike++)
      list.options[iiLike] = new Option(VideoInfoLike[iiLike].Name);

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
  // Set up other select list.
  // -------------------
  var list = GetObject("OtherSelect");
  if (list)
  {
    for (iiOther = 0; iiOther < VideoInfoOther.length; iiOther++)
      list.options[iiOther] = new Option(VideoInfoOther[iiOther].Name);
  }
}
