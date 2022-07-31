<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

//Require Types Classes
require plugin_dir_path( __FILE__ ) . 'types/init.php';
require plugin_dir_path( __FILE__ ) . 'types/load.php';
require plugin_dir_path( __FILE__ ) . 'types/notice.php';
require plugin_dir_path( __FILE__ ) . 'types/set.php';
require plugin_dir_path( __FILE__ ) . 'types/finalize.php';
require plugin_dir_path( __FILE__ ) . 'types/postType.php';
require plugin_dir_path( __FILE__ ) . 'types/taxonomy.php';
require plugin_dir_path( __FILE__ ) . 'types/acf.php';

//Require Documentation
require plugin_dir_path( __FILE__ ) . 'documentation.php';

use MBC\inc\types as PLUGIN;
/**
 * Types initilize method
 *
 * Run initialization of the plugin
 */
add_action('plugins_loaded', function(){
    PLUGIN\Types::init();
});

