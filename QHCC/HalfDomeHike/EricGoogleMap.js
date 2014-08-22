// Eric Google Map script.
// Info at http://www.google.com/apis/maps

var gDebugWindow;
var gTopoType;

// ***********************
// Object methods
// ***********************
function GetObject(iObject)
{
  var object;
  if (iObject)
  {
    if (isString(iObject))
      object = document.getElementById(iObject);
    else
      object = iObject;
  }
  return object;
}

function isAlien(a) {
   return isObject(a) && typeof a.constructor != 'function';
}

function isArray(a) {
    return isObject(a) && a.constructor == Array;
}

function isBoolean(a) {
    return typeof a == 'boolean';
}

function isEmpty(o) {
    var i, v;
    if (isObject(o)) {
        for (i in o) {
            v = o[i];
            if (isUndefined(v) && isFunction(v)) {
                return false;
            }
        }
    }
    return true;
}

function isFunction(a) {
    return typeof a == 'function';
}

function isNull(a) {
    return a === null;
}

function isNumber(a) {
    return typeof a == 'number' && isFinite(a);
}

function isObject(a) {
    return (a && typeof a == 'object') || isFunction(a);
}

function isString(a) {
    return typeof a == 'string';
}

function isUndefined(a) {
    return typeof a == 'undefined';
} 

// ***********************
// Debug methods
// ***********************
function InitializeDebug() 
{
  if (0 && !gDebugWindow)
    gDebugWindow = window.open("MapDebug.html");
  if (gDebugWindow)
  {
    Debug("<html>\n");
    Debug("<head>\n");
    Debug("  <title>Debug Window: Web Flash</title>\n");
    Debug("</head>\n");
    Debug("<body>\n");
    Debug("<h1>Debug Window: Web Flash</h1>\n");
    //DebugLn("Test body line");
  }
}

function Debug(iDebugText)
{
  if (gDebugWindow)
    gDebugWindow.document.write(iDebugText);
}

function DebugLn(iDebugText)
{
  Debug("<p>" + iDebugText + "<p>\n");
}

function DebugObjectTable(name, object)
{
  gDebugWindow.document.writeln("<h2>" + name +"</h2>");
  gDebugWindow.document.writeln("<table border=2> <tr><th>Field<th>Type<th>Value");
  for (field in object)
  {
    //The typeof operator returns type information as a string. There are six possible values that typeof returns: "number", "string", "boolean", "object", "function", and "undefined".
    //The parentheses are optional in the typeof syntax. 
    gDebugWindow.document.writeln("<tr><td>" + field + "</td><td>" + typeof object[field] + "</td><td>" + object[field] + "</td></tr>");
  }
  gDebugWindow.document.writeln("</table>");
}

function DebugError(iError)
{
  var errorTxt = "Error\n";
  errorTxt += iError.message + "\n";
  //Debug(errorTxt);
  alert(errorTxt);
}


// ***********************
// Map methods
// ***********************
function InitializeTopoType() 
{
	CustomGetTileUrl=function(a,b,c) {
		var lULP = new GPoint(a.x*256,(a.y+1)*256);
		var lLRP = new GPoint((a.x+1)*256,a.y*256);
		var lUL = G_NORMAL_MAP.getProjection().fromPixelToLatLng(lULP,b,c);
		var lLR = G_NORMAL_MAP.getProjection().fromPixelToLatLng(lLRP,b,c);
		var lBbox=lUL.x+","+lUL.y+","+lLR.x+","+lLR.y;
		var lSRS="EPSG:4326";
		var lURL=this.myBaseURL;
		lURL+="&REQUEST=GetMap";
		lURL+="&SERVICE=WMS";
		lURL+="&reaspect=false&VERSION=1.1.1";
		lURL+="&LAYERS="+this.myLayers;
		lURL+="&STYLES=default"; 
		lURL+="&FORMAT="+this.myFormat;
		lURL+="&BGCOLOR=0xFFFFFF";
		lURL+="&TRANSPARENT=TRUE";
		lURL+="&SRS="+lSRS;
		lURL+="&BBOX="+lBbox;
		lURL+="&WIDTH=256";
		lURL+="&HEIGHT=256";
		lURL+="&GroupName="+this.myLayers;
		return lURL;
	}
	var tileDRG= new GTileLayer(new GCopyrightCollection(""),1,17);
	tileDRG.myLayers='DRG';
	tileDRG.myFormat='image/jpeg';
	tileDRG.myBaseURL='http://www.terraserver-usa.com/ogcmap6.ashx?';
	tileDRG.getTileUrl=CustomGetTileUrl;
	var topoLayer=[tileDRG];
	var topoMap = new GMapType(topoLayer, G_SATELLITE_MAP.getProjection(), "Topo", G_SATELLITE_MAP);
	
  return topoMap;	
}

function InitializeMap(iDivision, iLatitude, iLongitude, iZoomLevel, iMapType) 
{
  InitializeDebug();
	var topoMap = InitializeTopoType();
  
  var map = new GMap2(document.getElementById(iDivision), {draggableCursor: 'crosshair', draggingCursor: 'crosshair'});
	map.setCenter(new GLatLng(iLatitude, iLongitude), iZoomLevel);
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
	
	map.addMapType(topoMap);		var mapType = 'Topo';	if (isString(iMapType) && 
	    iMapType.length > 0)	  mapType = iMapType;
	if (mapType=='Satellite') {
			
		map.setMapType(G_SATELLITE_MAP);
			
	} else if (mapType=='Map') {
			
		map.setMapType(G_NORMAL_MAP); 
			
	} else if (mapType=='Hybrid') {		
			
		map.setMapType(G_HYBRID_MAP);
			
	} else if (mapType=='Topo') {		
			
		map.setMapType(topoMap);

	}

  return map;	
}

function CreateRoute(iRoutePoints, iColor, iWeight, iOpacity) 
{
  //DebugLn("CreateRoute");
  var useEncodedPolyline = 1;
  var routeData;
  
  if (iRoutePoints && 
      iRoutePoints.length > 0)
  {
    //DebugLn("iRoutePoints.length = " + iRoutePoints.length);
    var color = "#0000FF"; // Purple of saved route. #0000FF is orange-red of un-saved route.
    if (iColor)
      color = iColor;
    var weight = 5;
    if (iWeight)
      weight = iWeight;
    var opacity = 0.5;
    if (iOpacity)
      opacity = iOpacity;
    if (useEncodedPolyline)
    {
      var encoder = new GPolylineEncoder();
      //DebugObjectTable("Encoder", encoder)
      
      var encodedData = encoder.encode(iRoutePoints);
      DebugLn("encodedData.PointString = " + encodedData.PointString);
      DebugLn("encodedData.ZoomString = " + encodedData.ZoomString);
      
      // Set encodedPolyline
      routeData = new GPolyline.fromEncoded({
          color: color,
          weight: weight,
          opacity: opacity,
          points: encodedData.PointString, 
          levels: encodedData.ZoomString,
          zoomFactor: encodedData.ZoomFactor,
          numLevels: encodedData.NumLevels
      });
    }
    else
    {
      // Use normal poly line
      routeData = new GPolyline(iRoutePoints, color, weight);
    }
  }
  
  return routeData;
}

// Show route on map.
function ShowRoute(iMap, iRouteData) 
{
  //DebugLn("ShowRoute");
  if (iMap && iRouteData)
  {
    iMap.addOverlay(iRouteData);
  }
}

// Hide route.
function HideRoute(iMap, iRouteData) 
{
  //DebugLn("HideRoute");
  if (iMap && iRouteData)
  {
    iMap.removeOverlay(iRouteData);
  }
}

//Load xml file synchonously
function LoadXmlFile(iXmlDocName)
{
  //DebugLn("LoadRouteFile");
  //SetElementValue("LoadStatus", "");
  
  var xmlDoc;
  if (iXmlDocName && 
      iXmlDocName.length > 0)
  {
    var localXmlDoc;
    var xmlDocNameFile = "file:///" + iXmlDocName;
    //DebugLn("xmlDocNameFile = " + xmlDocNameFile);
    if (window.ActiveXObject)
    { // Code for IE
      localXmlDoc = new ActiveXObject("Microsoft.XMLDOM");
      //DebugObjectTable("XmlDoc", localXmlDoc);
      localXmlDoc.async = false;
      localXmlDoc.load(iXmlDocName);
      if (localXmlDoc.parseError.errorCode != 0)
        localXmlDoc.load(xmlDocNameFile);
      if (localXmlDoc.parseError.errorCode != 0)
      {
        txt="Xml file " + iXmlDocName + " not found.\n\n"
        txt+=localXmlDoc.parseError.reason + "\n\n"
        txt+="Click OK to continue.\n\n"
        alert(txt)
      }
      else
        xmlDoc = localXmlDoc;
    }
    else if (document.implementation &&
             document.implementation.createDocument)
    { // code for Mozilla, etc.
      var fileError;
      localXmlDoc = document.implementation.createDocument("","",null);
      localXmlDoc.async = false;
      //DebugObjectTable("XmlDoc", localXmlDoc);
      try
      {
        localXmlDoc.load(iXmlDocName);
      }
      catch(err)
      {
        fileError = err;
      }
      if (fileError)
      {
        fileError = null;
        try
        {
          localXmlDoc.load(xmlDocNameFile);
        }
        catch(err)
        {
          fileError = err;
        }
      }
      if (fileError)
      {
        var txt = "Xml file " + iXmlDocName + " not found.\n\n";
        txt+=fileError.message + "\n\n";
        txt+="Click OK to continue.\n\n";
        alert(txt);
      }
      else
      {
        xmlDoc = localXmlDoc;
      }
    }
    else
    {
      alert('Your browser cannot handle this script');
    }
  } // End if have file name.
  else
  {
    txt="Error: no file name given for xml file.\n"
    txt+="Click OK to continue.\n"
    alert(txt)
  }
  
  return xmlDoc;
}

function ParseRoute(iXmlDoc) 
{
  //DebugLn("ParseRoute");
  
  var routePoints;
  if (iXmlDoc)
  {
	  routePoints = [];
    var routeXmlElements = iXmlDoc.getElementsByTagName("rtept");
    //DebugLn("routeXmlElements.length = " + routeXmlElements.length);
    for (var iiPoint = 0; iiPoint < routeXmlElements.length; iiPoint++) 
    {
      var lat = parseFloat(routeXmlElements[iiPoint].getAttribute("lat"));
      var lon = parseFloat(routeXmlElements[iiPoint].getAttribute("lon"));
      //DebugLn("ParseRoute " + iiPoint + ": (" + lat + "," + lon + ")");
      routePoints.push(new GLatLng(lat, lon));
      //DebugLn("routePoints (" + routePoints[iiPoint].lat() + "," + routePoints[iiPoint].lng() + ")");
      //DebugObjectTable("Point", routePoints[iiPoint]);
    }
  }
  
  return routePoints;
}

// Download route data from a GPX Xml file.
// The format we expect is:
//   <rtept lat="34.58373" lon="-118.32122">
//       <name>Start</name>
//       <ele>1015.77038</ele>
//   </rtept>
function LoadRoute(iRouteXmlFile) 
{
  //DebugLn("LoadRoute");
  var xmlDoc = LoadXmlFile(iRouteXmlFile);
  return ParseRoute(xmlDoc);
}

function SetRoute(iCheckObject, iMap, iRouteData) 
{
  var showRoute = GetObject(iCheckObject);
  if (showRoute && 
      showRoute.checked)
  {
    ShowRoute(iMap, iRouteData);
  }
  else
  {
    HideRoute(iMap, iRouteData);
  }
}

// Gets elevation using Gmaps server which accesses gisdata.usgs.net data.
// I tried to understand gisdata.usgs.net directly, but it seems complex.
// Plus there are cross domain security issues with this method.
// I should really write a php script.
function GetElevation(iPoint) {  var elevation;
	if (iPoint) 	{
		var request = GXmlHttp.create();
		request.open('GET', 'http://www.gmap-pedometer.com/getElevation.php?x=' + iPoint.lng() + '&y=' + iPoint.lat(), false);
		request.onreadystatechange = function()		{
			if (request.readyState == 4) 			{
		    var xmlDoc = GXml.parse(request.responseText);
				elevation = xmlDoc.documentElement.childNodes[0].nodeValue;
		  }
		}
		request.send(null);
	}
}
