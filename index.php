<?php

/**
 * Plugin Name: Art2Market - demo plugin
 * Plugin URI: http://www.example.com
 * Description: Art2Market
 * Version: 0.0.1
 * Author: Andy Nguyen
 * Author URI: http://www.andynguyen.net
 */


require_once( dirname(__FILE__) . '/resources/controllers/Base.php');
require_once( dirname(__FILE__) . '/resources/controllers/Admin.php');
require_once( dirname(__FILE__) . '/resources/models/AdminModel.php');

// Loads the composer autoload - Kint debugging library, commented out for now so dev/user doesn't need to run composer install
//require_once( dirname(__FILE__) . '/vendor/autoload.php' );

// include single file of kint instead
require_once( dirname(__FILE__) . '/resources/libraries/kint.php');