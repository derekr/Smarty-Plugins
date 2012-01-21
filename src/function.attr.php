<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.attr.php
 * Type:     function
 * Name:     attr
 * Purpose:  Simplifies the setting of attribute values
 * -------------------------------------------------------------
 *
 * Usage:
 *  $obj->active     = true;
 *  $obj->title      = 'Whaddup';
 *  $obj->status     = 'pending';
 *  $obj->public_url = 'http://example.com';
 *
 *  === TEMPLATE ===
 *  <a {% attr $obj href="public_url" class="active:we-are-live active status" %}>{% $obj->title %}</a>
 *  > <a class="we-are-live is-active pending" href="http://example.com">Whaddup</a>
 */
function smarty_function_attr($params)
{
  $attributes = array();
  
  $target = $params['target'];
  unset($params['target']);
  
  $enclose = array_key_exists('enclose', $params) ? $params['enclose'] : '"';
  unset($params['enclose']);
  $en = $enclose;
  
  $newline = array_key_exists('newline', $params) && $params['newline'] == true ? "\n" : ' ';
  unset($params['newline']);
  
  $sort = array_key_exists('sort', $params) ? $params['sort'] : false;
  unset($params['sort']);
  
  foreach ($params as $attr => $val) {
  	if ($attr == 'class') {
  	  $class_str = '';
  	  $classes = explode(' ', $val);
  	  
  	  foreach ($classes as $class) {
    	  $parts = explode(':', $class);
    	  $prop = $parts[0];
        
        if (!$prop)
          continue;
        
    	  $prop_val = $target->$prop;
        
        if (!$prop_val) {
          $class_str .= $prop;
          continue;
        }
        
    	  if (count($parts) > 1) {
      	  $class_str .= is_bool($prop_val) && $prop_val == true ? $parts[1] : $prop_val;
    	  } else {
      	  $class_str .= is_bool($prop_val) && $prop_val == true ? 'is-' . $prop : $prop_val;
    	  }
  	  }
  	  
  	  $val = $class_str;
  	} else {
    	$val = property_exists($target, $val) ? $target->$val : $val;
  	}
    
  	if ($val)
    	$attributes[$attr] = $val;
  }
  
  $attr_str = '';
  
  if ($sort)
    ksort($attributes);
    
  foreach ($attributes as $attr => $val) {
  	$attr_str .= "${attr}=${en}${val}${en}${newline}";
  }
  
  return rtrim(rtrim($attr_str, "\n"));
}

?>