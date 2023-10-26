<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$load = array(
    'types/init',
    'types/load',
    'types/notice',
    'types/set',
    'types/finalize',
    'types/postType',
    'types/taxonomy',
    'types/acf',
    'types/save',
    'documentation'
);
foreach($load as $file) require plugin_dir_path( __FILE__ ) . $file . '.php';
use MBC\inc\types as PLUGIN;
/**
 * Types initilize method
 *
 * Run initialization of the plugin
 */
add_action('plugins_loaded', function(){
    PLUGIN\Types::init();
});

