<?php
/*
Plugin Name: Monochrome Admin Icons
Description: Make plugin admin icons follow <a href="http://dotorgstyleguide.wordpress.com/outline/icons/">WordPress guidelines</a>: Monochrome by default, color when active.
Version: 1.1.1
Author: Brainstorm Media
Author URI: http://brainstormmedia.com
*/

add_action('admin_init', create_function('', 'new Storm_Monochrome_Admin_Icons();') );

class Storm_Monochrome_Admin_Icons {

	var $version = '1.1.1';

	/**
	 * CSS filters supported by IE7+, Firefox 3.5+, Chrome 18, and Safari 6+
	 * @see http://stackoverflow.com/questions/609273/convert-an-image-to-grayscale-in-html-css
	 * 
	 * Javascript + HTML5 Canvas filters as fallback for Chrome < 18 and Safari < 6
	 * @see http://webdesignerwall.com/tutorials/html5-grayscale-image-hover
	 */
	function __construct(){
		wp_enqueue_script('monochrome-admin-icons', plugin_dir_url( __FILE__ ).'monochrome.js', array('jquery'), $this->version, false);

		add_action('admin_head', array($this, 'filter_css') );
		add_action('admin_footer', array($this, 'filter_svg') );
	}

	function filter_css() {
		?><style media="screen">
			#adminmenu > li.wp-not-current-submenu img { filter: url(#grayscale); ?>); /* Firefox 3.5+ */ filter: gray; /* IE6-9 */ -webkit-filter: grayscale(1); /* Google Chrome & Webkit Nightlies */ }
			#adminmenu > li.wp-not-current-submenu:hover img { filter: none; -webkit-filter: grayscale(0); }
		</style><?php
	}

	/**
	 * SVG to support the FireFox filter. 
	 * Inserting it inline avoids servers not configured to send correct SVG headers
	 */
	function filter_svg(){
		?>
		<svg height="0" xmlns="http://www.w3.org/2000/svg"><filter id="grayscale"><feColorMatrix values="0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0      0      0      1 0" /></filter></svg>
		<?php
	}
}