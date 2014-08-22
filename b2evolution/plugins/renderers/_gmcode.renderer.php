<?php
/**
 * This file implements the GMcode plugin for b2evolution
 *
 * GreyMatter style formatting
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/license.html}
 * @copyright (c)2003-2004 by Francois PLANQUE - {@link http://fplanque.net/}
 *
 * @package plugins
 */
if( !defined('DB_USER') ) die( 'Please, do not access this page directly.' );

/**
 * Includes:
 */
require_once dirname(__FILE__).'/../renderer.class.php';

/**
 * @package plugins
 */
class gmcode_Rendererplugin extends RendererPlugin
{
	var $code = 'b2evGMco';
	var $name = 'GM code';
	var $priority = 45;
	var $apply_when = 'opt-out';
	var $apply_to_html = true; 
	var $apply_to_xml = false; // Leave the GMcode markup
	var $short_desc;
	var $long_desc;

	/**
	 * GreyMatter formatting search array
	 *
	 * @access private
	 */
	var $search = array(
											'# \*\* (.+?) \*\* #x',		// **bold**
											'# \x5c\x5c (.+?) \x5c\x5c #x',		// \\italics\\
											'# (?<!:) \x2f\x2f (.+?) \x2f\x2f #x',		// //italics// (not preceded by : as in http://)
											'# __ (.+?) __ #x',		// __underline__
											'/ \#\# (.+?) \#\# /x',		// ##tt##
											'/ %%								
												( \s*? \n )? 				# Eat optional blank line after %%%
												(.+?) 
												( \n \s*? )? 				# Eat optional blank line before %%%
												%%
											/sx'		// %%codeblock%%
											);
	
	/**
	 * HTML replace array
	 *
	 * @access private
	 */
	var $replace = array(
											'<strong>$1</strong>',
											'<em>$1</em>',
											'<em>$1</em>',
											'<span style="text-decoration:underline">$1</span>',
											'<tt>$1</tt>',
											'<div class="codeblock"><pre><code>$2</code></pre></div>'
											);


	/**
	 * Constructor
	 *
	 * {@internal gmcode_Rendererplugin::gmcode_Rendererplugin(-)}}
	 */
	function gmcode_Rendererplugin()
	{
		$this->short_desc = T_('GreyMatter style formatting');
		$this->long_desc = T_('**bold** \\italics\\ //italics// __underline__ ##tt## %%codeblock%%');
	}


	/**
	 * Perform rendering
	 *
	 * {@internal gmcode_Rendererplugin::render(-)}} 
	 *
	 * @param string content to render (by reference) / rendered content
	 * @param string Output format, see {@link format_to_output()}
	 * @return boolean true if we can render something for the required output format
	 */
	function render( & $content, $format )
	{
		if( ! parent::render( $content, $format ) )
		{	// We cannot render the required format
			return false;
		}
	
		$content = preg_replace( $this->search, $this->replace, $content );
		
		return true;
	}
}

// Register the plugin:
$this->register( new gmcode_Rendererplugin() );

?>