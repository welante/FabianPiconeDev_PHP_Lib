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
function object_array($o_var) {
	if (!is_array($o_var) && !is_object($o_var))
		return $o_var;
	if (is_object($o_var))
		$o_var = get_object_vars($o_var);
	return array_map(__FUNCTION__, $o_var);
}

function get_error_list($a_var) {
	$s_construct = '<ul>';
	foreach ($a_var as $m_index => $m_value) {
		$s_construct .= '<li>' . $m_value . '</li>';
	}
	$s_construct .= '</ul>';

	return $s_construct;
}

function encode_items_utf8($a_var) {
	foreach ($a_var as $m_key => $m_value) {
		if (is_array($m_value)) {
			$a_var[$m_key] = encode_items_utf8($m_value);
		} else {
			$a_var[$m_key] = mb_convert_encoding($m_value, 'UTF-8');
		}
	}
	return $a_var;
}

function array_unique_multidimensional($m_var) {
	$a_serialized = array_map('serialize', $m_var);
	$a_unique = array_unique($a_serialized);
	return array_intersect_key($m_var, $a_unique);
}

function write_log($s_filename, $s_msg, $s_additional = '', $b_make_only_break = false) {

	if (file_exists($s_filename)) {
		$r_handle = fopen($s_filename, 'a'); 		// 'a'	-	Open for writing only; place the file pointer at the end of the file. If the file does not exist, attempt to create it.
	} else {
		$r_handle = fopen($s_filename, 'w');		// 'w'	-	Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it.
	}

	if ($b_make_only_break === false) {
		$s_str = $s_msg;

		if ($s_additional != '') {
			$s_str .= $s_additional;
		}

		$s_str .= "\n";
	} else {
		$s_str = "\n";
	}

	fwrite($r_handle, $s_str);
	fclose($r_handle);

}

function code_timer_start() {
	$d_code_timer_start = 0.0;
	$m_time = microtime();
	$a_time = explode(' ', $m_time);
	$d_code_timer_start = $a_time[1] + $a_time[0];
	return $d_code_timer_start;
}

function code_timer_end($d_code_timer_start) {
	$m_time = microtime();
	$a_time = explode(' ', $m_time);
	$d_finish = $a_time[1] + $a_time[0];;
	$d_totaltime = ($d_finish - $d_code_timer_start);
	$d_totaltime = number_format($d_totaltime, 2, ',', ' ') . ' seconds';
	return $d_totaltime;
}

// Round double to x,05 swiss raps
function round_swiss($d_val) {
	$t_precalc = (100 * round($d_val, 2)) % 5;
	if($t_precalc == 0) {
		$d_chf = $d_val;
	} else if($t_precalc <= 2) {
		$d_chf = ($d_val - $t_precalc / 100);
	} else {
		$d_chf = ($d_val + (5 - $t_precalc) / 100);
	}

	$s_formatted = number_format((round(20 * $d_chf)) / 20, 2);

	return $s_formatted;
}
