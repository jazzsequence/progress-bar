# Progress Bar

![GitHub release (latest SemVer)](https://img.shields.io/github/v/release/jazzsequence/progress-bar) [![Test Status](https://img.shields.io/github/actions/workflow/status/jazzsequence/progress-bar/test.yml?label=Test%20Status)](https://github.com/jazzsequence/progress-bar/actions/workflows/test.yml) [![Lint Status](https://img.shields.io/github/actions/workflow/status/jazzsequence/progress-bar/lint.yml?label=Lint)](https://github.com/jazzsequence/progress-bar/actions/workflows/lint.yml) [![Vulnerability Scan](https://img.shields.io/github/actions/workflow/status/jazzsequence/progress-bar/vuln.yml?label=Vulnerability%20Scan)](https://github.com/jazzsequence/progress-bar/actions/workflows/vuln.yml)

[Donate to this plugin!](https://paypal.me/jazzsequence)

A simple progress bar shortcode that can be styled with CSS

## Description

This plugin does one thing: it creates a simple (but nice-looking) CSS3 progress bar that you can style with your own CSS and use wherever you want with a simple shortcode. Now with support for custom colors and gradients.

To add a progress bar to a post or a page, simply use this shortcode:

`[wppb progress=50]`

where "50" in the example above is a progress bar that is 50% complete.  Simple, lightweight, cross-browser compatible (degrades nicely for browsers that don\'t support CSS3).

For more examples and full descriptions of all the available options, click on the [options tab](http://wordpress.org/extend/plugins/progress-bar/other_notes/).

For demos of each of the options, go here: https://progressbar.jazzsequence.com


## Options

The following is a list of all the available shortcode options. These can be used in any combination. The only **required** parameter is  **progress**. All parameters are case-sensitive (e.g. "progress" will work but "Progress" will not).

### `progress` (required)

This determines how full the progress bar will be. Progress can be in 2 forms, either a number (0-100), in which case it will be interpreted as a percentage, or as a fraction (e.g. 25/100). Since 1.1, you can also use dollar signs (e.g. $63/$180), for example to create a fundraising progress bar. If using dollar signs, you only *need* to add a dollar sign to one or the other of the two values (e.g. 63/$180 or $63/180) -- the plugin will output either option the same ($63/$180). Your progress can go over, too (e.g. 150/100 or 123%), but your mileage may vary for the display. It's not recommended to use this with the **fullwidth** option, for example, because your progress will spill outside of your main body container.

*Examples*

`[wppb progress=50]` A progress bar that is 50% complete

`[wppb progress="50/100"]` A progress bar that is 50/100 complete

`[wppb progress="$45/$50"]` A dollar value progress bar that is $45/$50 complete

`[wppb progress=110]` A progress bar that has gone over 100%

`[wppb progress=150/100]` A progress bar that has exceeded its goal

`[wppb progress=$125/100]` A fundraising-style progress bar that has exceeded the goal

### `option`

This adds one of several supported options to the progress bar. For those that know CSS, new "options" can be added simply by adding new styles to your style.css. See the [Frequently Asked Questions](http://wordpress.org/support/plugin/progress-bar/faq/) page for more information on creating new CSS classes. Options can be combined by wrapping them in quotes in the shortcode. The progress bar will naturally have an inner shadow applied to it. The `flat` option was added to remove the shadow and display a "flat" color, best when used in conjunction with the `color` parameter.

Supported values: candystripe, animated-candystripe, red, orange, green, yellow, flat

*Examples*

`[wppb progress=50 option=red]` Displays a red progress bar

`[wppb progress=50 option="animated-candystripe green"]` Displays a green progress bar with an animated candystripe

`[wppb progress=50 option="candystripe orange"]` Displays an orange progress bar with a static candystripe

`[wppb progress=50 option=candystripe]` Displays a default progress bar (blue) with a static candystripe

`[wppb progress=50 option=flat color=red]` Displays a red progress bar with no inner shadow or gradient

`[wppb progress=50 option="flat candystripe" color=gray]` Displays a gray progress bar with no inner shadow or gradient and a static candystripe

### `location`

Displays the percentage, text or fraction either inside or outside the progress bar.
*Note:* It is *not* recommended to use `location=after` if you are displaying a progress bar that exceeds its goal.

Supported values: inside, after

*Examples*

`[wppb progress=50 option=red location=after]` Displays a red progress bar with the progress displayed to the right of the progress bar.

`[wppb progress=50 option="red candystripe" location=inside]` Displays a red progress bar with a static candystripe and the progress displayed inside the progress bar.

`[wppb progress=85 location=after text="foo"]` Displays a progress bar with the text "foo" displayed after the progress bar.

### `text`

Displays arbitrary text instead of the progress bar. Can be used with the **location** parameter to define whether the text appears inside or outside the progress bar (default is inside). *Must* be used inside double quotes. HTML code is stripped from the final output.

Supported values: any plain text string

*Examples*

`[wppb progress=75 text="My awesome text"]` Displays "My awesome text" inside a 75% progress bar.

`[wppb progress=85 location=after text="foo"]` Displays "foo" after an 85% progress bar

`[wppb progress=85 location=inside text="hello!"]` Displays "hello!" inside an 85% progress bar (note, default location for text is inside, so it isn't required to specify "inside").

### `fullwidth`

Makes the progress bar take up 100% of the container. (Good for responsive layouts.) *Not* recommended for progress bars that exceed their goal.
*Note:* `fullwidth` will actually take any value. If `fullwidth` is present at all, it will display a progress bar that is 100% wide. For example `fullwidth=foo` would output the same as `fullwidth=true`.

Supported value: true

*Examples*

`[wppb progress=50 fullwidth=true]` Displays a full-width (responsive) progress bar

`[wppb progress=50 fullwidth=foo]` Identical to the above progress bar

### `color`

Defines a color for the progress bar. This is useful for creating new progress bar colors on the fly without having to edit CSS. Cannot be used in conjunction with any of the pre-existing color options (red, yellow, orange or green).

Supported values: any hexadecimal color value, any rgb/rgba color value, any css-supported [color name](http://www.w3schools.com/cssref/css_colornames.asp)

*Examples*

`[wppb progress=50 color=rgb(123,50,87)]`

`[wppb progress=55 color=rgba(123,64,99,0.3)]`
*Note:* Since the background color for the progress bar is dark gray, any opacity applied to the rgba color will make the color darker, since it's adding to the dark gray background.

`[wppb progress=22 color=#ff3257]`

`[wppb progress=68 color=lightYellow]`

### `endcolor`

Defines an end color for a custom gradient when used with **color**.

Supported values: any hexadecimal color value, any rgb/rgba color value, any css-supported [color name](http://www.w3schools.com/cssref/css_colornames.asp)

*Examples*

`[wppb progress=72 color=turquoise endcolor=teal]`

`[wppb progress=83 color=#ff2222 endcolor=#ff9984]`

`[wppb progress=50 color=rgb(203,96,179) endcolor=rgb(173,18,131)]`

### `gradient`

Determines an end-color on the fly for a gradient based on the **color** parameter. As such, **gradient** *requires* **color** to be present, otherwise the color and gradient will be set to the default color (blue). Cannot be used in conjunction with any of the pre-existing color options (red, yellow, orange or green). When using `gradient` the **color** value *must* be in hexadecimal form.

Supported values: any positive or negative decimal value from 0.0 to 1.0 or -1.0.

*Examples*

`[wppb progress=22 color=#ff0000 gradient=0.2]` Displays a red progress bar that gets lighter at the bottom

`[wppb progress=22 color=#ff0000 gradient=-0.2]` Displays a red progress bar that gets darker at the bottom

**This does not work:**

`[wppb progress=34 color=rgb(22,18,99) gradient=0.2]`

## Frequently Asked Questions

**How do I change the currency?**

WP Progress bar allows currencies in progress bars. By default, the supported currency symbol is $. However, since version 2.2, you can modify this in your environment by using the `wppb.currency_symbol` filter, e.g.:

```php
add_filter( 'wppb.currency_symbol', 'my_custom_currency_symbol' );
function my_custom_currency_symbol( $symbol ) {
	return '£';
}
```

This code would allow-list the £ symbol for use in progress bars. You can also add support for multiple currency symbols in a similar way:

```php
add_filter( 'wppb.currency_symbol', 'my_custom_currency_symbol' );
function my_custom_currency_symbol( $symbol ) {
	$allowed_symbols ### `[`
	if ( in_array( $symbol, $allowed_symbols ) ) {
		return $symbol;
	}

	return '$';
}
```

**How do I change the colors?**

You can change the colors via the css.  Use `div.wppb-progress` to change the style of the container and `div.wppb-progress > span` to change the style of the bar itself.  You can also change the candystripe and animated candystripe.  See http://css-tricks.com/css3-progress-bars/ for an excellent tutorial and http://www.colorzilla.com/gradient-editor/ for a CSS gradient generator.

**No, really, how do I change the colors?  I don't know much about CSS.**

Okay, here's a great example that's being used in the plugin CSS right now to create the 'red' option.  Here's the CSS:

```css
/* red */
div.wppb-progress > span.red {
	background: #d10418; /* Old browsers */
	background: -moz-linear-gradient(top, #d10418 0%, #6d0019 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#d10418), color-stop(100%,#6d0019)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #d10418 0%,#6d0019 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #d10418 0%,#6d0019 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #d10418 0%,#6d0019 100%); /* IE10+ */
	background: linear-gradient(top, #d10418 0%,#6d0019 100%); /* W3C */
}
```

You don't need to worry about the candystripes -- those will apply to your new option automatically.  Using this example, you can change the hex values and create a new class (like span.green or span.orange or span.nyannyanrainbows) that you can use inside the shortcode.  Want to see where I got those gradient values?  Go here: http://www.colorzilla.com/gradient-editor/#d10418+0,6d0019+100;Custom

**What about placement of the percentage?  Where's that?**

At the end of `wppb.css` you'll find the two classes for the percentage parameter:

```css
/* after */
div.wppb-wrapper.after { width: 440px; }
div.wppb-wrapper.after div.wppb-progress { float: left; }
div.wppb-wrapper.after div.after { float: right; line-height: 25px; }

/* inside */
div.wppb-wrapper.inside { width: 400px; height: 25px; position: relative; }
div.wppb-wrapper div.inside { margin: 0 auto; line-height: 25px; color: #ffffff; font-weight: bold; position: absolute; z-index: 1; width: 400px; text-align: center; }
```

Position these however you want.  If you wanted the percentage to be inside the progress bar but towards the end, you could do something like this:

```css
/* right */
div.wppb-wrapper.right { width: 400px; height: 25px; position: relative; }
div.wppb-wrapper div.inside { margin: 0 auto; line-height: 25px; color: #ffffff; font-weight: bold; position: absolute; z-index: 1; width: 400px; text-align: right; padding-right: 10px }
```
