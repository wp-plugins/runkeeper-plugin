<?php
/**
 * @package runkeeper
 * @author Peter Smith
 * @version 1.0.0
 */
/*
Plugin Name: Runkeeper
Plugin URI: http://sandjam.co.uk
Description: inserts a runkeeper preview into a post when a custom field called runkeeper is found
Author: Peter Smith
Version: 1.0.0
Author URI: http://sandjam.co.uk
*/

$rk_url='';

function runkeeper_post($post) {
	global $rk_url;
	$url = get_post_meta($post->ID, 'runkeeper', true);
	if ($url!='') {
		$rk_url = $url;
	}
}

function runkeeper_content($str) {
	global $rk_url;
	$html = '';
	
	if ($rk_url!='') {
		$html .= '<div id="runkeeper" title="'.$rk_url.'"></div>';	
	}
	
	return $str.$html;
}

add_filter('the_post', 'runkeeper_post');
add_filter('the_content', 'runkeeper_content');
add_action('wp_head', 'runkeeper_js');


function runkeeper_js() {
	echo('<link rel="stylesheet" type="text/css" href="'.get_bloginfo('wpurl').'/wp-content/plugins/runkeeper/runkeeper.css" media="screen" />');
	echo('<script type="text/javascript" src="'.get_bloginfo('wpurl').'/wp-content/plugins/runkeeper/runkeeper.js"></script>');
}

?>
