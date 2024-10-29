<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

delete_option( 'ash_wp_header_class' );
delete_option( 'ash_wp_header_animate' );
delete_option( 'ash_wp_header_shadow' );
delete_option( 'ash_wp_header_animation_type' );
delete_option( 'ash_wp_header_sticky_already' );
delete_option( 'ash_wp_header_full_width' );