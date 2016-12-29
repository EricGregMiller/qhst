<?php

require '../../QHScript/QHCCPage.php';
include 'OpenOfficeXml.php';

class FY extends QHCCPage
{
  var $FY;
  var $domdoc;
  var $xpath;

  function FYHead($fy)
  {
    $this->FY = $fy;

    echo '<html>';
    echo '<head>';
    echo '  <meta HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">';
    echo '  <title>' . $this->FY .' Finance Report</title>';

    $this->requestUri = $_SERVER['REQUEST_URI'];
    $this->webRoot = $_SERVER['DOCUMENT_ROOT'];
    $this->HeadEnd();

    echo '  <link rel="stylesheet" type="text/css" href="FY.css" />';
    echo '</head>';
    echo '<body>';

    $this->PageBegin(0);

    echo '  <h1>' . $this->FY . ' Finance Report</h1>'."\n";
  }

  function GenerateBalanceTable($file)
  {
    //echo "GenerateBalanceTable: {$file}<br/>\n";
    $ooc = new OpenOfficeCalc;
    $rows = $ooc->GetSheetRows($file, "Balances");

    $numCols = 0;
    foreach ($rows as $row) {
      $cells = $ooc->GetRowCells($row);
      //echo "Got cells 1<br/>\n";
      $cell0 = GetNodeListItem($cells, 0);
      //echo "cell0: ".GetNodeValue($cell0)."<br/>\n";
      $cell1 = GetNodeListItem($cells, 1);
      if (0 == $numCols)
      {
        if (GetNodeValue($cell0) == 'Date')
        {
          //echo "Header: ".GetNodeValue($row)."<br/>\n";
          echo "<table><thead>\n<tr>";
          $numCols = GetNodeListLength($cells);
	  $iiCol = 0;
          foreach ($cells as $cell)
          {
            if (1 == $iiCol) // QHCC acct balance.
              echo "<th class='BgBlue'>".GetNodeValue($cell)."</th>";
            else if (2 == $iiCol) // General fund balance
              echo "<th class='BgPurple'>".GetNodeValue($cell)."</th>";
            else
              echo "<th>".GetNodeValue($cell)."</th>";
            if (GetNodeValue($cell) == 'Temporary')
            {
              $numCols = $iiCol + 1;
              break;
            }
	    $iiCol++;
          }
          echo "</tr></thead>\n";
        }
      }
      else
      {
        //echo "<tr><td>cell1: ".GetNodeValue($cell1)."</td></tr>\n";
        if (0 == GetNodeValue($cell1))
          break;

        echo "<tr>";
	$iiCol = 0;
        foreach ($cells as $cell)
        {
          if (1 == $iiCol) // QHCC acct balance.
            echo "<td class='BgBlue'>".GetNodeValue($cell)."</td>";
          else if (2 == $iiCol) // General fund balance
            echo "<td class='BgPurple'>".GetNodeValue($cell)."</td>";
          else
            echo "<td>".GetNodeValue($cell)."</td>";
          $iiCol++;
	  if ($iiCol >= $numCols)
	    break;
        }
        echo "</tr>\n";
      }
    }
    if ($numCols > 0)
    {
      echo "</table>\n";
    }
  }

  function GenerateBudgetTable($file)
  {
    //echo "GenerateBudgetTable: {$file}<br/>\n";
    $ooc = new OpenOfficeCalc;
    $rows = $ooc->GetSheetRows($file, "Budget");

    // Find months with valid data.
    $lastMonthCol = 13;
    $decemberCol = 13;
    foreach ($rows as $row) {
      $cells = $ooc->GetRowCells($row);
      $cell0 = GetNodeListItem($cells, 0);
      //echo "cell0: ".GetNodeValue($cell0)."<br/>\n";
      if (preg_match("/^General *Income/i", GetNodeValue($cell0)))
      {
	$iiCol = 0;
        foreach ($cells as $cell)
        {
	  $nv = GetNodeValue($cell);
          if (0 == strlen($nv) || 
              preg_match("/^  *$/", $nv))
          {
            $lastMonthCol = $iiCol - 1;
            break;
          }
          $numRepeat = 1;
          $nr = GetNodeAttributeValue($cell, 'number-columns-repeated');
          if ($nr && $nr > 1)
            $numRepeat = $nr;
          while ($numRepeat > 0 && $iiCol <= $decemberCol)
          {
            $numRepeat--;
            $iiCol++;;
          }
	  if ($iiCol > $decemberCol)
	    break;
        }        
        break;
      }
    }
    //echo "lastMonthCol = {$lastMonthCol}<br/>\n";

    $numCols = 0;
    $lastBlank = 0;
    foreach ($rows as $row) {
      $cells = $ooc->GetRowCells($row);
      $cell0 = GetNodeListItem($cells, 0);
      //echo "cell0: ".GetNodeValue($cell0)."<br/>\n";
      $cell1 = GetNodeListItem($cells, 1);
      if (0 == $numCols)
      {
        if (preg_match("/^Category/", GetNodeValue($cell0)))
        {
          //echo "Header: ".GetNodeValue($row)."<br/>\n";
          $numCols = GetNodeListLength($cells);
          //echo "numCols = {$numCols}<br/>\n";
          echo "<table><thead>\n<tr>";
	  $iiCol = 0;
          foreach ($cells as $cell)
          {
	    $nv = GetNodeValue($cell);
            //echo "<td>{$iiCol}: {$nv}</td>"; 

            // Skip months without data.
            if ($iiCol <= $lastMonthCol || 
                $iiCol > $decemberCol)
            { 
	      if (1 == $iiCol) // Monthly Budget
		echo "<th class='BgBlue'>{$nv}</th>";
	      else if (14 == $iiCol) // Total YTD
		echo "<th class='BgPurple'>{$nv}</th>";
	      else if (15 == $iiCol) // Budget YTD
		echo "<th class='BgBlue'>{$nv}</th>";
	      else
		echo "<th>{$nv}</th>";
	    }
            if (1 < $iiCol && 
                $nv == 'Annual Budget')
            {
              $numCols = $iiCol + 1;
              //echo "numCols = {$numCols}<br/>\n";
              break;
            }
	    $iiCol++;
          }
          echo "</tr></thead>\n";
        }
      }
      else
      {
        //echo "<tr><td>cell1: ".GetNodeValue($cell1)."</td></tr>\n";
        echo "<tr>";
        $isBold = 0;
        if ($lastBlank || 
            preg_match("/Total/i", GetNodeValue($cell0)))
          $isBold = 1;
        for ($iiCol = 0, $iiCell = 0; $iiCol < $numCols; $iiCell++)
        {
          $nv = '';
          $numRepeat = 1;
          //echo "<td>iiCol = {$iiCol}</td>"; 
          //echo "<td>iiCell = {$iiCell}</td>"; 
          if ($iiCell < GetNodeListLength($cells))
          {
	    $cell = GetNodeListItem($cells, $iiCell);
	    $nv = GetNodeValue($cell);
            $nr = GetNodeAttributeValue($cell, 'number-columns-repeated');
            //echo "<td>nr = {$nr}</td>";
            if ($nr && $nr > 1)
              $numRepeat = $nr;
          }
          if (0 == strlen($nv) || 
              preg_match("/^  *$/", $nv))
          {
            $nv = "&nbsp;";
          }
          else if (preg_match("/^\(.*\)$/", $nv))
          {
            $nv = "<span  class='ColorRed'>".$nv."</span>";
          }
          if ($isBold)
          {
            $nv = "<span  class='FontBold'>".$nv."</span>";
          }
          while ($numRepeat > 0 && $iiCol < $numCols)
          {
            // Skip months without data.
            if ($iiCol <= $lastMonthCol || 
                $iiCol > $decemberCol)
            { 
              if (0 == $iiCol && $lastBlank) // Category name.
              {
                if ($lastBlank) // Main category name.
                  echo "<td class='AlignLeft'>{$nv}</td>";
              }
              else if (1 == $iiCol) // Monthly Budget.
                echo "<td class='BgBlue'>{$nv}</td>";
              else if (14 == $iiCol) // Total YTD
                echo "<td class='BgPurple'>{$nv}</td>";
              else if (15 == $iiCol) // Budget YTD
                echo "<td class='BgBlue'>{$nv}</td>";
              else
                echo "<td>{$nv}</td>";
            }
            $numRepeat--;
            $iiCol++;;
          }
        } // End loop on cells
        echo "</tr>\n";
        if (preg_match("/^OVERALL/", GetNodeValue($cell0)))
        {
          break;
        }
        if (0 == strlen(GetNodeValue($cell0)) || 
            preg_match("/^  *$/", GetNodeValue($cell0)))
          $lastBlank = 1;
        else
          $lastBlank = 0;
      } // End else already have header.
    } // End loop on rows.
    if ($numCols > 0)
    {
      echo "</table>\n";
    }
  }

}
?>