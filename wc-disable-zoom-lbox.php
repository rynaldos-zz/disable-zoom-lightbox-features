<?php

/*
 Plugin Name: WC Disable Zoom / Lightbox features
 Plugin URI: https://profiles.wordpress.org/rynald0s
 Description: This plugin lets you disable / enable the new product gallery zoom / lightbox features in WooCommerce 3.0.
 Author: Rynaldo Stoltz
 Author URI: https://github.com/rynaldos
 Version: 1.0
 License: GPLv3 or later License
 URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 **/

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

/**
 * Add settings
 */


function rs_wc_gallery_section( $sections ) {
    $sections['product_gallery_features'] = __( 'Product Gallery Settings', 'woocommerce' );
    return $sections;
}

add_filter( 'woocommerce_get_sections_products', 'rs_wc_gallery_section' );

function rs_wc_gallery_settings( $settings, $current_section ) {
    
    /**
     * Check the current section is what we want
     **/

    if ( 'product_gallery_features' === $current_section ) {

        $wc_product_gallery_settings[] = array( 'title' => __( 'Disable zoom / lightbox features in WooCommerce 3.0', 'woocommerce' ), 'type' => 'title', 'id' => 'wc_disable_zoom_lbox' );


        $wc_product_gallery_settings[] = array(
                'title'    => __( 'Disable zoom ', 'woocommerce' ),
                'desc'     => __( 'This disables the zoom feature — check to disable zoom / uncheck to re-enable zoom', 'woocommerce' ),
                'id'       => 'wc_disable_zoom',
                'default'  => 'no',
                'type'     => 'checkbox',
            );

        $wc_product_gallery_settings[] = array(
                'title'    => __( 'Disable lightbox', 'woocommerce' ),
                'desc'     => __( 'This disables the lightbox feature — check to disable lightbox / uncheck to re-enable lightbox', 'woocommerce' ),
                'id'       => 'wc_disable_lightbox',
                'default'  => 'no',
                'type'     => 'checkbox',
            );

        $wc_product_gallery_settings[] = array(
                'title'    => __( 'Disable both', 'woocommerce' ),
                'desc'     => __( 'This disables both features — check to disable both features / uncheck to re-enable both features', 'woocommerce' ),
                'id'       => 'wc_disable_both',
                'default'  => 'no',
                'type'     => 'checkbox',
            );

        $wc_product_gallery_settings[] = array( 'type' => 'sectionend', 'id' => 'wc_disable_zoom_lbox' );
        return $wc_product_gallery_settings;

} else {
        return $settings;
    }

}

add_filter( 'woocommerce_get_settings_products','rs_wc_gallery_settings', 10, 2 );

if ( get_option( 'wc_disable_zoom' ) == 'yes' ) {

add_action( 'after_setup_theme', 'wc_remove_pgz_theme_support', 100 );

function wc_remove_pgz_theme_support() { 
remove_theme_support( 'wc-product-gallery-zoom' );
    }
}

if ( get_option( 'wc_disable_lightbox' ) == 'yes' ) {

add_action( 'after_setup_theme', 'wc_remove_pglb_theme_support', 100 );

function wc_remove_pglb_theme_support() { 
remove_theme_support( 'wc-product-gallery-lightbox' );
    } 
}

if ( get_option( 'wc_disable_both' ) == 'yes' ) {

add_action( 'after_setup_theme', 'wc_remove_both_theme_support', 200 );

function wc_remove_both_theme_support() {
remove_theme_support( 'wc-product-gallery-zoom' );
remove_theme_support( 'wc-product-gallery-lightbox' );
        } 
    }
}
