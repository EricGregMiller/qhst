// Xml file handling script.

//Load xml file synchonously
function LoadXmlFileOld(iXmlDocName)
{
  DebugLn("LoadXmlFile");

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
        var nodeKids = xmlDoc.childNodes;
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

//Load xml file synchonously
function LoadXmlFile(iXmlDocName)
{
  DebugLn("LoadXmlFile");

  var xmlDoc;
  if (iXmlDocName && 
      iXmlDocName.length > 0)
  {
    var localXmlDoc;
    var xmlDocNameFile = "file:///" + iXmlDocName;
    DebugLn("xmlDocNameFile = " + xmlDocNameFile);
    var xmlDocNameUrl = "http://theology.edu/QHCC/" + iXmlDocName;
    DebugLn("xmlDocNameUrl = " + xmlDocNameUrl);
    var xmlhttp = null;
    var ie56 = 0;
    if (window.XMLHttpRequest)
    { // Code for Chrome and new Mozilla, etc.
      // Can be seen here http://chromespot.com/forum/google-chrome-troubleshooting/1063-xml-load-issue-javascript.html
      // Refered to http://www.xml.com/pub/a/2005/02/09/xml-http-request.html
      xmlhttp = new window.XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    { // Code for IE 5 and 6
      var xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      ie56 = 1;
    }
    if (null != xmlhttp)
    {
      var fileError;
      var haveError = 0;
      try
      {
        xmlhttp.open("GET",iXmlDocName,false);
        if (1 == ie56)
          xmlhttp.send();
        else
          xmlhttp.send(null);
        if (4 == xmlhttp.readyState && 
            200 == xmlhttp.status)
        {
          localXmlDoc = xmlhttp.responseXML.documentElement;
        }
        else
        {
          haveError = 1;
        }
      }
      catch(err)
      {
        fileError = err;
      }
      if (fileError || haveError)
      {
        fileError = null;
        haveError = 0;
        try
        {
          xmlhttp.open("GET",xmlDocNameUrl,false);
          if (1 == ie56)
            xmlhttp.send();
          else
            xmlhttp.send(null);
          if (4 == xmlhttp.readyState && 
              200 == xmlhttp.status)
          {
            localXmlDoc = xmlhttp.responseXML.documentElement;
          }
          else
          {
            haveError = 1;
          }
        }
        catch(err)
        {
          fileError = err;
        }
        if (fileError || haveError)
        {
          fileError = null;
          haveError = 0;
          try
          {
            xmlhttp.open("GET",xmlDocNameFile,false);
            if (1 == ie56)
              xmlhttp.send();
            else
              xmlhttp.send(null);
            if (4 == xmlhttp.readyState && 
                200 == xmlhttp.status)
            {
              localXmlDoc = xmlhttp.responseXML.documentElement;
            }
            else
            {
              haveError = 1;
            }
          }
          catch(err)
          {
            fileError = err;
          }
        }
      }
      if (fileError || haveError)
      {
        var txt = "Xml file " + iXmlDocName + " not found.\n\n";
        if (fileError)
          txt+=fileError.message + "\n\n";
        txt+="Click OK to continue.\n\n";
        alert(txt);
      }
      else
      {
        xmlDoc = localXmlDoc;
      }
    } // End if have xmlhttp
    else if (document.implementation &&
             document.implementation.createDocument)
    { // code for old Mozilla, etc.
      var fileError;
      // -------
      localXmlDoc = document.implementation.createDocument("","",null);
      localXmlDoc.async = false;
      //DebugObjectTable("XmlHttp", xmlhttp);
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
    } // End code for old Mozilla
    else
    { // No know way to load for this browser
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

function ParseXmlNode(iXmlNode)
{
  Debug("ParseXmlNode: iXmlNode.nodeName, type = " + iXmlNode.nodeName + "," + iXmlNode.nodeType);
  var nodeKids = iXmlNode.childNodes;
  DebugLn(iXmlNode.nodeName + " nodeKids.length = " + nodeKids.length);
  var nodeData;
  var textData = "";
  var haveSubNode = 0;
  var iiNk;
  for (iiNk=0; iiNk<nodeKids.length; iiNk++)
  {
    DebugLn(iXmlNode.nodeName + " " + iiNk + ": nodeKids[iiNk].nodeName, type, value = " + nodeKids[iiNk].nodeName + "," + nodeKids[iiNk].nodeType + "," + nodeKids[iiNk].nodeValue);
    if (1 == nodeKids[iiNk].nodeType)
    { // Found a node element
      if (!haveSubNode)
      {
        haveSubNode = 1;
        nodeData = new Object();
      }
      if (nodeData[nodeKids[iiNk].nodeName])
      { // Element already exists: need to use array
        if (!nodeData[nodeKids[iiNk].nodeName].length)
        { // Do not have array yet, change to array.
          var saveData = nodeData[nodeKids[iiNk].nodeName];
          nodeData[nodeKids[iiNk].nodeName] = new Array();
          nodeData[nodeKids[iiNk].nodeName][0] = saveData;
        } // End if no array yet.
        // Add new data to array
        nodeData[nodeKids[iiNk].nodeName][nodeData[nodeKids[iiNk].nodeName].length] = ParseXmlNode(nodeKids[iiNk]);
      }
      else
      {
        nodeData[nodeKids[iiNk].nodeName] = ParseXmlNode(nodeKids[iiNk]);
      }
    } // End if found a node element.
    else if (!haveSubNode && 
             3 == nodeKids[iiNk].nodeType && 
             textData.length <= 0)
    { // Found a text element.
      textData = nodeKids[iiNk].nodeValue;
    } // End if found a text element.
  } // End loop on nodeKids
  if (!haveSubNode && 
      textData.length > 0)
    nodeData = textData;
  return nodeData;
}

// ***********************
// Initialize card list
// ***********************
function ParseXmlTag(iXmlDoc, iTagName)
{
  DebugLn("ParseXmlTag");
  //DebugObjectTable("Xml doc", iXmlDoc);
  DebugLn("iTagName = " + iTagName);
  var tagData = new Array();
  if (isObject(iXmlDoc) && 
      StringLength(iTagName) > 0)
  {
    DebugLn("Input OK");
    // 100823: Old style doc load return the document at a root node.
    //   New style returns the root node of the document
    //   Code below handles either case.
    var listXmlElements;
    if (iXmlDoc.nodeName == iTagName)
    { // Document has this tag. Just put it in list.
      listXmlElements = new Array();
      listXmlElements.push(iXmlDoc);
    }
    else
    {
      listXmlElements = iXmlDoc.getElementsByTagName(iTagName);
    }
    //DebugObjectTable("listXmlElements", listXmlElements);
    if (listXmlElements)
    {
      DebugLn("listXmlElements.length = " + listXmlElements.length);
      for (iiElem=0; iiElem<listXmlElements.length; iiElem++)
      {
        DebugLn('iiElem = ' + iiElem);
        tagData.push(ParseXmlNode(listXmlElements[iiElem]));
      }
    }
  }
  return tagData;
}
