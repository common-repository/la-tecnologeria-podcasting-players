<?php
if( !class_exists( 'Tecnologeria_Podcasting_Plugin_Settings' ) ) {
    class Tecnologeria_Podcasting_Plugin_Settings
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            // register actions
            add_action( 'admin_init', array( &$this, 'admin_init' ) );
            add_action( 'admin_menu', array( &$this, 'add_menu' ) );
        } // END public function __construct
        
        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init()
        {
            // register your plugin's settings
            $color_args = array(
                'type' => 'string', 
                'sanitize_callback' => array( &$this, 'sanitize_color_field' ),
                'default' => NULL,
            );
            register_setting( 'ivoox_shortcode_group', 'ivoox_setting_color', $color_args );

            // add your settings section
            add_settings_section(
                'ivoox_shortcode_group', 
                __( 'iVoox Shortcode Settings', 'tecnologeria_podcasting' ), 
                array( &$this, 'settings_section_ivoox_shortcode' ), 
                'ivoox_shortcode'
            );
            
            // add your setting's fields
            add_settings_field(
                'ivoox_shortcode_setting_color', 
                __( 'Default Color', 'tecnologeria_podcasting' ), 
                array( &$this, 'settings_field_input_text' ), 
                'ivoox_shortcode', 
                'ivoox_shortcode_group',
                array(
                    'field' => 'ivoox_setting_color'
                )
            );
            // Possibly do additional admin_init tasks
        } // END public static function activate
        
        public function sanitize_color_field( $input = NULL )
        {
            if ( $input !== "" && preg_match( '/^#([0-9A-F]{3}){1,2}$/i', $input ) !== 1 ) {
                add_settings_error(
                    'ivoox_shortcode_group',
                    esc_attr('settings_updated'),
                    __( 'Wrong HTML color format. Use #RRGGBB or #RGB instead.', 'tecnologeria_podcasting' ),
                    'error'
                );
                return null;
            }
            add_settings_error(
                'ivoox_shortcode_group',
                esc_attr('settings_updated'),
                __('Color updated.','tecnologeria_podcasting'),
                'success'
            );
  
            return $input;
        }

        public function settings_section_ivoox_shortcode()
        {
            // Think of this as help text for the section.
            _e( 'Set the default configuration to be used by iVoox shortcodes across your site.', 'tecnologeria_podcasting' );
        }
        
        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text( $args )
        {
           // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option( $field );
            // echo a proper input type="text"
            echo sprintf( '<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value );
        } // END public function settings_field_input_text($args)
        
        /**
         * add a menu
         */     
        public function add_menu()
        {
            // Add a page to manage this plugin's settings
            add_options_page(
                __( 'La Tecnologer&iacute;a Podcasting Settings', 'tecnologeria_podcasting' ), 
                __( 'La Tecnologer&iacute;a Podcasting', 'tecnologeria_podcasting' ),
                'manage_options', 
                'tecnologeria_podcasting_plugin', 
                array( &$this, 'plugin_settings_page' )
            );
        } // END public function add_menu()
    
        /**
         * Menu Callback
         */     
        public function plugin_settings_page()
        {
            if( !current_user_can( 'manage_options' ) ) {
                wp_die( __( 'You do not have sufficient permissions to access this page.', 'tecnologeria_podcasting' ) );
            }

            // Render the settings template
            include( sprintf( "%s/templates/settings.php", dirname(__FILE__) ) );
        } // END public function plugin_settings_page()
    } // END class Tecnologeria_Podcasting_Plugin_Settings
} // END if(!class_exists('Tecnologeria_Podcasting_Plugin_Settings'))
?>