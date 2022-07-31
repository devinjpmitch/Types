<?php
namespace MBC\inc\types;
defined( 'ABSPATH' ) || exit;
class Notice extends types {
    public function __construct(){}
    public static function load(){
        // array of notices
        $notices = array();
        // directory variable to current directory / notice /
        $dir = self::$current_dir . '/notice/';
        // if this is not a directory return
        if(!is_dir($dir)) return; 
        // files to scan directory
        $files = scandir($dir);
        // foreach file in directory
        foreach($files as $file){
            // if file is a file and not a folder or . or .. and extension is php
            if(is_file($dir.$file) && $file != '.' && $file != '..' && pathinfo($dir.$file, PATHINFO_EXTENSION) == 'php'){
                // get namespacing of filename
                $e = explode('-',str_replace('.php', '', $file));
                // if namespace is more than 3 continue
                if(count($e) > 3) continue;
                // switch on namespace 0
                switch($e[0]){
                    // if namespace is type
                    case 'type':
                        // add to notices array
                        $notices[] = array(
                            'path'=> $dir.$file,
                            'type'=> $e[0],
                            'post-type'=> self::$current_cpt['type']['info']['name'],
                            'location'=> $e[1]
                        );
                        break;
                    // if namespace is tax
                    case 'tax':
                        // add to notices array
                        $notices[] = array(
                            'path'=> $dir.$file,
                            'type'=> $e[0],
                            'post-type'=> self::$current_cpt['type']['info']['name'],
                            'tax-type'=> $e[1],
                            'location'=> $e[2]
                        );
                        break;
                }
            }
        }
        // add action to admin_notices using notices array
        add_action('admin_notices',function() use($notices){
            // get current screen
            $screen = get_current_screen();
            //foreach notice in array
            foreach($notices as $notice){
                //if the notice location does not exist return
                if(!isset($notice['location'])) return;
                // switch notice type
                switch($notice['type']){
                    // if type
                    case 'type':
                        // if current screen post type is notice post type and screen base is notice location include path
                        if($screen->post_type === $notice['post-type'] && $screen->base === $notice['location']){
                            include($notice['path']);
                        }
                        break;
                    // if tax
                    case 'tax':
                        // is location edit ? if so its location with added end prefix with -tags otherwise location
                        $loc = $notice['location'] === 'edit' ? $notice['location'].'-tags' : $notice['location'];
                        // if screen post type is notice post type and screen taxonomy is notice tax type and screenbase is loc include path
                        if($screen->post_type === $notice['post-type'] && $screen->taxonomy === $notice['tax-type'] && $screen->base === $loc){
                            include($notice['path']);
                        }
                        break;
                }
            }
        });
    }
}