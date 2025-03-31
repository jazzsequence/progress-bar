<?php

use PHPUnit\Framework\TestCase;

class WppbTest extends TestCase {

  public function test_progress_number() {
    $output = do_shortcode('[wppb progress=50]');
    $this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 50%;"><span></span></span></div></div>', $output);
  }

  public function test_progress_fraction() {
    $output = do_shortcode('[wppb progress="25/100"]');
	$progress = wppb_check_pos( '25/100' );
    $this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: '. $progress[1] . ';"><span></span></span></div></div>', $output);
  }

  public function test_progress_dollars() {
    $output = do_shortcode('[wppb progress="$45/$50"]');
	$progress = wppb_check_pos( '$45/$50' );
    $this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: ' . $progress[1] . ';"><span></span></span></div></div>', $output);
  }

  public function test_progress_over() {
    $output = do_shortcode('[wppb progress=110]');
    $this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 110%;"><span></span></span></div></div>', $output);
  }

  public function test_progress_exceeded() {
    $output = do_shortcode('[wppb progress=150/100]');
    $this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 150%;"><span></span></span></div></div>', $output);
  }

  public function test_progress_fundraising() {
    $output = do_shortcode('[wppb progress=$125/100]');
    $this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 125%;"><span></span></span></div></div>', $output);
  }

  public function test_option_candystripe() {
    $output = do_shortcode('[wppb progress=50 option=candystripe]');
    $this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span class="candystripe" style="width: 50%;"><span></span></span></div></div>', $output);
  }

  public function test_option_animated_candystripe() {
    $output = do_shortcode('[wppb progress=50 option="animated-candystripe green"]');
    $this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span class="animated-candystripe green" style="width: 50%;"><span></span></span></div></div>', $output);
  }

  public function test_option_red() {
    $output = do_shortcode('[wppb progress=50 option=red]');
    $this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span class="red" style="width: 50%;"><span></span></span></div></div>', $output);
	}

	public function test_location() {
		// location inside
		$output = do_shortcode('[wppb progress=50 location=inside]');
		$this->assertEquals('<div class="wppb-wrapper inside"><div class="inside">50 %</div><div class="wppb-progress fixed"><span style="width: 50%;"><span></span></span></div></div>', $output);

		// location after
		$output = do_shortcode('[wppb progress=50 location=after]');
		$this->assertEquals('<div class="wppb-wrapper after"><div class="after">50 %</div><div class="wppb-progress fixed"><span style="width: 50%;"><span></span></span></div></div>', $output);

		// location inside candystripe
		$output = do_shortcode('[wppb progress=50 location=inside option="red candystripe"]');
		$this->assertEquals('<div class="wppb-wrapper inside"><div class="inside">50 %</div><div class="wppb-progress fixed"><span class="red candystripe" style="width: 50%;"><span></span></span></div></div>', $output);

		// location after text
		$output = do_shortcode('[wppb progress=50 location=after text="Hello World"]');
		$this->assertEquals('<div class="wppb-wrapper after"><div class="after">Hello World</div><div class="wppb-progress fixed"><span style="width: 50%;"><span></span></span></div></div>', $output);

	}

	public function test_text() {
		// inside
		$output = do_shortcode('[wppb progress=50 text="Hello World"]');
		$this->assertEquals('<div class="wppb-wrapper inside"><div class="inside">Hello World</div><div class="wppb-progress fixed"><span style="width: 50%;"><span></span></span></div></div>', $output);

		// after
		$output = do_shortcode('[wppb progress=50 text="Hello World" location=after]');
		$this->assertEquals('<div class="wppb-wrapper after"><div class="after">Hello World</div><div class="wppb-progress fixed"><span style="width: 50%;"><span></span></span></div></div>', $output);

		// Shortcode with XSS vulnerability exposed.
		$output = do_shortcode('[wppb progress=50 location=inside text="<script>alert("XSS");</script>"]');
		$this->assertEquals('<div class="wppb-wrapper inside"><div class="inside">50 %</div><div class="wppb-progress fixed"><span style="width: 50%;"><span></span></span></div></div>', $output);

		// Shortcode with XSS vulnerability exposed after the progress bar.
		$output = do_shortcode('[wppb progress=50 location=after text="<script>alert("XSS");</script>"]');
		$this->assertEquals('<div class="wppb-wrapper after"><div class="after">50 %</div><div class="wppb-progress fixed"><span style="width: 50%;"><span></span></span></div></div>', $output);
	}

	public function test_fullwidth() {
		// using true
		$output = do_shortcode('[wppb progress=50 fullwidth=true]');
		$this->assertEquals('<div class="wppb-wrapper  full"><div class="wppb-progress full"><span style="width: 50%;"><span></span></span></div></div>', $output);

		// using "yes"
		$output = do_shortcode('[wppb progress=50 fullwidth=yes]');
		$this->assertEquals('<div class="wppb-wrapper  full"><div class="wppb-progress full"><span style="width: 50%;"><span></span></span></div></div>', $output);
	}

	public function test_color() {
		// color
		$output = do_shortcode('[wppb progress=50 color=ff0000]');
		$this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 50%; background: #ff0000;"><span></span></span></div></div>', $output);

		// endcolor
		$output = do_shortcode('[wppb progress=50 color=ff0000 endcolor=00ff00]');
		$this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 50%; background: #ff0000;background: -moz-linear-gradient(top, #ff0000 0%, #00ff00 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(100%,#00ff00)); background: -webkit-linear-gradient(top, #ff0000 0%,#00ff00 100%); background: -o-linear-gradient(top, #ff0000 0%,#00ff00 100%); background: -ms-linear-gradient(top, #ff0000 0%,#00ff00 100%); background: linear-gradient(top, #ff0000 0%,#00ff00 100%); ""><span></span></span></div></div>', $output);

		// rgb values
		$output = do_shortcode('[wppb progress=50 color=rgb(255,0,0) endcolor=rgb(0,255,0)]');
		$this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 50%; background: rgb(255,0,0);background: -moz-linear-gradient(top, rgb(255,0,0) 0%, rgb(0,255,0) 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgb(255,0,0)), color-stop(100%,rgb(0,255,0))); background: -webkit-linear-gradient(top, rgb(255,0,0) 0%,rgb(0,255,0) 100%); background: -o-linear-gradient(top, rgb(255,0,0) 0%,rgb(0,255,0) 100%); background: -ms-linear-gradient(top, rgb(255,0,0) 0%,rgb(0,255,0) 100%); background: linear-gradient(top, rgb(255,0,0) 0%,rgb(0,255,0) 100%); ""><span></span></span></div></div>', $output);

		// using color keyword
		$output = do_shortcode('[wppb progress=50 color=lightYellow]');
		$this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 50%; background: lightYellow;"><span></span></span></div></div>', $output);
	}

	public function test_gradient() {
		// positive gradient
		$output = do_shortcode('[wppb progress=50 color=ff0000 gradient=.1]');
		$this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 50%; background: #ff0000;background: -moz-linear-gradient(top, #ff0000 0%, #ffe6e6 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(100%,#ffe6e6)); background: -webkit-linear-gradient(top, #ff0000 0%,#ffe6e6 100%); background: -o-linear-gradient(top, #ff0000 0%,#ffe6e6 100%); background: -ms-linear-gradient(top, #ff0000 0%,#ffe6e6 100%); background: linear-gradient(top, #ff0000 0%,#ffe6e6 100%); ""><span></span></span></div></div>', $output);

		// negative gradient
		$output = do_shortcode('[wppb progress=50 color=ff0000 gradient=-.1]');
		$this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 50%; background: #ff0000;background: -moz-linear-gradient(top, #ff0000 0%, #1a0000 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(100%,#1a0000)); background: -webkit-linear-gradient(top, #ff0000 0%,#1a0000 100%); background: -o-linear-gradient(top, #ff0000 0%,#1a0000 100%); background: -ms-linear-gradient(top, #ff0000 0%,#1a0000 100%); background: linear-gradient(top, #ff0000 0%,#1a0000 100%); ""><span></span></span></div></div>', $output);

		// broken color + gradient
		$output = do_shortcode('[wppb progress=50 color=rgb(22,18,99 gradient=.1 ]');
		$this->assertEquals('<div class="wppb-wrapper "><div class="wppb-progress fixed"><span style="width: 50%; background: rgb(22,18,99;background: -moz-linear-gradient(top, rgb(22,18,99 0%, #e8e8f0 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgb(22,18,99), color-stop(100%,#e8e8f0)); background: -webkit-linear-gradient(top, rgb(22,18,99 0%,#e8e8f0 100%); background: -o-linear-gradient(top, rgb(22,18,99 0%,#e8e8f0 100%); background: -ms-linear-gradient(top, rgb(22,18,99 0%,#e8e8f0 100%); background: linear-gradient(top, rgb(22,18,99 0%,#e8e8f0 100%); ""><span></span></span></div></div>', $output);
	}


}
