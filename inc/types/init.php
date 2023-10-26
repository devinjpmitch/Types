<?php
namespace MBC\inc\types;
/**
 * @author jjgrainger
 * CPT Classes For Types created by jjgrainger
 * @version 2.2
 * @link https://github.com/jjgrainger/PostTypes
 */
defined( 'ABSPATH' ) || exit;
// if jjgrainger post types not installed return
if(
    !class_exists('\\PostTypes\\PostType') ||
    !class_exists('\\PostTypes\\Taxonomy') ||
    !class_exists('\\PostTypes\\Columns')
) {
    require plugin_dir_path( __FILE__ ) . 'cpt/PostType.php';
    require plugin_dir_path( __FILE__ ) . 'cpt/Columns.php';
    require plugin_dir_path( __FILE__ ) . 'cpt/Taxonomy.php';
}

/**
 * @author Mitchell-Blair Chelin
 * Extended Wordpress method class for registering custom post types, taxonomies, and ACF fields.
 * @version 1.0.1
 */
class types {
    // Stylesheet directory
    public static $stylesheet_directory = '';
    // Stylesheet Directory URI
    public static $stylesheet_url = '';
    // ACF installed?
    public static $acf_cpt = false;
    // Current Directory
    public static $current_dir = false;
    // Current Directory URI
    public static $current_url = false;
    // Current Custom Post Type Array
    public static $current_cpt = array();
    // Custom Post Type Variable
    public static $cpt_v = false;
    // All CPTV data
    public static $cptv_all = array();
     // Taxonomy Type Variable
    public static $tax_v = false;
    public function __construct(){}
    public static function init(){
        // is ACF installed?
        self::$acf_cpt = class_exists('ACF');
        // set stylesheet directory
        self::$stylesheet_directory = get_stylesheet_directory();
        // set stylesheet directory uri
        self::$stylesheet_url = get_stylesheet_directory_uri();
        // load directory
        Load::directory();
        // add admin css
        add_action('admin_enqueue_scripts', function(){
            wp_enqueue_style('type-style', plugin_dir_url( __FILE__ ) . '../assets/style.css');
        });

    }
}