// Gmap Pedometer routes
// JMT: HappyIsles to Panorama Jct: http://www.gmap-pedometer.com/?r=1093022
// Mist Trail: HappyIsles to JMT: http://www.gmap-pedometer.com/?r=1093050
// GlacierPoint to JMT: http://www.gmap-pedometer.com/?r=1092983
// Panorama Jct to Half Dome: http://www.gmap-pedometer.com/?r=1093087
// Road to Sentinel Dome: http://www.gmap-pedometer.com/?r=1109462
// Road to Taft Point: http://www.gmap-pedometer.com/?r=1109476
// Glacier Point to Sentinel Dome: http://www.gmap-pedometer.com/?r=1109384
// Points of interest: http://www.gmap-pedometer.com/?r=1105393
// Old gmap routes.
// HappyIsles to Half Dome: http://www.gmap-pedometer.com/?r=626858
// GlacierPoint to JMT: http://www.gmap-pedometer.com/?r=626843
// Road to Sentinel Dome: http://www.gmap-pedometer.com/?r=626461
// Road to Taft Point: http://www.gmap-pedometer.com/?r=626637

var gMap;
var gHappyIslesRouteData;
var gGlacierPointRouteData;
var gSentinelDomeRouteData;
var gTaftPointRouteData;
var gMarker;

// ***********************
// Object methods
// ***********************
// Get the image (<img>) object given the parent of the image.
function GetObjectImage(iImageParent)
{
  var objectImage;
  var objectKids = iImageParent.childNodes;
  for (iiOk=0; iiOk<objectKids.length; iiOk++)
  {
    if (1 == objectKids[iiOk].nodeType && 
        "img" == objectKids[iiOk].tagName.toLowerCase())
    { // Found image tag
      objectImage = objectKids[iiOk];
      break;
    } // End if found image.
  } // End loop on objectKids
  return (objectImage);
}

// Change the image source given the parent of the image object.
function ChangeObjectImage(iImageParent, iNewImage) 
{
  if (document.images)
    GetObjectImage(iImageParent).src = iNewImage;
}

// ***********************
// Map methods
// ***********************

// Set trail based on selection
function GetTrailType()
{
  var trailType = "";
  var happyIslesCheck =  GetObject('HappyIslesRadio');
  var glacierPointCheck =  GetObject('GlacierPointRadio');
  var sentinelDomeCheck =  GetObject('SentinelDomeRadio');
  var taftPointCheck =  GetObject('TaftPointRadio');
  if (happyIslesCheck && happyIslesCheck.checked)
  {
    trailType = "HappyIsles";
  }
  else if (glacierPointCheck && glacierPointCheck.checked)
  {
    trailType = "GlacierPoint";
  }
  else if (sentinelDomeCheck && sentinelDomeCheck.checked)
  {
    trailType = "SentinelDome";
  }
  else if (taftPointCheck && taftPointCheck.checked)
  {
    trailType = "TaftPoint";
  }
  return trailType;
}

function TrailDist()
{
  this.Out = -1.0;
  this.Back = 0.0;
}

// Compute trail distances based on input distance and type.
function ComputeTrailDistance(iDistance, iDistanceType) 
{
  DebugLn('ComputeTrailDistance: iDistance = ' + iDistance + ', iDistanceType = ' + iDistanceType + '<br>');
  var oDist = new TrailDist();
  
  switch (GetTrailType())
  {
  case "MistTrail":
    if (iDistanceType == "MistTrail")
    {
      oDist.Out = iDistance;
      if (iDistance < 3.4)
        oDist.Back = 6.8 - iDistance;
    }
    break;
  case "HappyIsles":
    if (iDistanceType == "HappyIsles")
    {
      oDist.Out = iDistance;
      if (iDistance < 8.2)
        oDist.Back = 16.4 - iDistance;
    }
    break;
  case "GlacierPoint":
    if (iDistanceType == "GlacierPoint")
    {
      oDist.Out = iDistance;
    }
    if (iDistanceType == "HappyIsles")
    {
      if (iDistance >= 3.4)
      {
        oDist.Out = iDistance + 5.3 - 3.4;
        if (iDistance < 8.2)
          oDist.Back = 18.3 - iDistance;
      }
      else
      {
        oDist.Out = 18.3 - iDistance;
      }
    }
    break;
  case "SentinelDome":
    if (iDistanceType == "SentinelDome")
    {
      oDist.Out = iDistance;
      if (iDistance < 1.2)
        oDist.Back = 2.4 - iDistance;
    }
    break;
  case "SentinelDomeGP":
    if (iDistanceType == "SentinelDome")
    {
      oDist.Out = iDistance;
      if (iDistance < 1.2)
        oDist.Back = 2.4 - iDistance;
    }
    break;
  case "TaftPoint":
    if (iDistanceType == "TaftPoint" || 
        (iDistanceType == "SentinelDome" && 
         iDistance <= 0.04))
    {
      oDist.Out = iDistance;
      if (iDistance < 1.3)
        oDist.Back = 2.6 - iDistance;
    }
    break;
  }
  oDist.Out = oDist.Out.toFixed(1);
  oDist.Back = oDist.Back.toFixed(1);
  DebugLn('oDist.Out = ' + oDist.Out + ', oDist.Back = ' + oDist.Back + '<br>');
  return oDist;
}

// Show marker at a given position
/* iInfo: { Lat: latitude, 
            Lon: longitude, 
            LocationName: name of location, 
            Distance: distance from start of trail, 
            DistanceType: name of trail from which distance is measured, 
            ElevationFeet: elevation in feet, 
            Note: any notes about location }); */
function ShowInformation(iInfo) 
{
  DebugLn('iInfo.Distance = ' + iInfo.Distance + ', iInfo.DistanceType = ' + iInfo.DistanceType + '<br>');
  var htmlText = "";
  DebugLn('iInfo.LocationName = ' + iInfo.LocationName + ', iInfo.ElevationFeet = ' + iInfo.ElevationFeet + '<br>');
  if (isString(iInfo.LocationName) && 
      iInfo.LocationName.length > 0)
  {
    htmlText += "<h3>" + iInfo.LocationName + "</h3>";
    htmlText += "<ul>";
    var trailDistance = ComputeTrailDistance(iInfo.Distance, iInfo.DistanceType);
    DebugLn('trailDistance.Out = ' + trailDistance.Out + ', trailDistance.Back = ' + trailDistance.Back + '<br>');
    if (trailDistance.Out >= 0)
    {
      htmlText += "<li>Distance: " + trailDistance.Out + "mi</li>";
      if (trailDistance.Back > 0.0)
      {
        htmlText += "<li>Distance on return: " + trailDistance.Back + "mi</li>";
      }
    }
    if (iInfo.HISignDist && iInfo.HISignDist > 0)
    {
      htmlText += "<li>Happy Isles Sign Dist: " + iInfo.HISignDist + "mi</li>";
    }
    if (iInfo.GPSignDist && iInfo.GPSignDist > 0)
    {
      htmlText += "<li>Glacier Point Sign Dist: " + iInfo.GPSignDist + "mi</li>";
    }
    if (iInfo.ElevationFeet && iInfo.ElevationFeet> 0)
    {
      var elevationMeters = (iInfo.ElevationFeet * 0.3048).toFixed(0);
      htmlText += "<li>Elevation: " + iInfo.ElevationFeet + "ft/" + elevationMeters + "m</li>";
    }
    if (iInfo.Note && iInfo.Note.length > 0)
      htmlText += "<li>Note: " + iInfo.Note + "</li>";
    htmlText += "<li>Latitude: " + iInfo.Lat.toFixed(4) + "</li>\n";
    htmlText += "<li>Longitude: " + iInfo.Lon.toFixed(4) + "</li>\n";
    htmlText += "</ul>";
  }
  else
  {
    htmlText += "<h2>No Information</h2>";
  }
  DebugLn('htmlText = ' + htmlText + '<br>');
  ShowInfoWindow(iInfo.Lat, iInfo.Lon, htmlText);
}

// Hide information
function HideInformation() 
{
  var marker = new GetObject("Information");
  marker.className = "InformationOff";
  marker.innerHTML = "";
}

// Show marker at a given position
function ShowMarker(iLat, iLon) 
{
  if (gMap)
  {
    if (gMarker)
      HideMarker();
    var point = new GLatLng(iLat, iLon);
    gMarker = new GMarker(point)
    gMap.addOverlay(gMarker);
  }
}

// Show info window at a given position
function ShowInfoWindow(iLat, iLon, iText) 
{
  if (gMap)
  {
    var htmlText = "";
    htmlText += "<span style='color: black;'>";
    htmlText += iText;
    htmlText += "</span>";

    ShowMarker(iLat, iLon);
    if (gMarker)
    {
      gMarker.openInfoWindowHtml(htmlText);
    }
    else
    {
      var point = new GLatLng(iLat, iLon);
      gMap.openInfoWindowHtml(point, htmlText);
    }
  }
}

// Hide marker
function HideMarker() 
{
  if (gMap)
  {
    gMap.closeInfoWindow();
    if (gMarker)
    {
      gMap.removeOverlay(gMarker);
    }
  }
}

// React to mouse click on button
function MouseClickButton(iButton) 
{
  DebugLn('id = ' + iButton.id + '<br>');
  MouseOverButton(iButton);
  return false;
}

// React to mouse over
function MouseOverButton(iButton) 
{
  DebugLn('id = ' + iButton.id + '<br>');
  switch (iButton.id)
  {
  // Gmap half dome topo is messed up at zooms >= 14
  // Happy Isles points of interest on OK zoom (13): http://www.gmap-pedometer.com/?r=623447
  // Happy Isles points of interest on messed up zoom (14): http://www.gmap-pedometer.com/?r=623456
  case "HappyIsles":
    // (TopoZone 37.730, -119.55806, unknown) 
    // (Happy Isles Bridge TopoZone 37.73278, -119.5575)
    // El: 1230.78544
    ShowInformation({ Lat: 37.73064, 
                      Lon: -119.55901, 
                      LocationName: iButton.innerHTML, 
                      Distance: 0.0, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 4038 });
    break;
  case "VernalFallsBridge":
    // Vernal Falls Bridge		17.30	1,357	4,454
    // El: 1357.45423
    ShowInformation({ Lat: 37.72534, 
                      Lon: -119.55137, 
                      LocationName: iButton.innerHTML, 
                      Distance: 0.8, 
                      DistanceType: 'HappyIsles', 
                      HISignDist: 0.8, 
                      ElevationFeet: 4454, 
                      Note: 'last potable water, first toilet'});
    break;
  case "VernalFallsTop":
    // El: 1531.65962
    // Emerald Pool junction 37.7278, -119.54236, 1542.79396
    ShowInformation({ Lat: 37.72741, 
                      Lon: -119.5436, 
                      LocationName: iButton.innerHTML, 
                      Distance: 1.5, 
                      DistanceType: 'MistTrail', 
                      ElevationFeet: 5040, 
                      Note: 'toilet' });
    break;
  case "JMTJunction1":
    // El: 1406.29538
    ShowInformation({ Lat: 37.72575, 
                      Lon: -119.54923, 
                      LocationName: iButton.innerHTML, 
                      Distance: 1.2, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 4614 });
    break;
  case "JMTJunction2":
    // El: 1680
    ShowInformation({ Lat: 37.72497, 
                      Lon: -119.54485, 
                      LocationName: iButton.innerHTML, 
                      Distance: 1.8, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 5510 });
    break;
  case "PanoramaEndAtJmt":
    // El: 1829.72964
    ShowInformation({ Lat: 37.72251, 
                      Lon: -119.53485, 
                      LocationName: iButton.innerHTML, 
                      Distance: 3.4, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 6003, 
                      Note: 'toilet' });
    break;
  case "NevadaFalls":
    // El: 1806.80868
    ShowInformation({ Lat: 37.72487, 
                      Lon: -119.5329, 
                      LocationName: iButton.innerHTML, 
                      Distance: 3.4, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 5928 });
    break;
  case "MistTrailTop":
    // El: 1821.99991
    ShowInformation({ Lat: 37.73052, 
                      Lon: -119.52309, 
                      LocationName: iButton.innerHTML, 
                      Distance: 3.7,  
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 5978, 
                      Note: 'second toilet' });
    break;
  case "LittleYosemiteTriangle":
    // El: 1864.64143
    ShowInformation({ Lat: 37.73052, 
                      Lon: -119.52309, 
                      LocationName: iButton.innerHTML, 
                      Distance: 4.3, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 6118, 
                      Note: 'last toilet' });
    break;
  case "LittleYosemiteRangerStation":
    // El: 1866.17152
    ShowInformation({ Lat: 37.73242, 
                      Lon: -119.51981, 
                      LocationName: iButton.innerHTML, 
                      Distance: 4.4, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 6123 });
    break;
  case "LittleYosemiteLastWater":
    // El: 1866.38488
    ShowInformation({ Lat: 37.73378, 
                      Lon: -119.51715, 
                      LocationName: iButton.innerHTML, 
                      Distance: 4.5, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 6123 });
    break;
  case "LittleYosemiteCampground":
    // El: 1865.08948
    ShowInformation({ Lat: 37.73323, 
                      Lon: -119.51463, 
                      LocationName: iButton.innerHTML, 
                      Distance: 4.5, 
                      DistanceType: 'HappyIslesBackpacker', 
                      ElevationFeet: 6119, 
                      Note: 'campground designated for backpackers' });
    break;
  case "LittleYosemiteValley":
    // El: 1874.30054
    // (TopoZone 37.73306, -119.51028, unknown)
    ShowInformation({ Lat: 37.73474, 
                      Lon: -119.51464, 
                      LocationName: iButton.innerHTML, 
                      Distance: 4.9, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 6149 });
    break;
  case "TwoPointFiveToGoSign":
    // El: 2031.16281
    ShowInformation({ Lat: 37.74146, 
                      Lon: -119.51155, 
                      LocationName: iButton.innerHTML, 
                      Distance: 5.7, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 6664 });
    break;
  case "JMTJunction":
    // Half Dome Jct	8.10	12.10	2,140	7,020
    // El: 2139.75391
    ShowInformation({ Lat: 37.74513, 
                      Lon: -119.51183, 
                      LocationName: iButton.innerHTML, 
                      Distance: 6.2, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 7020 });
    break;
  case "LastWater":
    // El: 2229.18528
    ShowInformation({ Lat: 37.74886, 
                      Lon: -119.51552, 
                      LocationName: iButton.innerHTML, 
                      Distance: 6.8, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 7401, 
                      Note: 'last water' });
    break;
  case "FirstViewHalfDome":
    // El: 2299.68247
    ShowInformation({ Lat: 37.75176, 
                      Lon: -119.5188, 
                      LocationName: iButton.innerHTML, 
                      Distance: 7.0, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 7545 });
    break;
  case "SwitchbacksStart":
    // El: 2412.58039
    ShowInformation({ Lat: 37.74879, 
                      Lon: -119.52706, 
                      LocationName: iButton.innerHTML, 
                      Distance: 7.5, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 7915 });
    break;
  case "CablesStart":
    // El: 2561.57577
    ShowInformation({ Lat: 37.74669, 
                      Lon: -119.53004, 
                      LocationName: iButton.innerHTML, 
                      Distance: 7.9, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 8404 });
    break;
  case "HalfDome":
    // Gmap: Half Dome 10.10 2,694 8,838 (37.74604, -119.533)
    // El: 2689.66492
    // (TopoZone 37.74611, -119.53194, 8842)
    ShowInformation({ Lat: 37.74601, 
                      Lon: -119.53296, 
                      LocationName: iButton.innerHTML, 
                      Distance: 8.2, 
                      DistanceType: 'HappyIsles', 
                      ElevationFeet: 8842 });
    break;
  case "GlacierPoint":
    // El: 2198.12616
    // (TopoZone: 37.731, -119.573, 7214)
    ShowInformation({ Lat: 37.72714, 
                      Lon: -119.57416, 
                      LocationName: iButton.innerHTML, 
                      Distance: 0.0, 
                      DistanceType: 'GlacierPoint', 
                      ElevationFeet: 7214 });
    break;
  case "PanoramaJct1":
    // El: 1959.34279
    ShowInformation({ Lat: 37.71037, 
                      Lon: -119.5653, 
                      LocationName: iButton.innerHTML, 
                      Distance: 1.4, 
                      DistanceType: 'GlacierPoint', 
                      ElevationFeet: 6428 });
    break;
  case "IllilouetteFootbridge":
    // El: 1797.94509
    ShowInformation({ Lat: 37.71195, 
                      Lon: -119.56068, 
                      LocationName: iButton.innerHTML, 
                      Distance: 2.3, 
                      DistanceType: 'GlacierPoint', 
                      ElevationFeet: 5899, 
                      Note: 'low point of trail when starting at Glacier point' });
    break;
  case "PanoramaCliffs":
    // El: 2031.08356
    ShowInformation({ Lat: 37.71999, 
                      Lon: -119.55028, 
                      LocationName: iButton.innerHTML, 
                      Distance: 3.6, 
                      DistanceType: 'GlacierPoint', 
                      ElevationFeet: 6664 });
    break;
  case "PanoramaJct2":
    // El: 2016.82197
    ShowInformation({ Lat: 37.71981, 
                      Lon: -119.54002, 
                      LocationName: iButton.innerHTML, 
                      Distance: 4.0, 
                      DistanceType: 'GlacierPoint', 
                      ElevationFeet: 6617 });
    break;
  case "SentinelDomeTrailhead":
    // El: 2356.72884
    ShowInformation({ Lat: 37.71258, 
                      Lon: -119.58635, 
                      LocationName: iButton.innerHTML, 
                      Distance: 0.0, 
                      DistanceType: 'SentinelDome', 
                      ElevationFeet: 7720 });
    break;
  case "SentinelDome":
    // El: 2475.41796
    ShowInformation({ Lat: 37.7232, 
                      Lon: -119.58429, 
                      LocationName: iButton.innerHTML, 
                      Distance: 1.2, 
                      DistanceType: 'SentinelDome', 
                      ElevationFeet: 8122 });
    break;
  case "TaftPoint":
    // El: 2252.33484
    // TopoZone: 37.713, -119.605, 7503
    ShowInformation({ Lat: 37.71159, 
                      Lon: -119.60487, 
                      LocationName: iButton.innerHTML, 
                      Distance: 1.3, 
                      DistanceType: 'TaftPoint', 
                      ElevationFeet: 7503 });
    break;
    }
}

// React to mouse leaving button
function MouseOffButton(iButton) 
{
  HideMarker();
  HideInformation();
}

function GetListLinkElemText(iListLinkElem)
{
  var elemText;
  for (iiNode = 0; iiNode < iListLinkElem.childNodes.length && !elemText; iiNode++)
  {
    var node = iListLinkElem.childNodes[iiNode];
    DebugLn('node = ' + node.nodeName);
    if (node.nodeName == "A")
    {
      elemText = node.innerHTML;
      DebugLn('elemText = ' + elemText);
    }
  }
  return elemText;
}

// Set trail based on selection
function SetTrail()
{
  DebugLn("SetTrail");
  // -----------------------------------
  // Put interest points in correct lists.
  // -----------------------------------
  var ipTrail = GetObject("InterestPointsTrail");
  var ipOther = GetObject("InterestPointsOther");

  if (ipTrail && ipOther)
  {
    // Put all items in other in order.
    //var tempDiv = document.createElement("div");
    while (ipTrail.childNodes.length > 0)
    {
      var trailNode = ipTrail.firstChild;
      DebugLn('trailNode = ' + trailNode.nodeName);
      if (trailNode.nodeName == "LI")
      { // Have list node.
        var trailText = GetListLinkElemText(trailNode);
        DebugLn('trailText = ' + trailText);

        var inserted = 0;
        // Remove non-list nodes. 
        for (iiOther = ipOther.childNodes.length - 1; iiOther >= 0; iiOther--)
        {
          var otherNode = ipOther.childNodes[iiOther];
          if (otherNode.nodeName != "LI")
          {
            ipOther.removeChild(otherNode);
          }
        }
        for (iiOther = 0; iiOther < ipOther.childNodes.length && !inserted; iiOther++)
        {
          var otherNode = ipOther.childNodes[iiOther];
          DebugLn('otherNode = ' + otherNode.nodeName);
          if (otherNode.nodeName == "LI")
          {
            var otherText = GetListLinkElemText(otherNode);
            DebugLn('otherText = ' + otherText);
            if (otherText >= trailText)
            {
              ipOther.insertBefore(trailNode, ipOther.childNodes[iiOther]);
              inserted = 1;
            }
          }
        } // End loop on other list.
        // Transfer node to other
        if (!inserted)
          ipOther.appendChild(trailNode);
      } // End if have list node.
      else
      { // Not a list node.
        ipTrail.removeChild(trailNode);
      } // End else not a list node.
      DebugLn('End loop on trail nodes.');
    } // End loop on trail nodes.

    DebugLn('SetMap setup trail display.');
    if (gMap)
    {
      if (gHappyIslesRouteData)  
        gMap.removeOverlay(gHappyIslesRouteData);
      if (gGlacierPointRouteData)    
        gMap.removeOverlay(gGlacierPointRouteData);
      if (gSentinelDomeRouteData)    
        gMap.removeOverlay(gSentinelDomeRouteData);
      if (gTaftPointRouteData)    
        gMap.removeOverlay(gTaftPointRouteData);
    }
    switch (GetTrailType())
    {
    case "HappyIsles":
      if (gMap && gHappyIslesRouteData)  
        gMap.addOverlay(gHappyIslesRouteData);
      ipTrail.appendChild(GetObject("HappyIsles").parentNode);
      ipTrail.appendChild(GetObject("VernalFallsBridge").parentNode);
      ipTrail.appendChild(GetObject("NevadaFalls").parentNode);
      //ipTrail.appendChild(GetObject("LittleYosemiteCampground").parentNode);
      ipTrail.appendChild(GetObject("LittleYosemiteValley").parentNode);
      ipTrail.appendChild(GetObject("JMTJunction").parentNode);
      ipTrail.appendChild(GetObject("LastWater").parentNode);
      ipTrail.appendChild(GetObject("HalfDome").parentNode);
      break;
    case "GlacierPoint":
      if (gMap && gHappyIslesRouteData)  
        gMap.addOverlay(gHappyIslesRouteData);
      if (gMap && gGlacierPointRouteData)  
        gMap.addOverlay(gGlacierPointRouteData);
      ipTrail.appendChild(GetObject("GlacierPoint").parentNode);
      ipTrail.appendChild(GetObject("IllilouetteFootbridge").parentNode);
      ipTrail.appendChild(GetObject("PanoramaCliffs").parentNode);
      ipTrail.appendChild(GetObject("NevadaFalls").parentNode);
      //ipTrail.appendChild(GetObject("LittleYosemiteCampground").parentNode);
      ipTrail.appendChild(GetObject("LittleYosemiteValley").parentNode);
      ipTrail.appendChild(GetObject("JMTJunction").parentNode);
      ipTrail.appendChild(GetObject("LastWater").parentNode);
      ipTrail.appendChild(GetObject("HalfDome").parentNode);
      ipTrail.appendChild(GetObject("VernalFallsBridge").parentNode);
      ipTrail.appendChild(GetObject("HappyIsles").parentNode);
      break;
    case "SentinelDome":
      if (gMap && gSentinelDomeRouteData)  
        gMap.addOverlay(gSentinelDomeRouteData);
      ipTrail.appendChild(GetObject("SentinelDomeTrailhead").parentNode);
      ipTrail.appendChild(GetObject("SentinelDome").parentNode);
      break;
    case "TaftPoint":
      if (gMap && gTaftPointRouteData)  
        gMap.addOverlay(gTaftPointRouteData);
      ipTrail.appendChild(GetObject("SentinelDomeTrailhead").parentNode);
      ipTrail.appendChild(GetObject("TaftPoint").parentNode);
      break;
    }
  }
}

function HandleClick(iOverlay, iPoint) 
{
  DebugLn("HandleClick");
  if (iPoint) 
  {
    var htmlText = '';

    htmlText += "<ul>";
    htmlText += "<li>Latitude: " + iPoint.lat().toFixed(4) + "</li>\n";
    htmlText += "<li>Longitude: " + iPoint.lng().toFixed(4) + "</li>\n";
    htmlText += "</ul>";
    DebugLn('htmlText = ' + htmlText + '<br>');
    
    ShowInfoWindow(iPoint.lat(), iPoint.lng(), htmlText)
  }
}

function LoadGoogleMapData() 
{
  DebugLn("LoadGoogleMapData");
  if (GBrowserIsCompatible()) 
  {
    gMap = InitializeMap("MapGoogle", 37.73609, -119.55425, 13, 'Topo');
    if (gMap)
    {
      GEvent.addListener(gMap, "click", HandleClick);
      //DebugLn("HandleClick set");
      //DebugObjectTable("Map", gMap);
    }
    var routePoints = LoadRoute("HappyIslesHike.xml");
    DebugLn("routePoints.length = " + routePoints.length);
    gHappyIslesRouteData = CreateRoute(routePoints);
    routePoints = LoadRoute("GlacierPointHike.xml");
    gGlacierPointRouteData = CreateRoute(routePoints);
    routePoints = LoadRoute("SentinelDomeHike.xml");
    gSentinelDomeRouteData = CreateRoute(routePoints);
    routePoints = LoadRoute("TaftPointHike.xml");
    gTaftPointRouteData = CreateRoute(routePoints);
  }
}

function InitPage()
{
  // Init debug window
  if (!gDebugWindow)
  {
    //gDebugWindow = window.open("HalfDomeDebug.html");
    if (gDebugWindow)
    {
      Debug("<html>\n");
      Debug("<head>\n");
      Debug("  <title>Debug Window: Half Dome</title>\n");
      Debug("</head>\n");
      Debug("<body>\n");
      Debug("<h1>Debug Window: Half Dome</h1>\n");
      DebugLn("Test body line");
    }
  }
  
  // Setup Google map data
  LoadGoogleMapData();
  
  // Set correct trail info.
  SetTrail();
}

