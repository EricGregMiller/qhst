<?php

// Classes to unify domxml calls between PHP versions 4 and 5.
/*
DOMDocument45
DOMXPath45
DOMNodeList45
DOMNode45
*/

//echo "Php Version: " . phpversion() . "<br/>\n";

if (preg_match("/^4/i", phpversion()))
{
  function GetNodeListLength($nodeList)
  {
    $length = 0;
    if (is_array($nodeList))
    {
      $length = count($nodeList);
    }
    //echo '<pre>';
    //echo "GetNodeListLength length = {$length}";
    //echo '</pre>';
    return $length;
  }

  function GetNodeListItem($nodeList, $itemNum)
  {
    //echo '<pre>';
    //echo "GetNodeListItem itemNum = {$itemNum}";
    //echo '</pre>';
    if (is_array($nodeList) && 
        $itemNum >= 0 && 
        $itemNum < GetNodeListLength($nodeList))
    {
      //echo '<pre>';
      //echo "GetNodeListItem nodeList =";
      //var_dump($nodeList);
      $item = $nodeList[$itemNum];
      //echo "GetNodeListItem item =";
      //var_dump($item);
      //echo '</pre>';
      return $item;
    }
  }

  function GetNodeValue($node)
  {
    $value = "";
    //echo 'GetNodeValue node';
    //echo '<pre>';
    //var_dump($node);
    if (is_object($node))
      $value = htmlentities(utf8_decode($node->get_content()));
    //echo "Value = {$value}";
    //echo '</pre>';
    return $value;
  }

  function GetNodeAttributeValue($node, $name)
  {
    $attVal = "";
    //echo "<td>Attr name = {$name}";
    $attArray = $node->attributes();
    if (is_array($attArray))
    {
      foreach($attArray as $att)
      {
	//echo "{$att->name} = {$att->value} ";
	if($att->name == $name)
	{
	  $attVal = $att->value;
	  break;
	}
      }
      //echo ", value = {$attVal}</td>\n";
    }
    return $attVal;
  }

  class DOMDocument45
  {
    var $domdoc;

    function load($file)
    {
      $xmlPath = dirname(__FILE__) . "/";
      if (!$this->domdoc = domxml_open_file($xmlPath . $file)) {
	echo "Error while parsing {$xmlPath}{$file}<br/>\n";
	exit;
      }    
    } // End load func
  }

  class DOMXPath45
  {
    var $xpath;
    function init($domdoc)
    {
      $this->xpath = xpath_new_context($domdoc);
    }
    function registerNamespace($name, $uri)
    {
      xpath_register_ns($this->xpath, $name, $uri);
    }
    function evaluate($query, $contextNode = NULL)
    {
      $retval = new DOMNodeList45;
      if ($contextNode)
      {
	if ($contextNode->node)
	  $qresult = $this->xpath->xpath_eval($query, $contextNode->node);
	else
	  $qresult = $this->xpath->xpath_eval($query, $contextNode);
      }
      else
	$qresult = $this->xpath->xpath_eval($query);
      $retval->init($qresult->nodeset);
      return $retval;
    }
  }

  class DOMNode45
  {
    var $node;
    var $nodeValue;
    function init($node)
    {
      echo '<pre>';
      var_dump($node);
      echo '</pre>';
      $this->node = $node;
      $this->nodeValue = $this->node->get_content();
    }
  }

  class DOMNodeList45
  {
    var $nl;
    function init($nodeList)
    {
      echo '<pre>';
      var_dump($nodeList);
      echo '</pre>';
      $this->nl = $nodeList;
    }
    function NodeList()
    {
      return $this->nl;
    }
    function item($itemNum)
    {
      echo "DOMNodeList45::item: {$itemNum}<br/>\n";
      echo '<pre>';
      var_dump($this->nl);
      echo '</pre>';
      $item = new DOMNode45;
      $item->init($this->nl[$itemNum+1]); 
      //$item->init($this->item($itemNum)); 
      return $item;
    }
  }
}
else
{
  function GetNodeListLength($nodeList)
  {
    $length = 0;
    if (is_object($nodeList))
    {
      $length = $nodeList->length;
    }
    return $length;
  }

  function GetNodeListItem($nodeList, $itemNum)
  {
    return $nodeList->item($itemNum);
  }

  function GetNodeValue($node)
  {
    return htmlentities(utf8_decode($node->nodeValue));
  }

  function GetNodeAttributeValue($node, $name)
  {
    $attVal = "";
    //echo "<td>name = {$name}</td>\n";
    $attArray = $node->attributes;
    foreach($attArray as $att)
    {
      //echo "<td>attname = {$att->name}</td>\n";
      if($att->name == $name)
	{
	  $attVal = $att->value;
	  break;
	}
    }
    return $attVal;
  }

  class DOMDocument45 extends DOMDocument
  {
  }

  class DOMXPath45
  {
    var $xpath;
    function init($domdoc)
    {
      $this->xpath = new DOMXPath($domdoc);
    }
    function registerNamespace($name, $uri)
    {
      $this->xpath->registerNamespace($name, $uri);
    }
    function evaluate($query, $contextNode = NULL)
    {
      $retval = new DOMNodeList45;
      if ($contextNode)
      {
	if ($contextNode->node)
	  $qresult = $this->xpath->evaluate($query, $contextNode->node);
	else
	  $qresult = $this->xpath->evaluate($query, $contextNode);
      }
      else
	$qresult = $this->xpath->evaluate($query);
      $retval->init($qresult);
      return $retval;
    }
  }

  class DOMNode45
  {
    var $node;
    var $nodeValue;
    function init($node)
    {
      //echo '<pre>';
      //var_dump($node);
      //echo '</pre>';
      $this->node = $node;
      $this->nodeValue = $this->node->nodeValue;
    }
  }

  class DOMNodeList45
  {
    var $nl;
    function init($nodeList)
    {
      echo '<pre>';
      var_dump($nodeList);
      echo '</pre>';
      $this->nl = $nodeList;
    }
    function NodeList()
    {
      return $this->nl;
    }
    function item($itemNum)
    {
      //echo "DOMNodeList45::item: {$itemNum}<br/>\n";
      $item = new DOMNode45;
      $item->init($this->nl->item($itemNum)); 
      return $item;
    }
  }
}
	
