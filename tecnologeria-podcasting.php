<?php
/*
 * Plugin Name: 		La Tecnologeria Podcasting players
 * Plugin URI:  		http://www.tecnologeria.com
 * Description: 		Provides shortcodes to show podcast players from different providers.
 * Version:     		1.3
 * Requires at least: 	4.9.13
 * Requires PHP:      	5.6.40
 * Tested up to:		5.8.2
 * Author:      		Pablo Trinidad
 * Author URI:  		https://tecnologeria.com
 * License:     		LGPL3
 * License URI: 		http://www.gnu.org/licenses/lgpl-3.0.html
 * Text Domain:			tecnologeria_podcasting
 * Domain Path: 		/languages
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if( !class_exists( 'Tecnologeria_Podcasting_Plugin' ) ) {
	class Tecnologeria_Podcasting_Plugin
	{
		private static $tecnologeria_podcasting_version = "1.2";

		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// Initialize Settings
			require_once( sprintf( "%s/settings.php", dirname(__FILE__) ) );
			$Tecnologeria_Podcasting_Plugin_Settings = new Tecnologeria_Podcasting_Plugin_Settings();

			$plugin = plugin_basename( __FILE__ );
			add_filter( 'plugin_action_links_$plugin', array( $this, 'plugin_settings_link' ) );		
			add_action( 'plugins_loaded', array( $this, 'plugin_update_db_check' ) );
			add_shortcode( 'ivoox', array( $this,'ivooxShortCode' ) );
			add_shortcode( 'ivoox-old', array( $this,'ivooxOldShortCode' ) );
			add_shortcode( 'ivoox-compact', array( $this,'ivooxCompactShortCode' ) );
			add_shortcode( 'ivoox-mini', array( $this,'ivooxMiniShortCode' ) );
			add_shortcode( 'ivoox-program', array( $this,'ivooxProgramShortCode' ) );
			add_shortcode( 'youtube', array( $this,'youtubePlayer' ) );
			
			add_action( 'plugins_loaded', array( $this, 'tecnologeria_podcasting_load_plugin_textdomain' ));
		} // END public function __construct
		/**
		 * Activate the plugin
		 */
		public static function activate()
		{
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			add_option( 'tecnologeria_podcasting_version', Tecnologeria_Podcasting_Plugin::$tecnologeria_podcasting_version );
		} // END public static function activate
		
		/**
		 * Deactivate the plugin
		 */
		public static function deactivate()
		{
			remove_shortcode( 'ivoox' );
			remove_shortcode( 'ivoox-old' );
			remove_shortcode( 'ivoox-compact' );
			remove_shortcode( 'ivoox-mini' );
			remove_shortcode( 'youtube' );
		} // END public static function deactivate
		
		/**
		 * Uninstall the plugin
		 */
		public static function uninstall()
		{
    		$option_name = 'tecnologeria_podcasting_version';
			delete_option( $option_name );
			delete_site_option( $option_name );
			require_once( ABSPATH .'wp-admin/includes/upgrade.php' );
		} // END public static function uninstall

		function plugin_update_db_check() {
		    if ( get_site_option( 'tecnologeria_podcasting_version' ) !== Tecnologeria_Podcasting_Plugin::$tecnologeria_podcasting_version ) {
		    	add_option( 'tecnologeria_podcasting_version', Tecnologeria_Podcasting_Plugin::$tecnologeria_podcasting_version );
		        $this->update_database();
		    }
		}

		function update_database() {

		}

		/** 
		 * Add the settings link to the plugins page
		 */
		function plugin_settings_link( $links )
		{
			$settings_link = '<a href="options-general.php?page=tecnologeria_podcasting_plugin">Settings</a>';
			array_unshift( $links, $settings_link );
			return $links;
		} // END function plugin_settings_link

		function ivooxShortCode( $atts ) {
			$atts = shortcode_atts(
				array(
					'id' => -1,
					'color' => null,
				), $atts, 'ivoox' );
			
			if ( $atts['id'] == -1 ) {
				$code = '<div class="bg-danger">' . __( 'iVoox shortcode error: id field missing', 'tecnologeria_podcasting' ) . '</div>';
			} elseif ( $atts['color'] !== null && preg_match( '/^#([0-9A-F]{3}){1,2}$/i', $atts['color'] ) !== 1 ) {
				$code = '<div class="bg-danger">' . __( 'iVoox shortcode error: wrong HTML color value', 'tecnologeria_podcasting' ) . '</div>';
			} else {
  				$id = intval( $atts['id'] );
  				$color = ( $atts['color'] === null ) ? get_option( 'ivoox_setting_color', null ) : $atts['color'];
  				$colorText = ( $color === null ) ? "'" : "?c1=". substr( $color, 1 ) . "'";
  				$code = "<iframe src='https://www.ivoox.com/player_ej_" . $id . "_6_1.html" . $colorText . " id='audio_" . $id . "' frameborder='0' allowfullscreen='' scrolling='no' height='200' width='100%'></iframe>";
			}
			return $code;
		}

		function ivooxOldShortCode( $atts ) {
			$atts = shortcode_atts(
				array(
					'id' => -1,
					'color' => null,
				), $atts, 'ivoox' );
			
			if ( $atts['id'] == -1 ) {
				$code = '<div class="bg-danger">' . __( 'iVoox shortcode error: id field missing', 'tecnologeria_podcasting' ) . '</div>';
			} elseif ( $atts['color'] !== null && preg_match( '/^#([0-9A-F]{3}){1,2}$/i', $atts['color'] ) !== 1 ) {
				$code = '<div class="bg-danger">' . __( 'iVoox shortcode error: wrong HTML color value', 'tecnologeria_podcasting' ) . '</div>';
			} else {
  				$id = intval( $atts['id'] );
  				$color = ( $atts['color'] === null ) ? get_option( 'ivoox_setting_color', null ) : $atts['color'];
  				$colorText = ( $color === null ) ? "'" : "?c1=". substr( $color, 1 ) . "'";

  				$code = "<iframe id='audio_" . $id . "' frameborder='0' allowfullscreen='' scrolling='no' height='200' src='https://www.ivoox.com/player_ej_" . $id . "_4_1.html" . $colorText . " style='border:1px solid #EEE; box-sizing:border-box; width:100%;'></iframe>";
			}
			return $code;
		}

		function ivooxCompactShortCode( $atts ) {
			$atts = shortcode_atts(
				array(
					'id' => -1,
				), $atts, 'ivoox' );
			
			if ( $atts['id'] == -1 ) {
				$code = '<div class="bg-danger">' . __('iVoox shortcode error: id field missing','tecnologeria_podcasting') . '</div>';
			} else {
  				$id = intval( $atts['id'] );
 
  				$code = '<iframe width="100%" height="200" frameborder="0" allowfullscreen="" scrolling="no" src="https://www.ivoox.com/player_ej_' .$id . '_2_1.html?data=lZ6dm5yVeJShhpywj5WVaZS1lJuSlaaUfY6ZmKiak5KJe6ShmpKSmaiRfY6ZmKiah5eXdpGfjpCww9XNuIa3lIquk9OPhc6ZpJiSo57WrcTVhpiujbjTsMXVxdSYxsqPjc_qysrf0NSPqMafo9fixMbPqY6ZmKiarsaPmMbXz9TZ0czJtoa3lIqupsaRaZi3jpk.&"></iframe>';
  			}
			return $code;
		}

		function ivooxMiniShortCode( $atts ) {
			$atts = shortcode_atts(
				array(
					'id' => -1,
				), $atts, 'ivoox' );
			
			if ( $atts['id'] == -1 ) {
				$code = '<div class="bg-danger">' . __( 'iVoox shortcode error: id field missing', 'tecnologeria_podcasting' ) . '</div>';
			} else {
  				$id = intval( $atts['id'] );
 
  				$code = '<iframe width="238" height="48" frameborder="0" allowfullscreen="" scrolling="no" src="https://www.ivoox.com/player_ek_' . $id . '_2_1.html?data=lZ6dm5yVeJShhpywj5WVaZS1lJuSlaaUfY6ZmKiak5KJe6ShmpKSmaiRfY6ZmKiah5eXdpGfjpCww9XNuIa3lIquk9OPhc6ZpJiSo57WrcTVhpiujbjTsMXVxdSYxsqPjc_qysrf0NSPqMafo9fixMbPqY6ZmKiarsaPmMbXz9TZ0czJtoa3lIqupsaRaZi3jpk.&"></iframe>';
  			}
			return $code;
		}

		/** New in version 1.3
		 * 
		 * */
		function ivooxProgramShortCode( $atts ) {
			$atts = shortcode_atts(
				array(
					'id' => -1,
					'color' => null,
				), $atts, 'ivoox' );
			
			if ( $atts['id'] == -1 ) {
				$code = '<div class="bg-danger">' . __( 'iVoox shortcode error: id field missing', 'tecnologeria_podcasting' ) . '</div>';
			} elseif ( $atts['color'] !== null && preg_match( '/^#([0-9A-F]{3}){1,2}$/i', $atts['color'] ) !== 1 ) {
				$code = '<div class="bg-danger">' . __( 'iVoox shortcode error: wrong HTML color value', 'tecnologeria_podcasting' ) . '</div>';
			} else {
  				$id = intval( $atts['id'] );
  				$color = ( $atts['color'] === null ) ? get_option( 'ivoox_setting_color', null ) : $atts['color'];
  				$colorText = ( $color === null ) ? "'" : "?c1=". substr( $color, 1 ) . "'";
  				$code = "<iframe src='https://www.ivoox.com/player_es_podcast_" . $id . "_zp_1.html" . $colorText . " width='100%' height='400' frameborder='0' allowfullscreen='' scrolling='no'></iframe>";
			}
			return $code;
		}

		function youtubePlayer( $atts ) {
			$atts = shortcode_atts(
				array(
					'id' => -1,
					'width' => -1,
					'height' => -1,
					'cookies' => false,
				), $atts, 'ivoox' );
			$width	= intval( $atts['width'] );
			$height = intval( $atts['height'] );

			// we limit the boundaries of width and height to 1080p.
			// We use defaults in case w/h are 0
			if ( $width <= 0 ) 		{ 
				if ( $height <= 0) 	{ $width = 560; }
				else 				{ $width = 16 * $height / 9; }
			}
			if ( $width >= 2000 ) 	{ $width = 2000; }
			if ( $height <= 0 ) 	{ 
				$height = $width * 9 /16;
			}
			if ( $height >= 1080 ) 	{ $height = 1080; }

			$cookies = filter_var( $atts['cookies'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE );
			$cookies = is_null ($cookies) ? false : $cookies;
			
			if ( $atts['id'] == -1 ) {
				$code = '<div class="bg-danger">' . __( 'Youtube player error: id field missing', 'tecnologeria_podcasting' ) . '</div>';
			} else {
				$url = $cookies ? 'https://www.youtube.com/embed/' : 'https://www.youtube-nocookie.com/embed/';
  				$code = '<iframe width="' .$width . '" height="' . $height . '" src="' . $url . esc_html( $atts['id'] ) . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
  			}
			return $code;
		}

		function tecnologeria_podcasting_load_plugin_textdomain() {
		    load_plugin_textdomain( 'tecnologeria_podcasting', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
		}
	} // END class Tecnologeria_Podcasting_Plugin
} // END if(!class_exists('Tecnologeria_Podcasting_Plugin'))

if( class_exists('Tecnologeria_Podcasting_Plugin') ) {
	// Installation and uninstallation hooks
	register_activation_hook( __FILE__, array( 'Tecnologeria_Podcasting_Plugin', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'Tecnologeria_Podcasting_Plugin', 'deactivate' ) );
	register_uninstall_hook( __FILE__, array( 'Tecnologeria_Podcasting_Plugin', 'uninstall' ) );

	// instantiate the plugin class
	$Tecnologeria_Podcasting_Plugin = new Tecnologeria_Podcasting_Plugin();
}
?>