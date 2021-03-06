<?php
/*
Plugin Name: FacetWP
Plugin URI: https://facetwp.com/
Description: Faceted Search and Filtering for WordPress
Version: 2.2.1
Author: Matt Gibbs
Author URI: https://facetwp.com/

Copyright 2015 Matt Gibbs

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see <http://www.gnu.org/licenses/>.
*/

defined( 'ABSPATH' ) or exit;

class FacetWP
{

    public $ajax;
    public $facet;
    public $helper;
    public $indexer;
    public $display;
    private static $instance;


    function __construct() {

        // setup variables
        define( 'FACETWP_VERSION', '2.2.1' );
        define( 'FACETWP_DIR', dirname( __FILE__ ) );
        define( 'FACETWP_URL', plugins_url( basename( dirname( __FILE__ ) ) ) );
        define( 'FACETWP_BASENAME', plugin_basename( __FILE__ ) );

        // automatic updates
        include( FACETWP_DIR . '/includes/class-updater.php' );

        add_action( 'init', array( $this, 'init' ) );
    }


    /**
     * Initialize the singleton
     */
    public static function instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
        }
        return self::$instance;
    }


    /**
     * Initialize classes and WP hooks
     */
    function init() {

        // i18n
        $this->load_textdomain();

        // classes
        foreach ( array( 'helper', 'ajax', 'facet', 'indexer', 'display', 'upgrade' ) as $f ) {
            include( FACETWP_DIR . "/includes/class-{$f}.php" );
        }

        new FacetWP_Upgrade();
        $this->helper       = new FacetWP_Helper();
        $this->facet        = new FacetWP_Facet();
        $this->indexer      = new FacetWP_Indexer();
        $this->display      = new FacetWP_Display();
        $this->ajax         = new FacetWP_Ajax();

        // integrations
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        include( FACETWP_DIR . '/includes/integrations/searchwp/searchwp.php' );
        include( FACETWP_DIR . '/includes/integrations/woocommerce/woocommerce.php' );
        include( FACETWP_DIR . '/includes/integrations/edd/edd.php' );
        include( FACETWP_DIR . '/includes/integrations/acf/acf.php' );
        include( FACETWP_DIR . '/includes/functions.php' );

        // hooks
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
        add_filter( 'redirect_canonical', array( $this, 'redirect_canonical' ), 10, 2 );
    }


    /**
     * i18n support
     */
    function load_textdomain() {
        $locale = apply_filters( 'plugin_locale', get_locale(), 'fwp' );
        $mofile = WP_LANG_DIR . '/facetwp/fwp-' . $locale . '.mo';

        if ( file_exists( $mofile ) ) {
            load_textdomain( 'fwp', $mofile );
        }
        else {
            load_plugin_textdomain( 'fwp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }
    }


    /**
     * Register the FacetWP settings page
     */
    function admin_menu() {
        add_options_page( 'FacetWP', 'FacetWP', 'manage_options', 'facetwp', array( $this, 'settings_page' ) );
    }


    /**
     * Enqueue jQuery
     */
    function front_scripts() {
        wp_enqueue_script( 'jquery' );
    }


    /**
     * Enqueue admin tooltips
     */
    function admin_scripts( $hook ) {
        if ( 'settings_page_facetwp' == $hook ) {
            wp_enqueue_style( 'media-views' );
            wp_enqueue_script( 'jquery-powertip', FACETWP_URL . '/assets/js/jquery-powertip/jquery.powertip.min.js', array( 'jquery' ), '1.2.0' );
        }
    }


    /**
     * Route to the correct edit screen
     */
    function settings_page() {
        include( FACETWP_DIR . '/templates/page-settings.php' );
    }


    /**
     * Prevent WP from redirecting FWP pager to /page/X
     */
    function redirect_canonical( $redirect_url, $requested_url ) {
        if ( false !== strpos( $redirect_url, 'fwp_paged' ) ) {
            return false;
        }
        return $redirect_url;
    }
}

$facetwp = FWP();


/**
 * Allow direct access to FacetWP classes
 * For example, use FWP()->helper to access FacetWP_Helper
 */
function FWP() {
    return FacetWP::instance();
}
