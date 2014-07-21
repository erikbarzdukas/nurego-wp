<?php
/**
 * Plugin Name: Nurego WordPress
 * Plugin URI:
 * Description Nurego integration for your WordPress site.
 * Version: 0.1
 * Author: Erik Barzdukas
 * Author URI: https://github.com/erikbarzdukas
 * License: GPL2
 *
 *  Copyright 2014  Erik Barzdukas  (email : erik.barzdukas@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  */


/**
 * Globals and constants definitions
 * Just need easy access to file paths
 */

if(!defined('NUREGO_BASE_URL')) {
    define('NUREGO_BASE_URL', plugin_dir_url(__FILE__));
}

if(!defined('NUREGO_BASE_DIR')) {
    define('NUREGO_BASE_DIR', dirname(__FILE__));
}

/**
 * Get the options string from DB
 * Will implement later for choices that arise during development
 *
 * $nurego_options = get_option('nurego_settings');
 */

/**
 * Includes
 */

if(is_admin()) {
    //Loads admin settings
    include(NUREGO_BASE_DIR . 'includes/settings.php');
} else {
    //Load up the rest
    include(NUREGO_BASE_DIR . 'includes/shortcodes.php');
}
?>
