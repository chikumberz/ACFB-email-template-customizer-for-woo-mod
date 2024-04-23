<?php
    if (!defined('ABSPATH')) exit; // Exit if accessed directly

    /**
     * Plugin Name: Email Template Customizer for WooCommerce - Mod
     * Plugin URI: https://github.com/chikumberz/ACFB-email-template-customizer-for-woo-mod
     * Description: This mod will fix the order_download render bug
     * Version: 0.1.1
     * Author: Benjamin Taluyo
     * E-mail: benjie.taluyo@gmail.com
     * License: GPLv2 or later
     * License URI: http://www.gnu.org/licenses/gpl-2.0.html
     * Requires Plugins: email-template-customizer-for-woo
     */

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    if (!is_plugin_active('email-template-customizer-for-woo/email-template-customizer-for-woo.php')) return;


    if (!class_exists('Woo_Email_Template_Customizer_Email_Render_Mod')) {
        class Woo_Email_Template_Customizer_Email_Render_Mod {
            public function __construct () {
                define('ETCFW_M_PLUGIN_PATH', plugin_dir_path(__FILE__));

                include_once(ETCFW_M_PLUGIN_PATH . 'includes/email-render.php');

                new ETCFW_M\INC\Email_Render();
            }
        }

        new Woo_Email_Template_Customizer_Email_Render_Mod();
    }