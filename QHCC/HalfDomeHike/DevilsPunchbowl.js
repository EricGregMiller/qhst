// Show map based on selection
function InitMap()
{
  var topoDiv =  GetObject('Topo');
  var trailsDiv =  GetObject('Trails');
  if (topoDiv && trailsDiv)
  {
    var topoCheck =  GetObject('TopoRadio');
    topoCheck.checked = true;
    topoDiv.style.visibility = "visible";
    trailsDiv.style.visibility = "hidden";
  }
}

// Show map based on selection
function ShowMap()
{
  var topoDiv =  GetObject('Topo');
  var trailsDiv =  GetObject('Trails');
  if (topoDiv && trailsDiv)
  {
    var topoCheck =  GetObject('TopoRadio');
    var trailsCheck =  GetObject('TrailsRadio');
    var topoTrailsCheck =  GetObject('TopoTrailsRadio');
    if (topoCheck && topoCheck.checked)
    {
      topoDiv.style.visibility = "visible";
      trailsDiv.style.visibility = "hidden";
    }
    else if (trailsCheck && trailsCheck.checked)
    {
      topoDiv.style.visibility = "hidden";
      trailsDiv.style.visibility = "visible";
    }
    else if (topoTrailsCheck && topoTrailsCheck.checked)
    {
      topoDiv.style.visibility = "visible";
      trailsDiv.style.visibility = "visible";
    }
  }
}
