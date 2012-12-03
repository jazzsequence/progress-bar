<?php
/*
Plugin Name: Progress Bar
Plugin URI: https://github.com/jazzsequence/progress-bar
Description: a simple progress bar shortcode that can be styled with CSS
Version: 1.1.0
Author: Chris Reynolds
Author URI: http://museumthemes.com
License: GPL3
*/

/*
	Progress Bar
    Copyright (C) 2012 | Chris Reynolds (chris@arcanepalette.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    http://www.opensource.org/licenses/gpl-3.0.html
*/

/**
 * wppb_init
 * loads the css and javascript
 * @author Chris Reynolds
 * @since 0.1
 */

function wppb_init() {
	$wppb_path = plugin_dir_url( __FILE__ );
	if ( !is_admin() ) { // don't load this if we're in the backend
		wp_register_style( 'wppb_css', $wppb_path . 'css/wppb.css' );
		wp_enqueue_style( 'wppb_css' );
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'wppb_animate', $wppb_path . 'js/wppb_animate.js', 'jquery' );
		wp_enqueue_script ( 'wppb_animate' );
	}
}
add_action( 'init', 'wppb_init' );

/**
 * Progress Bar
 * simple shortcode that displays a progress bar
 * @author Chris Reynolds
 * @since 0.1
 * @param string $progress REQUIRED displays the actual progress bar in % or in x/y | usage [wppb progress=50] or [wppb progress=500/1000]
 * @param string $option OPTIONAL calls various options. These can be user-input (uses CSS classes, so anything a user adds to their CSS could potentially be used as an option) or any of the pre-defined options/styles. Included options (as of 1.0.1): candystripes, animated-candystripes, red | usage [wppb progress=50 option="red candystripes"] [wppb progress=50 option=animated-candystripes]
 * @param string $percent OPTIONAL displays the percentage either on the bar itself, or after the progress bar, depending on which parameter is used. Options are 'after' and 'inside'. | usage [wppb progress=50 percent=after]
 */

function wppb( $atts ) {
	extract( shortcode_atts( array(
		'progress' => '',		// the progress in % or x/y
		'option' => '',			// what options you want to use (candystripes, animated-candystripes, red)
		'percent' => '',		// whether you want to display the percentage and where you want that to go (after, inside)
		'fullwidth' => ''		// determines if the progress bar should be full width or not
		), $atts ) );
	$pos = strpos($progress, '/');
	if($pos===false) {
		$width = $progress . "%";
		$progress = $progress . " %";
	} else {
		$xofy = explode('/',$progress);
		if (!$xofy[1])
			$xofy[1] = 100;
		$percentage = $xofy[0] / $xofy[1] * 100;
		$width = $percentage . "%";
		$progress = $xofy[0] . " / " . $xofy[1];
	}
	// here's the html output of the progress bar
	$wppb_output	= "<div class=\"wppb-wrapper {$percent}"; // adding $percent to the wrapper class, so I can set a width for the wrapper based on whether it's using div.wppb-wrapper.after or div.wppb-wrapper.inside or just div.wppb-wrapper
	if ($atts['fullwidth']) {
		$wppb_output .= " full";
	}
	$wppb_output .= "\">";
	if ($atts['percent']) { // if $percent is not empty, add this
		$wppb_output .= "<div class=\"{$percent}\">{$progress}</div>";
	}
	$wppb_output 	.= 	"<div class=\"wppb-progress";
	if ($atts['fullwidth']) {
		$wppb_output .= " full";
	}
	$wppb_output 	.= "\">";
	$wppb_output 	.=	"	<span style=\"width: {$width};\" class=\"{$option}\"><span></span></span>";
	$wppb_output	.=	"</div>";
	$wppb_output	.= "</div>";
	// now return the progress bar
	return $wppb_output;
}
add_shortcode('wppb','wppb');

?>