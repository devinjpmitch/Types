<?php
namespace MBC\inc\types;
defined( 'ABSPATH' ) || exit;
class Finalize extends types {
    public function __construct(){}
    public static function flush(){
        // if custom post type variable
        if(self::$cpt_v){
            // register custom post type
            self::$cpt_v->register();
            // flush rewrite rules
            self::$cpt_v->flush();
        }
    }
}