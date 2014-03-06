<?php

/**
 *
 * Function pre_var_dump()
 *
 * Vardumps the passed variable with <pre> tags.
 *
 * Usage:
 * echo pre_var_dump($m_var);
 *
 * @author      Fabian Picone
 * @copyright   Belongs to author
 * @version     1.0 | 2013-08-23 (YYYY-MM-DD)
 *
 * @param       mixed   $m_var    Variable to var dump
 *
 */
function pre_var_dump($m_var) {
	echo '<pre>';
	var_dump($m_var);
	echo '</pre>';
}

/**
 *
 * Function pre_print_r()
 *
 * Prints the passed variable with <pre> tags.
 *
 * Usage:
 * echo pre_print_r($m_var);
 *
 * @author      Fabian Picone
 * @copyright   Belongs to author
 * @version     1.0 | 2013-08-23 (YYYY-MM-DD)
 * @param       mixed   $m_var    Variable to print
 *
 */
function pre_print_r($m_var) {
	echo '<pre>';
	print_r($m_var);
	echo '</pre>';
}

/**
 *
 * Function get_sql_datetime_format()
 *
 * Gets an datetime string for mysql from a timestamp
 *
 * Usage:
 * get_sql_datetime_format();
 *
 * @author      Fabian Picone
 * @copyright   Belongs to author
 * @version     1.0 | 2013-08-23 (YYYY-MM-DD)
 *
 * @param       integer		$i_timestamp    Optional: Timestamp
 * @return		string						Mysql datetime string
 *
 */
function get_sql_datetime_format($i_timestamp = '') {
	if ($i_timestamp == '') {
		$i_timestamp = mktime();
	}
	return date('Y-m-d H:i:s', $i_timestamp);
}

/**
 *
 * Function get_swiss_datetime_format()
 *
 * Returns the actual time or a passed time to a classical swiss date time format.
 *
 * Usage:
 * echo get_swiss_datetime_format();
 *
 * @author      Fabian Picone
 * @copyright   Belongs to author
 * @version     1.0 | 2014-03-06 (YYYY-MM-DD)
 * @param       integer   $i_timestamp    Timestamp to format
 *
 */
function get_swiss_datetime_format($i_timestamp = '') {
	if ($i_timestamp == '') {
		$i_timestamp = mktime();
	}
	return date('d-m-Y H:i:s', $i_timestamp);
}

/**
 *
 * Function url_name()
 *
 * Transforms a string to an url-friendly string
 *
 * Usage:
 * $s_string_url_named     =  url_name($s_name);
 *
 * @author      Fabian Picone
 * @copyright   Belongs to author
 * @version     1.0 | 2013-08-23 (YYYY-MM-DD)
 *
 * @param       string   $s_string    String to transform url-friendly
 * @return      string                Transformet url-friendly string
 *
 */
function url_name($s_string) {
	$a_patterns = array('/^[\s-]+|[\s-]+$/', '/[\W]+/');
	$a_replacements = array('', '_');

	$s_string = strtr(strtolower($s_string), 'äöåÄÖÅ', 'aoaaoa');
	// or you can use:
	// $s_string = strtr(strtolower($s_string), $someTrMapping);

	return preg_replace($a_patterns, $a_replacements, $s_string);
}

// Transform Object it into a multidimensional array using recursion
function object_array($obj) {
	if (!is_array($obj) && !is_object($obj))
		return $obj;
	if (is_object($obj))
		$obj = get_object_vars($obj);
	return array_map(__FUNCTION__, $obj);
}

function get_error_list($m_var) {
	$s_construct = '<ul>';
	foreach ($m_var as $index => $value) {
		$s_construct .= '<li>' . $value . '</li>';
	}
	$s_construct .= '</ul>';

	return $s_construct;
}

function encode_items_utf8($array) {
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$array[$key] = encode_items_utf8($value);
		} else {
			$array[$key] = mb_convert_encoding($value, 'UTF-8');
		}
	}
	return $array;
}

function array_unique_multidimensional($input) {
	$serialized = array_map('serialize', $input);
	$unique = array_unique($serialized);
	return array_intersect_key($input, $unique);
}

function write_log($s_filename, $s_msg, $s_additional = '', $b_make_only_break = false) {

	if (file_exists($s_filename)) {
		$handle = fopen($s_filename, 'a'); 		// 'a'	-	Open for writing only; place the file pointer at the end of the file. If the file does not exist, attempt to create it.
	} else {
		$handle = fopen($s_filename, 'w');		// 'w'	-	Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it.
	}

	if ($b_make_only_break === false) {
		$str = $s_msg;

		if ($s_additional != '') {
			$str .= $s_additional;
		}

		$str .= "\n";
	} else {
		$str = "\n";
	}

	fwrite($handle, $str);
	fclose($handle);

}

function code_timer_start() {
	$d_code_timer_start = '';
	$time = microtime();
	$time = explode(" ", $time);
	$time = $time[1] + $time[0];
	$d_code_timer_start = $time;
	return $d_code_timer_start;
}

function code_timer_end($d_code_timer_start) {
	$time = microtime();
	$time = explode(" ", $time);
	$time = $time[1] + $time[0];
	$finish = $time;
	$totaltime = ($finish - $d_code_timer_start);
	$totaltime = number_format($totaltime, 2, ',', ' ') . ' seconds';
	return $totaltime;
}

function rappen($value) {
	$tmp = (100 * round($value, 2)) % 5;
	if ($tmp == 0) {
		$chf = $value;
	} else if ($tmp <= 2) {
		$chf = ($value - $tmp / 100);
	} else {
		$chf = ($value + (5 - $tmp) / 100);
	}

	$rated = number_format((round(20 * $chf)) / 20, 2);

	return $rated;
}
