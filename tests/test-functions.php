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
		$this->assertEquals( '<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 50%; background: #ff0000;background: -moz-linear-gradient(top, #ff0000 0%, #00ff00 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(100%,#00ff00)); background: -webkit-linear-gradient(top, #ff0000 0%,#00ff00 100%); background: -o-linear-gradient(top, #ff0000 0%,#00ff00 100%); background: -ms-linear-gradient(top,  0%,#00ff00 100%); background: linear-gradient(top, #ff0000 0%,#00ff00 100%); ""><span></span></span></div></div>', $output );
	}
}
