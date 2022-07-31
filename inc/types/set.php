<?php
namespace MBC\inc\types;
defined( 'ABSPATH' ) || exit;
class Set extends types {
    public function __construct(){}
    public static function key($key){
        // set acf key
        return $key.'_'.self::$current_cpt['type']['info']['name'].'_CPT';
    }
}