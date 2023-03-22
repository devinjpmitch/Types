<?php
namespace MBC\inc\types;
defined( 'ABSPATH' ) || exit;
class PostType extends types {
    public function __construct(){}
    public static function load(){
        // if current directory is not set return
        if(!self::$current_dir) return;
        // set current custom post type array
        self::$current_cpt = array(
            'type' => @json_decode(file_get_contents(self::$current_dir . '/type.json'), true),
            'taxonomy' => @json_decode(file_get_contents(self::$current_dir . '/taxonomy.json'), true),
            'icon' => self::$current_url . '/icon.svg',
        );
        // if current custom post type has type and type info
        if(self::$current_cpt['type'] && self::$current_cpt['type']['info'] ){
            // register custom post type to cpt variable
            self::$cpt_v = new \PostTypes\PostType( 
                self::$current_cpt['type']['info'], 
                isset(self::$current_cpt['type']['options']) ? self::$current_cpt['type']['options'] : [], 
                isset(self::$current_cpt['type']['labels']) ? self::$current_cpt['type']['labels'] : [] 
            );
            // if current custom post type has columns
            if(isset(self::$current_cpt['type']['columns'])){
                // foreach hidden column hide column using cpt variable
                if(isset(self::$current_cpt['type']['columns']['hide'])) foreach(self::$current_cpt['type']['columns']['hide'] as $column){
                    self::$cpt_v->columns()->hide($column);
                }
                // foreach added column add column using cpt variable
                if(isset(self::$current_cpt['type']['columns']['add'])) foreach(self::$current_cpt['type']['columns']['add'] as $key => $column){
                    self::$cpt_v->columns()->add($key, $column);
                    // check column callback
                    $populate = self::$current_dir . '/columns/type-' . $key . '.php';
                    if(!file_exists($populate)) $populate = self::$current_dir . '/columns/type-' . $column . '.php';
                    // if callback exists populate it column using cpt variable
                    if(file_exists($populate)) self::$cpt_v->columns()->populate($key, function($column, $post_id) use ($populate){ 
                        require $populate;
                    });

                }
            }
            // if current custom post type has filters add it to cpt variable
            if(isset(self::$current_cpt['type']['filters'])) self::$cpt_v->filters(self::$current_cpt['type']['filters']);
            // if current custom post type has sortable 
            if(isset(self::$current_cpt['type']['sortable'])) {
                //foreach sortable add sortable using cpt variable
                foreach(self::$current_cpt['type']['sortable'] as $sort){
                    self::$cpt_v->columns()->sortable( [
                        $sort  => [ $sort, true ],
                    ]);
                }
            }
            // if current custom post type has order add it to cpt variable
            if(isset(self::$current_cpt['type']['order'])) self::$cpt_v->columns()->order(self::$current_cpt['type']['order']);
            // if current custom post type has icon
            if(isset(self::$current_cpt['type']['icon'])){
                // if custom icon add this
                if(isset(self::$current_cpt['icon']) && file_exists(self::$current_cpt['icon'])) self::$cpt_v->icon(self::$current_cpt['icon']);
                // else use the type icon from config
                else self::$cpt_v->icon(self::$current_cpt['type']['icon']);
            }
            // if no config icon and custom icon exist use this instead 
            else if(isset(self::$current_cpt['icon'])) self::$cpt_v->icon(self::$current_cpt['icon']);
            // set acf
            ACF::load('type',self::$current_cpt['type']['info']['name']);
        }
        // else return 
        else return;
    }
}