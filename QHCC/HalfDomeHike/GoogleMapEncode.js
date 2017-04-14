// JScript source code
// Javascript code written by Mark McClure in September 2006.
// http://facstaff.unca.edu/mcmcclur/GoogleMaps/EncodePolyline/

var gSmall0 = 500000;
var gNumLevels = 18;
var gZoomFactor = 2;
// gEscapeBackslashes = 1 escapes backslashes, = 0 does not.
// Original code escaped backslashes (used double backslash for single backslash).
// This is a good idea if you are using the output as a fixed string, for example 
// as a Javascript constant.
// However, if you are passing the output as data, the escape is not necessary and
// cause data corruption.
var gEscapeBackslashes = 0;

function GPolylineEncoder()
{
  // The encode function simply parses the input, calls the
  // createEncodings function and sets the results.
  this.encode = function (iPoints) 
  {
    //DebugLn("encode");
    var outString;
    
    var points = [];
    for(i=0; i < iPoints.length; i++) {
      points.push({
        lat: iPoints[i].lat(),
        lon: iPoints[i].lng(),
        lev: "unset"
      });
      DebugLn("points (" + points[i].lat + "," + points[i].lon + ")");
    }
    //DebugLn("points.length = " + points.length);
    this.setLevels(points);
    //DebugLn("setLevels done");
    var encodings = this.createEncodings(points);
    //DebugLn("encodings.PointString = " + encodings.PointString);
    //DebugLn("encodings.ZoomString = " + encodings.ZoomString);
    
    /*
    outString = "new GPolyline.fromEncoded({\n  color: \"#0000ff\",\n  weight: 4,\n  opacity: 0.8,\n  points: ";
    outString = outString + "\"" + result.PointString + "\",\n";
    outString = outString + "  levels: \"" + result.ZoomString + "\",\n";
    outString = outString + "  zoomFactor: 2,\n  numLevels: 18\n});\n";
    */
    var result = {
      PointString: encodings.PointString,
      ZoomString:  encodings.ZoomString, 
      ZoomFactor: gZoomFactor, 
      NumLevels: gNumLevels
    }
    return result;
  }


  // The createEncodings function is taken almost verbatim from
  // http://www.google.com/apis/maps/documentation/polyline.js
  // The only difference is the technique for passing data in and out.
  this.createEncodings = function (points) {
    var i = 0;

    var plat = 0;
    var plng = 0;

    var encoded_points = "";
    var encoded_levels = "";

    for(i = 0; i < points.length; ++i) 
    {
      var point = points[i];
      var lat = point.lat;
      var lng = point.lon;
      var level = point.lev;
      DebugLn(i + ": lat, lng (" + lat + "," + lng + ")");

      var late5 = Math.floor(lat * 1e5);
      var lnge5 = Math.floor(lng * 1e5);

      DebugLn(i + ": plat, plng (" + plat + "," + plng + ")");
      dlat = late5 - plat;
      dlng = lnge5 - plng;

      plat = late5;
      plng = lnge5;

      DebugLn(i + ": dlat, dlng (" + dlat + "," + dlng + ")");
      var encodedLat = this.encodeSignedNumber(dlat);
      var encodedLon = this.encodeSignedNumber(dlng);
      DebugLn(i + ": encodedLat, encodedLon (" + encodedLat + "," + encodedLon + ")");
      encoded_points += encodedLat + encodedLon;
      encoded_levels += this.encodeNumber(level);
    }
    return {
      PointString: encoded_points,
      ZoomString:  encoded_levels
    }
  }


  // The next two functions are taken verbatim from
  // http://www.google.com/apis/maps/documentation/polyline.js
  this.encodeSignedNumber = function (num) {
    var sgn_num = num << 1;

    if (num < 0) {
      sgn_num = ~(sgn_num);
    }

    return(this.encodeNumber(sgn_num));
  }

  this.encodeNumber = function (num) {
    var encodeString = "";
    var nextValue;

    while (num >= 0x20) {
      nextValue = (0x20 | (num & 0x1f)) + 63;
      if (gEscapeBackslashes && nextValue == 92) {
        encodeString += (String.fromCharCode(nextValue));
      }
      encodeString += (String.fromCharCode(nextValue));
      num >>= 5;
    }

    finalValue = num + 63;
    if (gEscapeBackslashes && finalValue == 92) {
      encodeString += (String.fromCharCode(finalValue));
    }
    encodeString += (String.fromCharCode(finalValue));
    return encodeString;
  }


  // The next two functions set the level string,
  // which is a bit trickier.

  // dist(point1, point2) returns the distance between point1
  // and point2 in meters.  Note that each point needs lat
  // and lon properties.
  this.dist = function (point1, point2) {
    var deg = 0.0174532925199;
    
    return 12746004.5*Math.asin(Math.sqrt(
      Math.pow(Math.sin((point1.lat - point2.lat)*deg/2),2) + 
        Math.cos(point1.lat*deg)*Math.cos(point2.lat*deg)*
          Math.pow(Math.sin((point1.lon - point2.lon)*deg/2),2)));
  }

  // We set the levels here.
  this.setLevels = function (points) 
  {
    //DebugLn("setLevels");
    var numLevels = gNumLevels;
    var small, i, j;
    var len = points.length;
    //DebugLn("points.length = " + points.length);
    
    // Set the endpoints to show at all zoom levels
    points[0].lev = numLevels-1;
    points[len-1].lev = numLevels-1;
    
    // Starting at the largest possible level, we step down through
    // the levels labelling points which need to appear at
    // lower resolutions.
    for (level = numLevels-1; level >= 0; level--) {
      // Set "small" for the current level.
      // More generally, we might use
      // small = gSmall0*Math.pow(2.0, -18*(numLevels-level)/numLevels);
      small = gSmall0*Math.pow(2.0, level-18);
      
      // Figure out which points need to occur at this level,
      // the main criteria being that we've stepped a certain 
      // distance (called "small") from the previous set point.
      i = j = 1;
      while (i < len-1) {
        if (this.dist(points[i], points[j]) >= small && points[i].lev == "unset") {
          points[i].lev = level;
          j = i;
        }
        if (points[i].lev != "unset") {
          j=i;
        }
        i++;
      }
    }
    // Set any unset points to level 0.
    for (i=0; i < len; i++) {
      if (points[i].lev == "unset") {
        points[i].lev = 0;
      }
    }
  }
}
