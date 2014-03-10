<?php
/*
Plugin Name: Monochrome Admin Icons
Plugin URI: http://github.com/10up/monochrome-admin-icons
Description: Make plugin admin icons follow <a href="http://dotorgstyleguide.wordpress.com/outline/icons/">WordPress guidelines</a>: Monochrome by default, color when active.
Author: Paul Clark, 10up
Author URI: http://pdclark.com
Version: 1.1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

add_action('admin_init', create_function('', 'new Storm_Monochrome_Admin_Icons();') );

class Storm_Monochrome_Admin_Icons {

	var $version = '1.1.3';

	/**
	 * CSS/SVG filters supported by IE7+, Firefox 3.5+, Chrome 18+, and Safari 6+
	 * @see http://stackoverflow.com/questions/609273/convert-an-image-to-grayscale-in-html-css
	 * 
	 * Javascript + HTML5 Canvas filters as fallback for Chrome 17 and Safari 5
	 * @see http://webdesignerwall.com/tutorials/html5-grayscale-image-hover
	 */
	function __construct(){
		if ( WP_DEBUG || BSM_DEVELOPMENT ) { $this->version .= '-dev-'.time(); }

		add_action( 'admin_head',   array($this, 'filter_css') );
		add_action( 'admin_footer', array($this, 'filter_svg') );

		wp_enqueue_script('monochrome-admin-icons', plugin_dir_url( __FILE__ ).'monochrome.js', array('jquery'), $this->version, false);
	}

	function filter_css() {
		?><style>
			#adminmenu > li.wp-not-current-submenu img { filter: url(#grayscale); ?>); /* Firefox 3.5+ */ filter: gray; /* IE6-9 */ -webkit-filter: grayscale(1); /* Google Chrome & Webkit Nightlies */ -moz-opacity:.8; filter:alpha(opacity=80); opacity:.80;}
			#adminmenu > li.wp-not-current-submenu:hover img { filter: none; -webkit-filter: grayscale(0); }
		</style><?php
	}

	/**
	 * SVG filter for Firefox 3.5+. 
	 * Inserting it inline avoids servers not configured to send correct SVG headers
	 */
	function filter_svg(){
		?>
		<svg height="0" xmlns="http://www.w3.org/2000/svg"><filter id="grayscale"><feColorMatrix values="0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0      0      0      1 0" /></filter></svg>
		<?php
	}
}
