<?php
namespace MBC\inc\types;
defined( 'ABSPATH' ) || exit;
class Taxonomy extends types {
    public function __construct(){}
    public static function load(){
        // if current directory is not set or current post type taxonomy is not set return
        if(!self::$current_dir || !isset(self::$current_cpt['taxonomy'])) return;
        // foreach taxonomy in current post type as taxonomy
        foreach(self::$current_cpt['taxonomy'] as $taxonomy){
            // if taxonomy has no information continue
            if(!$taxonomy['info']) continue;
            // set taxonomy variable to register taxonomy
            self::$tax_v = new \PostTypes\Taxonomy(
                $taxonomy['info'],
                isset($taxonomy['options']) ? $taxonomy['options'] : [],
                isset($taxonomy['labels']) ? $taxonomy['labels'] : []
            );
            // if taxonomy has columns
            if(isset($taxonomy['columns'])){
                // if taxonomy has hide columns foreach hide column hide column using taxonomy variable
                if(isset($taxonomy['columns']['hide'])) foreach($taxonomy['columns']['hide'] as $column){
                    self::$tax_v->columns()->hide($column);
                }
                // if taxonomy has add columns foreach add column add column using taxonomy variable
                if(isset($taxonomy['columns']['add'])) foreach($taxonomy['columns']['add'] as $key => $column){
                    // add column key and colum to taxonomy variable
                    self::$tax_v->columns()->add($key, $column);
                    // if column has a callback
                    $populate = self::$current_dir . '/columns/tax-'.$taxonomy['info']['name'].'-' . $key . '.php';
                    $taxonomy_current = $taxonomy['info']['name'];
                    // of populate exists then include it
                    if(file_exists($populate)) self::$tax_v->columns()->populate($key, function( $content, $column, $term_id ) use ($populate, $taxonomy_current){ 
                        // setup term meta to term id variable
                        $term_meta = get_term_meta($term_id);
                        $taxonomy = $taxonomy_current;
                        // sanitize useless meta keys
                        foreach($term_meta as $key => $value) {
                            if(is_array($value) && count($value) === 1) $term_meta[$key] = $value[0];
                            if(strpos($key, '_') === 0) unset($term_meta[$key]);
                        }
                        // include populate callback
                        include $populate; 
                    });
                }
            };
            // if taxonomy has order add order to taxonomy variable
            if(isset($taxonomy['order'])) self::$tax_v->columns()->order($taxonomy['order']);
            // if taxonomy has sort add sort to taxonomy variable
            if(isset($taxonomy['sortable'])) {
                //foreach sortable column add sort to taxonomy variable
                foreach($taxonomy['sortable'] as $sort){
                    self::$tax_v->columns()->sortable( [
                        $sort  => [ $sort, true ],
                    ]);
                }
            }
            // load acf taxonomy for taxonomy name
            ACF::load('tax',$taxonomy['info']['name']);
            // register taxonomy to post type
            self::$tax_v->posttype(self::$current_cpt['type']['info']['name'])->register();
            // register taxonomy to taxonomy name
            self::$cpt_v->Taxonomy($taxonomy['info']['name']);
        }
    }
}