var gFunctionalityMessage = "<p>Your browser does not support the functions needed for Web Flash.<br>You should upgrade to the latest Mozilla Firefox or Internet Explorer</p>\n";
var gLoadTimer;
var gDebugWindow;

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
// Utilities
// ***********************
function ShowProgress(iNumberLoaded, iNumberToLoad)
{
  if (gCardList)
  {
    SetElementValue("LoadStatus", iNumberLoaded + " of " + iNumberToLoad + " cards loaded ...");
    //alert(gCardList.Card.length + " cards loaded ...");
  }
  else
  {
    //alert("No card list yet...");
  }
  //gLoadTimer = setTimeout("ShowProgress()",500);
}

/* Node types:
1  	ELEMENT_NODE
2 	ATTRIBUTE_NODE
3 	TEXT_NODE
4 	CDATA_SECTION_NODE
5 	ENTITY_REFERENCE_NODE
6 	ENTITY_NODE
7 	PROCESSING_INSTRUCTION_NODE
8 	COMMENT_NODE
9 	DOCUMENT_NODE
10 	DOCUMENT_TYPE_NODE
11 	DOCUMENT_FRAGMENT_NODE
12 	NOTATION_NODE
*/

//var DHTML = (document.getElementById || document.all || document.layers);

function SetElementHtml(iElement, iElemValue)
{
  var docElem = GetObject(iElement);
  if (docElem)
  {
    docElem.innerHTML = iElemValue;
  }
}

function GetElementHtml(iElement)
{
  var elemHtml = "";
  var docElem = GetObject(iElement);
  if (docElem)
    elemHtml = docElem.innerHTML;
  return (elemHtml);
}

function SetElementValue(iElement, iElemValue)
{
  var docElem = GetObject(iElement);
  if (docElem)
    docElem.value = iElemValue;
}

function GetElementValue(iElement)
{
  var elemVal = "";
  var docElem = GetObject(iElement);
  if (docElem)
    elemVal = docElem.value;
  return (elemVal);
}

function SetButtonClick(iButton, iClickAction)
{
  var button = GetObject(iButton);
  if (button)
  {
    if (button.addEventListener)
      button.addEventListener('click', iClickAction, false);
    else
      button.onclick = iClickAction;
  }
}

function RemoveChildrenFromNode(iNode)
{
  var node = GetObject(iNode);
  if (node)
  {   
	  while (node.hasChildNodes())
	  {
	    node.removeChild(node.firstChild);
	  }
	}
}

function ClearList(iList)
{
  var docElem = GetObject(iList);
  if (docElem)
    docElem.selectedIndex = 0;
}
