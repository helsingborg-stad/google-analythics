<?php

/**
 * Plugin Name:       Google Analytics
 * Plugin URI:        https://github.com/helsingborg-stad/google-analythics
 * Description:       Plugin to integrate Google Analytics and display simple statistics.
 * Version:           1.0.0
 * Author:            Jonatan Hanson
 * Author URI:        https://github.com/helsingborg-stad
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       google-analytics
 * Domain Path:       /languages
 */

 // Protect agains direct file access
if (! defined('WPINC')) {
    die;
}

define('GOOGLEANALYTICS_PATH', plugin_dir_path(__FILE__));
define('GOOGLEANALYTICS_URL', plugins_url('', __FILE__));
define('GOOGLEANALYTICS_TEMPLATE_PATH', GOOGLEANALYTICS_PATH . 'templates/');

load_plugin_textdomain('google-analytics', false, plugin_basename(dirname(__FILE__)) . '/languages');

require_once GOOGLEANALYTICS_PATH . 'source/php/Vendor/Psr4ClassLoader.php';
require_once GOOGLEANALYTICS_PATH . 'Public.php';

// Instantiate and register the autoloader
$loader = new GoogleAnalytics\Vendor\Psr4ClassLoader();
$loader->addPrefix('GoogleAnalytics', GOOGLEANALYTICS_PATH);
$loader->addPrefix('GoogleAnalytics', GOOGLEANALYTICS_PATH . 'source/php/');
$loader->register();

// Start application
new GoogleAnalytics\App();
