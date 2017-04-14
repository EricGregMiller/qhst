<?php

include '../../QHScript/Domxml45.php';

if (preg_match("/^4/i", phpversion()))
{
  class OpenOfficeCalc
  {
    var $domdoc;
    var $xpath;

    function GetSheetRows($file, $tableName)
    {
      //echo "GetSheetRows: {$file}, {$tableName}<br/>\n";
      $xmlPath = dirname(__FILE__) . "/";
      if (!$this->domdoc = domxml_open_file($xmlPath . $file)) {
	echo "Error while parsing {$xmlPath}{$file}<br/>\n";
	exit;
      }    
      $this->xpath = xpath_new_context($this->domdoc);
      
      xpath_register_ns($this->xpath, 'office', 'urn:oasis:names:tc:opendocument:xmlns:office:1.0');
      xpath_register_ns($this->xpath, 'table', 'urn:oasis:names:tc:opendocument:xmlns:table:1.0');
      $query = '/office:document-content/office:body/office:spreadsheet/table:table[@table:name="'.$tableName.'"]/table:table-row';
      $rows = $this->xpath->xpath_eval($query);
      //echo '<pre>';
      //var_dump($rows);
      //var_dump($rows->nodeset);
      //echo '</pre>';
      //echo "End GetSheetRows<br/>\n";
      return $rows->nodeset;
    }

    function GetRowCells($row)
    {
      //echo "GetRowCells<br/>\n";
      $cells = $this->xpath->xpath_eval('table:table-cell', $row);
      //$cells = $row->get_elements_by_tagname('ttable-cell');
      return $cells->nodeset;
    }
  }  
}
else
{
  class OpenOfficeCalc
  {
    var $domdoc;
    var $xpath;

    function GetSheetRows($file, $tableName)
    {
      //echo "GetSheetRows: {$file}, {$tableName}<br/>\n";
      $this->domdoc = new DOMDocument;
      $this->domdoc->load($file);
      
      $this->xpath = new DOMXPath($this->domdoc);
      
      $this->xpath->registerNamespace('office', 'urn:oasis:names:tc:opendocument:xmlns:office:1.0');
      $this->xpath->registerNamespace('table', 'urn:oasis:names:tc:opendocument:xmlns:table:1.0');
      $query = '/office:document-content/office:body/office:spreadsheet/table:table[@table:name="'.$tableName.'"]/table:table-row';
      $rows = $this->xpath->evaluate($query);
      //echo '<pre>';
      //var_dump($rows);
      //echo '</pre>';
      //echo "End GetSheetRows<br/>\n";
      return $rows;
    }
  
    function GetRowCells($row)
    {
      $cells = $this->xpath->evaluate('table:table-cell', $row);
      return $cells;
    }
  }  
}
