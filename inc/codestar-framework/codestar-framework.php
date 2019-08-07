<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.

/**
 *
 * @package   Codestar Framework - WordPress Options Framework
 * @author    Codestar <info@codestarthemes.com>
 * @link      http://codestarframework.com
 * @copyright 2015-2018 Codestar
 *
 *
 * Plugin Name: Codestar Framework
 * Plugin URI: http://codestarframework.com/
 * Author: Codestar
 * Author URI: http://codestarthemes.com/
 * Version: 2.0.8
 * Description: A Simple and Lightweight WordPress Option Framework for Themes and Plugins
 * Text Domain: csf
 * Domain Path: /languages
 *
 */



require_once plugin_dir_path( __FILE__ ) .'classes/setup.class.php';

/**
 * Caozhuti Custom function for get an option
 */
if (!function_exists('_cao')) {
    function _cao($option = '', $default = null)
    {
        $options = get_option('_caozhuti_options'); // Attention: Set your unique id of the framework
        return (isset($options[$option])) ? $options[$option] : $default;
    }
}


require_once plugin_dir_path( __FILE__ ) .'options/options.theme.php';
require_once plugin_dir_path( __FILE__ ) .'options/profile.theme.php';
require_once plugin_dir_path( __FILE__ ) .'options/metabox.theme.php';
require_once plugin_dir_path( __FILE__ ) .'options/widgets.theme.php';
require_once plugin_dir_path( __FILE__ ) .'options/shortcoder.theme.php';
require_once plugin_dir_path( __FILE__ ) .'options/taxonomy.theme.php';