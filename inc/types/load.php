<?php
namespace MBC\inc\types;
defined( 'ABSPATH' ) || exit;
class Load extends types {
    public function __construct(){}
    public static function directory(){
        // is Types a directory in stylesheet directory?
        if(is_dir(self::$stylesheet_directory . '/types')){
            // scan directory
            $files = scandir(self::$stylesheet_directory . '/types');
            //foreach file in directory
            foreach($files as $file){
                // file is a directory and is not . or ..
                if(is_dir(self::$stylesheet_directory . '/types/' . $file) && $file != '.' && $file != '..'){
                    // set current directory
                    self::$current_dir = self::$stylesheet_directory . '/types/' . $file;
                    // set current directory uri
                    self::$current_url = self::$stylesheet_url . '/types/' . $file;
                    // load post type
                    PostType::load();
                    // load taxonomy type
                    Taxonomy::load();
                    // flush rewrite rules
                    Finalize::flush();
                    // load notices
                    Notice::load();
                }
            }
        }
    }
}