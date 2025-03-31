<?php
use PHPUnit\Framework\TestCase;

class WppbTestFunctions extends TestCase {
	// wppb_brightness
	public function test_wppb_brightness() {
		$output = wppb_brightness( '#ffffff', 0 );
		$this->assertEquals( '#000000', $output );

		$output = wppb_brightness( '#ffffff', 1 );
		$this->assertEquals( '#ffffff', $output );

		$output = wppb_brightness( '#ff0000', 0.5 );
		$this->assertEquals( '#ff8080', $output );

		$output = wppb_brightness( '#ff0000', -0.5 );
		$this->assertEquals( '#800000', $output );
	}

	// wppb_check_pos
	public function test_wppb_check_pos() {
		$output = wppb_check_pos( '50' );
		$this->assertEquals( [ '50 %', '50%' ], $output );

		$output = wppb_check_pos( '50/100' );
		$this->assertEquals( [ '50 / 100', '50%' ], $output );

		$output = wppb_check_pos( '50 / 100' );
		$this->assertEquals( [ '50 / 100', '50%' ], $output );

		$output = wppb_check_pos( '68/128' );
		$this->assertEquals( [ '68 / 128', '53.125%' ], $output );

		$output = wppb_check_pos( '88/512' );
		$this->assertEquals( [ '88 / 512', '17.1875%' ], $output );

		$output = wppb_check_pos( '$88/$5000' );
		$this->assertEquals( [ '$88 / $5,000', '1.76%' ], $output );
	}

	// wppb_get_progress_bar
	public function test_wppb_get_progress_bar() {
		// [wppb progress=50]
		$output = wppb_get_progress_bar( false, false, '50', false, '50%', false, false, false, false );
		$this->assertEquals( '<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 50%;"><span></span></span></div></div>', $output );

		// [wppb progress=50 option="animated-candystripe green"]
		$output = wppb_get_progress_bar( false, false, '50', 'animated-candystripe green', '50%', false, false, false, false );
		$this->assertEquals( '<div class="wppb-wrapper "><div class="wppb-progress fixed"><span class="animated-candystripe green" style="width: 50%;"><span></span></span></div></div>', $output );

		// [wppb progress=50 text="Hello World"]
		$output = wppb_get_progress_bar( false, 'Hello World', '50', false, '50%', false, false, false, false );
		$this->assertEquals( '<div class="wppb-wrapper "><div class="inside">Hello World</div><div class="wppb-progress fixed"><span style="width: 50%;"><span></span></span></div></div>', $output );

		// [wppb progress=50 color=ff0000 endcolor=00ff00]
		$output = wppb_get_progress_bar( false, false, '50', false, '50%', false, '#ff0000', false, '#00ff00' );
		$this->assertEquals( '<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 50%; background: #ff0000;background: -moz-linear-gradient(top, #ff0000 0%, #00ff00 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(100%,#00ff00)); background: -webkit-linear-gradient(top, #ff0000 0%,#00ff00 100%); background: -o-linear-gradient(top, #ff0000 0%,#00ff00 100%); background: -ms-linear-gradient(top, #ff0000 0%,#00ff00 100%); background: linear-gradient(top, #ff0000 0%,#00ff00 100%); ""><span></span></span></div></div>', $output );

		// [wppb progress=0]
		$output = wppb_get_progress_bar( false, false, '0' );
		$this->assertEquals( '<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 0%;"><span></span></span></div></div>', $output );

		// Test the progress bar with a null value for progress.
		$output = wppb_get_progress_bar( false, false, null );
		$this->assertEquals( '<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 0%;"><span></span></span></div></div>', $output );

		// Test the progress bar with an invalid value for the progress.
		$output = wppb_get_progress_bar( false, false, 'invalid' );
		$this->assertEquals( '<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 0%;"><span></span></span></div></div>', $output );

		// Test the progress bar with a value for progress but 0% width.
		$output = wppb_get_progress_bar( false, false, '50', false, '0%' );
		$this->assertEquals( '<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 0%;"><span></span></span></div></div>', $output );

		// Test the progress bar returning an exception when the progress and width values are invalid.
		$output = wppb_get_progress_bar();
		$this->assertTrue( $output instanceof WP_Error );

		// Test the progress bar with an XSS vulnerability exposed.
		$output = wppb_get_progress_bar( false, '<script>alert("XSS");</script>', '50', false, '50%', false, false, false, false );
		$this->assertEquals( '<div class="wppb-wrapper "><div class="inside">&lt;script&gt;alert(&quot;XSS&quot;);&lt;/script&gt;</div><div class="wppb-progress fixed"><span style="width: 50%;"><span></span></span></div></div>', $output );

		// Test the progress bar with an XSS vulnerability exposed in the progress value.
		$output = wppb_get_progress_bar( false, false, '<script>alert("XSS");</script>', false, '50%', false, false, false, false );
		$this->assertEquals( '<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 50%;"><span></span></span></div></div>', $output );

		// Test the progress bar with XSS vulnerabilities exposed in all possible parameters.
		$output = wppb_get_progress_bar( '<script>alert("XSS");</script>', '<script>alert("XSS");</script>', '<script>alert("XSS");</script>', '<script>alert("XSS");</script>', '<script>alert("XSS");</script>', '<script>alert("XSS");</script>', '<script>alert("XSS");</script>', '<script>alert("XSS");</script>', '<script>alert("XSS");</script>' );
		$this->assertEquals( $output, '<div class="wppb-wrapper ltscriptgtalertquotXSSquotltscriptgt full"><div class="ltscriptgtalertquotXSSquotltscriptgt">&lt;script&gt;alert(&quot;XSS&quot;);&lt;/script&gt;</div><div class="wppb-progress full"><span class="scriptalertXSSscript" style="width: 0%;"><span></span></span></div></div>' );

		// Test XSS on everything except progress and width.
		$output = wppb_get_progress_bar(
			'<script>alert("XSS");</script>', // Location
			'<script>alert("XSS");</script>', // Text
			'50', // Progress
			'<script>alert("XSS");</script>', // Option
			'50%', // Width
			'<script>alert("XSS");</script>', // Fullwidth
			'<script>alert("XSS");</script>', // Color
			'<script>alert("XSS");</script>', // Gradient
			'<script>alert("XSS");</script>' // Endcolor
		);
		$this->assertEquals( '<div class="wppb-wrapper ltscriptgtalertquotXSSquotltscriptgt full"><div class="ltscriptgtalertquotXSSquotltscriptgt">&lt;script&gt;alert(&quot;XSS&quot;);&lt;/script&gt;</div><div class="wppb-progress full"><span class="scriptalertXSSscript" style="width: 50%;"><span></span></span></div></div>', $output );
		// Test XSS on everything with progress and width equalling a null value.
		$output = wppb_get_progress_bar(
			'<script>alert("XSS");</script>', // Location
			'<script>alert("XSS");</script>', // Text
			null, // Progress
			'<script>alert("XSS");</script>', // Option
			null, // Width
			'<script>alert("XSS");</script>', // Fullwidth
			'<script>alert("XSS");</script>', // Color
			'<script>alert("XSS");</script>', // Gradient
			'<script>alert("XSS");</script>' // Endcolor
		);
		$this->assertEquals( '<div class="wppb-wrapper ltscriptgtalertquotXSSquotltscriptgt full"><div class="ltscriptgtalertquotXSSquotltscriptgt">&lt;script&gt;alert(&quot;XSS&quot;);&lt;/script&gt;</div><div class="wppb-progress full"><span class="scriptalertXSSscript" style="width: 0%;"><span></span></span></div></div>', $output );
	}

	// wppb_sanitize_color
	public function test_wppb_sanitize_color() {
		// Test a valid hex color.
		$output = wppb_sanitize_color( 'ff0000' );
		$this->assertEquals( '#ff0000', $output );

		// Test a valid hex color with a hash.
		$output = wppb_sanitize_color( '#ff0000' );
		$this->assertEquals( '#ff0000', $output );

		// Test a valid hex color with a hash and a leading space.
		$output = wppb_sanitize_color( ' #ff0000' );
		$this->assertEquals( '#ff0000', $output );

		// Test a valid hex color with a hash and a trailing space.
		$output = wppb_sanitize_color( '#ff0000 ' );
		$this->assertEquals( '#ff0000', $output );

		// Test a valid hex color with a hash and a leading and trailing space.
		$output = wppb_sanitize_color( ' #ff0000 ' );
		$this->assertEquals( '#ff0000', $output );

		// Test a valid hex color with a hash and a leading and trailing space and a leading zero.
		$output = wppb_sanitize_color( ' #0ff0000 ' );
		$this->assertEquals( '', $output );

		// Test a valid rgb color.
		$output = wppb_sanitize_color( 'rgb(255, 0, 0)' );
		$this->assertEquals( 'rgb(255, 0, 0)', $output );

		// Test a valid rgb color with a opacity value.
		$output = wppb_sanitize_color( 'rgba(255, 0, 0, 0.5)' );
		$this->assertEquals( 'rgba(255, 0, 0, 0.5)', $output );

		// Test a valid rgb color with a leading space.
		$output = wppb_sanitize_color( ' rgb(255, 0, 0)' );
		$this->assertEquals( 'rgb(255, 0, 0)', $output );

		// Test a valid rgb color with a trailing space.
		$output = wppb_sanitize_color( 'rgb(255, 0, 0) ' );
		$this->assertEquals( 'rgb(255, 0, 0)', $output );

		// Test a valid rgb color with a leading and trailing space.
		$output = wppb_sanitize_color( ' rgb(255, 0, 0) ' );
		$this->assertEquals( 'rgb(255, 0, 0)', $output );

		// Test a valid CSS text color.
		$output = wppb_sanitize_color( 'red' );
		$this->assertEquals( 'red', $output );

		// Test an invalid color.
		$output = wppb_sanitize_color( 'invalid' );
		$this->assertEquals( '', $output );

		// Test an XSS attempt.
		$output = wppb_sanitize_color( '<script>alert("XSS");</script>' );
		$this->assertEquals( '', $output );

		// Test an empty value.
		$output = wppb_sanitize_color( '' );
		$this->assertEquals( '', $output );

		// Test no parameter at all.
		$output = wppb_sanitize_color();
		$this->assertEquals( '', $output );
	}

	// wppb_sanitize_option
	public function test_wppb_sanitize_option() {
		// Test a valid option. Currently this is any string but in the future we might compare against an array of supported options.
		$output = wppb_sanitize_option( 'candystripes' );
		$this->assertEquals( 'candystripes', $output );

		// Test an invalid option.
		$output = wppb_sanitize_option( 'invalid' );
		$this->assertEquals( 'invalid', $output );

		// Test several optiosn.
		$output = wppb_sanitize_option( 'candystripes invalid' );
		$this->assertEquals( 'candystripes invalid', $output );

		// Test an XSS attempt.
		$output = wppb_sanitize_option( '<script>alert("XSS");</script>' );
		$this->assertEquals( 'scriptalertXSSscript', $output );

		// Test multiple valid options with a XSS attempt.
		$output = wppb_sanitize_option( 'candystripes <script>alert("XSS");</script>' );
		$this->assertEquals( 'candystripes scriptalertXSSscript', $output );

		// Test multiple XSS attempts.
		$output = wppb_sanitize_option( '<script>alert("XSS");</script> <script>alert("XSS");</script>' );
		$this->assertEquals( 'scriptalertXSSscript scriptalertXSSscript', $output );

	}
}
