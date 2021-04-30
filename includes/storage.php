<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('filmax_storage_get')) {
	function filmax_storage_get($var_name, $default='') {
		global $FILMAX_STORAGE;
		return isset($FILMAX_STORAGE[$var_name]) ? $FILMAX_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('filmax_storage_set')) {
	function filmax_storage_set($var_name, $value) {
		global $FILMAX_STORAGE;
		$FILMAX_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('filmax_storage_empty')) {
	function filmax_storage_empty($var_name, $key='', $key2='') {
		global $FILMAX_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($FILMAX_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($FILMAX_STORAGE[$var_name][$key]);
		else
			return empty($FILMAX_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('filmax_storage_isset')) {
	function filmax_storage_isset($var_name, $key='', $key2='') {
		global $FILMAX_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($FILMAX_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($FILMAX_STORAGE[$var_name][$key]);
		else
			return isset($FILMAX_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('filmax_storage_inc')) {
	function filmax_storage_inc($var_name, $value=1) {
		global $FILMAX_STORAGE;
		if (empty($FILMAX_STORAGE[$var_name])) $FILMAX_STORAGE[$var_name] = 0;
		$FILMAX_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('filmax_storage_concat')) {
	function filmax_storage_concat($var_name, $value) {
		global $FILMAX_STORAGE;
		if (empty($FILMAX_STORAGE[$var_name])) $FILMAX_STORAGE[$var_name] = '';
		$FILMAX_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('filmax_storage_get_array')) {
	function filmax_storage_get_array($var_name, $key, $key2='', $default='') {
		global $FILMAX_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($FILMAX_STORAGE[$var_name][$key]) ? $FILMAX_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($FILMAX_STORAGE[$var_name][$key][$key2]) ? $FILMAX_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('filmax_storage_set_array')) {
	function filmax_storage_set_array($var_name, $key, $value) {
		global $FILMAX_STORAGE;
		if (!isset($FILMAX_STORAGE[$var_name])) $FILMAX_STORAGE[$var_name] = array();
		if ($key==='')
			$FILMAX_STORAGE[$var_name][] = $value;
		else
			$FILMAX_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('filmax_storage_set_array2')) {
	function filmax_storage_set_array2($var_name, $key, $key2, $value) {
		global $FILMAX_STORAGE;
		if (!isset($FILMAX_STORAGE[$var_name])) $FILMAX_STORAGE[$var_name] = array();
		if (!isset($FILMAX_STORAGE[$var_name][$key])) $FILMAX_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$FILMAX_STORAGE[$var_name][$key][] = $value;
		else
			$FILMAX_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('filmax_storage_merge_array')) {
	function filmax_storage_merge_array($var_name, $key, $value) {
		global $FILMAX_STORAGE;
		if (!isset($FILMAX_STORAGE[$var_name])) $FILMAX_STORAGE[$var_name] = array();
		if ($key==='')
			$FILMAX_STORAGE[$var_name] = array_merge($FILMAX_STORAGE[$var_name], $value);
		else
			$FILMAX_STORAGE[$var_name][$key] = array_merge($FILMAX_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('filmax_storage_set_array_after')) {
	function filmax_storage_set_array_after($var_name, $after, $key, $value='') {
		global $FILMAX_STORAGE;
		if (!isset($FILMAX_STORAGE[$var_name])) $FILMAX_STORAGE[$var_name] = array();
		if (is_array($key))
			filmax_array_insert_after($FILMAX_STORAGE[$var_name], $after, $key);
		else
			filmax_array_insert_after($FILMAX_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('filmax_storage_set_array_before')) {
	function filmax_storage_set_array_before($var_name, $before, $key, $value='') {
		global $FILMAX_STORAGE;
		if (!isset($FILMAX_STORAGE[$var_name])) $FILMAX_STORAGE[$var_name] = array();
		if (is_array($key))
			filmax_array_insert_before($FILMAX_STORAGE[$var_name], $before, $key);
		else
			filmax_array_insert_before($FILMAX_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('filmax_storage_push_array')) {
	function filmax_storage_push_array($var_name, $key, $value) {
		global $FILMAX_STORAGE;
		if (!isset($FILMAX_STORAGE[$var_name])) $FILMAX_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($FILMAX_STORAGE[$var_name], $value);
		else {
			if (!isset($FILMAX_STORAGE[$var_name][$key])) $FILMAX_STORAGE[$var_name][$key] = array();
			array_push($FILMAX_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('filmax_storage_pop_array')) {
	function filmax_storage_pop_array($var_name, $key='', $defa='') {
		global $FILMAX_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($FILMAX_STORAGE[$var_name]) && is_array($FILMAX_STORAGE[$var_name]) && count($FILMAX_STORAGE[$var_name]) > 0) 
				$rez = array_pop($FILMAX_STORAGE[$var_name]);
		} else {
			if (isset($FILMAX_STORAGE[$var_name][$key]) && is_array($FILMAX_STORAGE[$var_name][$key]) && count($FILMAX_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($FILMAX_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('filmax_storage_inc_array')) {
	function filmax_storage_inc_array($var_name, $key, $value=1) {
		global $FILMAX_STORAGE;
		if (!isset($FILMAX_STORAGE[$var_name])) $FILMAX_STORAGE[$var_name] = array();
		if (empty($FILMAX_STORAGE[$var_name][$key])) $FILMAX_STORAGE[$var_name][$key] = 0;
		$FILMAX_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('filmax_storage_concat_array')) {
	function filmax_storage_concat_array($var_name, $key, $value) {
		global $FILMAX_STORAGE;
		if (!isset($FILMAX_STORAGE[$var_name])) $FILMAX_STORAGE[$var_name] = array();
		if (empty($FILMAX_STORAGE[$var_name][$key])) $FILMAX_STORAGE[$var_name][$key] = '';
		$FILMAX_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('filmax_storage_call_obj_method')) {
	function filmax_storage_call_obj_method($var_name, $method, $param=null) {
		global $FILMAX_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($FILMAX_STORAGE[$var_name]) ? $FILMAX_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($FILMAX_STORAGE[$var_name]) ? $FILMAX_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('filmax_storage_get_obj_property')) {
	function filmax_storage_get_obj_property($var_name, $prop, $default='') {
		global $FILMAX_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($FILMAX_STORAGE[$var_name]->$prop) ? $FILMAX_STORAGE[$var_name]->$prop : $default;
	}
}
?>