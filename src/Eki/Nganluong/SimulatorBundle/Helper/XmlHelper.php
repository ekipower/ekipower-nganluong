<?php
/**
 * This file is part of the EkiNganluongSimulatorBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Nganluong\SimulatorBundle\Helper;

use \DOMDocument;

class XmlHelper
{
	static public function array2xml( array $array, $node_name = "root" ) 
	{
	    $dom = new DOMDocument('1.0', 'UTF-8');
	    $dom->formatOutput = true;
	    $root = $dom->createElement($node_name);
	    $dom->appendChild($root);

	    $array2xml = function ($node, $array) use ($dom, &$array2xml) {
	        foreach($array as $key => $value)
			{
	            if ( is_array($value) ) 
				{
	                $n = $dom->createElement($key);
	                $node->appendChild($n);
	                $array2xml($n, $value);
	            }
				else
				{
	                $attr = $dom->createAttribute($key);
	                $attr->value = $value;
	                $node->appendChild($attr);
	            }
	        }
	    };

	    $array2xml($root, $array);

    	return $dom->saveXML();
	}
}
