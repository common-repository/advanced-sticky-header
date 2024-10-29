<?php
/*
Plugin Name: Advanced Sticky Header
Plugin URI:
Description: Highly configurable sticky header plugin
Version: 1.0
Author: Danish Iqbal
Author URI: http://imdanishiqbal.com
License: GPLv2

Copyright 2016 Danish Iqbal (email : danishiqbalscorpio@gmail.com) This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/


register_activation_hook( __FILE__, 'ash_wp_set_defaults' );

if( !function_exists("ash_wp_set_defaults") ) {
    function ash_wp_set_defaults() {
        add_option( 'ash_wp_header_animate', '1' );
        add_option( 'ash_wp_header_animation_type', '0' );
        add_option( 'ash_wp_header_animation_type', '0' );
        add_option( 'ash_wp_header_full_width', '1');
    }
}


function ash_wp_enqueueAdminAssets() {

    wp_register_style( 'ash-wp-options-styles', plugin_dir_url( __FILE__ ) . 'css/ash-wp-styles.css', false, '1.0.0' );
    wp_enqueue_style( 'ash-wp-options-styles' );

}

add_action( 'admin_enqueue_scripts', 'ash_wp_enqueueAdminAssets' );




// Call ash_wp_header_class_menu function to load plugin menu in dashboard
add_action( 'admin_menu', 'ash_wp_menu' );


// Create WordPress admin menu
if( !function_exists("ash_wp_menu") ) {

    function ash_wp_menu(){
    
        $page_title = 'Advance Sticky Header Options';
        $menu_title = 'Advanced Sticky Header';
        $capability = 'manage_options';
        $menu_slug  = 'ash-wp';
        $function   = 'ash_wp_page';
        $icon_url   = 'dashicons-welcome-widgets-menus';
    
        add_menu_page( 
            $page_title,
            $menu_title,
            $capability,
            $menu_slug,
            $function,
            $icon_url
        );
    
        // Call updateash_wp function to update database
        add_action( 'admin_init', 'ash_wp_update' );
    
    }

}



// Create function to register plugin settings in the database
if( !function_exists("ash_wp_update") ) {

    function ash_wp_update() {

        register_setting( 'ash-wp-settings', 'ash_wp_header_class' );
        register_setting( 'ash-wp-settings', 'ash_wp_header_animate' );
        register_setting( 'ash-wp-settings', 'ash_wp_header_shadow' );
        register_setting( 'ash-wp-settings', 'ash_wp_header_animation_type' );
        register_setting( 'ash-wp-settings', 'ash_wp_header_sticky_already' );
        register_setting( 'ash-wp-settings', 'ash_wp_header_full_width' );

    }

}

// Create WordPress plugin page
if( !function_exists("ash_wp_page") ) {

    function ash_wp_page() { ?>

        <div class="wrap">
            <h1>Advanced Sticky Header Options</h1>
            <form method="post" action="options.php" class="ash-wp-options-form">

                <?php settings_fields( 'ash-wp-settings' ); ?>
                <?php do_settings_sections( 'ash-wp-settings' ); ?>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Header Class:</th>
                        <td>
                            <input type="text" name="ash_wp_header_class" value="<?php echo get_option('ash_wp_header_class'); ?>"/>
                            <p class="description">Enter class name of your header or nav element that you want to make sticky. e.g. <b>site-header</b></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Animate:</th>
                        <td>
                            <input name="ash_wp_header_animate" type="checkbox" value="1" <?php checked( '1', get_option( 'ash_wp_header_animate' ) ); ?> />
                            <p class="description">This brings header into display with animation type that you select below, default is 'Fade In'.</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Animation Type:</th>
                        <td>
                            <input name="ash_wp_header_animation_type" type="radio" value="0" <?php checked( '0', get_option( 'ash_wp_header_animation_type' ) ); ?> />Fade In
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input name="ash_wp_header_animation_type" type="radio" value="1" <?php checked( '1', get_option( 'ash_wp_header_animation_type' ) ); ?> />Slide Down
                            <p class="description">Transition style for header when it becomes sticky</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Shadow:</th>
                        <td>
                            <input name="ash_wp_header_shadow" type="checkbox" value="1" <?php checked( '1', get_option( 'ash_wp_header_shadow' ) ); ?> />
                            <p class="description">Header will have shadow when it becomes sticky</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Sticky Already:</th>
                        <td>
                            <input name="ash_wp_header_sticky_already" type="checkbox" value="1" <?php checked( '1', get_option( 'ash_wp_header_sticky_already' ) ); ?> />
                            <p class="description">Makes header sticky when page loads</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Full Width:</th>
                        <td>
                            <input name="ash_wp_header_full_width" type="checkbox" value="1" <?php checked( '1', get_option( 'ash_wp_header_full_width' ) ); ?> />
                            <p class="description">Makes header full width when it's sticky.</p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        
        </div>

    <?php
    }

}


function ash_wp_localize_vars() {

    return array(
        'header_class' => get_option('ash_wp_header_class'),
        'animate' => get_option('ash_wp_header_animate'),
        'shadow' => get_option('ash_wp_header_shadow'),
        'transitionStyle' => get_option('ash_wp_header_animation_type'),
        'stickyAlready' => get_option('ash_wp_header_sticky_already'),
        'fullWidth' => get_option('ash_wp_header_full_width')
    );

}


function ash_wp_enqueueAssets() {

    wp_enqueue_script('jquery');
    wp_register_script('ash_wp_plugin_library', plugins_url('js/ash-wp-sticky-header.js', __FILE__), array('jquery'), '', true);
    wp_register_script('ash_wp_custom_script', plugins_url('js/ash-wp-custom.js', __FILE__), array('jquery'), '', true);
    
    wp_enqueue_script( 'ash_wp_plugin_library' ); 
    wp_enqueue_script( 'ash_wp_custom_script' );
    wp_localize_script( 'ash_wp_custom_script', 'ash_wp_localized_vars', ash_wp_localize_vars());
    

}

add_action( 'wp_enqueue_scripts', 'ash_wp_enqueueAssets' );