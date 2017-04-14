// Google blog feedcontrol initialization
var blogFeedType = "QHST";

google.load("feeds", "1");

function initQhcc() {
  var feedControl = new google.feeds.FeedControl();
  feedControl.addFeed("http://hadlyville.blogspot.com/feeds/posts/default", "Patterson");
  feedControl.addFeed("http://nettelhorst.blogspot.com/feeds/posts/default", "Nettelhorst");
  feedControl.addFeed("http://rellimcire.blogspot.com/feeds/posts/default", "Miller");
  //feedControl.addFeed("http://blog.myspace.com/blog/rss.cfm?friendID=228860369", "Reynolds");
  feedControl.setNumEntries(4);
  feedControl.setLinkTarget(google.feeds.LINK_TARGET_BLANK);
  feedControl.draw(document.getElementById("feedControl"), 
    {
      drawMode : google.feeds.FeedControl.DRAW_MODE_TABBED
    }
  );
}

function initQhst() {
  var feedControl = new google.feeds.FeedControl();
  feedControl.addFeed("http://nettelhorst.com/?feed=rss2", "Nettelhorst");
  feedControl.addFeed("http://hadlyville.blogspot.com/feeds/posts/default", "Patterson");
  feedControl.addFeed("http://rellimcire.blogspot.com/feeds/posts/default", "Miller");
  feedControl.addFeed("http://zwingliusredivivus.wordpress.com/feed/", "West");
  feedControl.setNumEntries(2);
  feedControl.setLinkTarget(google.feeds.LINK_TARGET_BLANK);
  feedControl.draw(document.getElementById("feedControl"), 
    {
      drawMode : google.feeds.FeedControl.DRAW_MODE_TABBED
    }
  );
}

function initialize() {
  if (blogFeedType == "QHCC")
    initQhcc();
  else
    initQhst();
}

google.setOnLoadCallback(initialize);
