<?php
namespace MBC\inc\types;
defined( 'ABSPATH' ) || exit;
class Load extends types {
    public function __construct(){}
    public static function directory(){
        $directories = ['types','resources/types'];
        foreach($directories as $directory){
            if(!is_dir(self::$stylesheet_directory . '/' . $directory)) continue;
            $files = scandir(self::$stylesheet_directory . '/' . $directory);
            foreach($files as $file){
                if(is_dir(self::$stylesheet_directory . '/' . $directory . '/' . $file) && $file != '.' && $file != '..'){
                    self::$current_dir = self::$stylesheet_directory . '/' . $directory . '/' . $file;
                    self::$current_url = self::$stylesheet_url . '/' . $directory . '/' . $file;
                    PostType::load();
                    Taxonomy::load();
                    Finalize::flush();
                    Notice::load();
                }
            }
        }
    }
}
