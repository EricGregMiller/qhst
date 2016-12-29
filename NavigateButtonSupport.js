// Define button link (reference) path.
if (!gButtonRefPath || 
    gButtonRefPath.length <= 0)
  var gButtonRefPath = "/";

// Button links.
var gButtonRef = new Array("welcome-.htm", 
                           "becomeachristian.html", 
                           "bookstor.htm", 
                           "catalog.htm", 
                           "schedule.html", 
                           "onlinecourses.html", 
                           "doctrinalstatement.html", 
                           "guestbook.html", 
                           "library.htm", 
                           "more.htm", 
                           "search.html", 
                           "QHCC/church.htm");

// Button image data.
var gButtonImagePath = gButtonRefPath + "graphix/frame/";
var gButtonImageExtension = ".jpg";
var gButtonImageNames = new Array("b1", 
                                  "b2", 
                                  "b3", 
                                  "b4", 
                                  "b5", 
                                  "b6", 
                                  "b7", 
                                  "b8", 
                                  "b9", 
                                  "b10", 
                                  "b11", 
                                  "b12");

//Get the reference for a button link. First button is 1.
function GetButtonHref(iButtonNum)
{
  var buttonHref;
  if (iButtonNum > 0 && 
      iButtonNum <= gButtonImageNames.length)
  {
    buttonHref = gButtonRefPath + gButtonRef[iButtonNum-1];;
  } // End if valid button number
  return (buttonHref);
}

//Get the filename for a button image. First button is 1.
function GetButtonImageFile(iButtonNum, iImageType)
{
  var buttonImageFile;
  if (iButtonNum > 0 && 
      iButtonNum <= gButtonImageNames.length)
  {
    var buttonName = gButtonImageNames[iButtonNum-1];
    if (iImageType && 
        iImageType.length > 0)
      buttonName = buttonName + iImageType;
    buttonImageFile = gButtonImagePath + buttonName+ gButtonImageExtension;
  } // End if valid button number
  return (buttonImageFile);
}

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

// Change the image source for a given button (object and number are input).
function ChangeButtonImage(iButton, iButtonNum, iNewImageType) 
{
  ChangeObjectImage(iButton, GetButtonImageFile(iButtonNum, iNewImageType));
}
