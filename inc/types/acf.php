<?php
namespace MBC\inc\types;
defined( 'ABSPATH' ) || exit;
class ACF extends types {
    public function __construct(){}
    /**
     * Load ACF
     * load acf fields for specific post types and taxonomies
     * @param type
     * @param name
     */
    public static function load($type = 'type',$name = false){
        //used for acf register value
        $set_value = $type === 'tax' ? $name : self::$current_cpt['type']['info']['name'];
        // if acf location field groups does not exist return
        if(!function_exists('acf_add_local_field_group') ) return;
        // acf json variable
        $acf_json = false;
        // switch on type
        switch($type){
            // if type
            case 'type':
            case 'cpt':
                // load acf fields for type
                $acf_json = @file_get_contents(self::$current_dir.'/acf/type-'.self::$current_cpt['type']['info']['name'].'-acf.json');
                if(!$acf_json) $acf_json = @file_get_contents(self::$current_dir.'/acf/type-acf.json');
                break;
            // if taxonomy
            case 'tax':
                // if name is not set return
                if(!$name) return;
                // load acf fields for taxonomy
                $acf_json = @file_get_contents(self::$current_dir.'/acf/tax-'.$name.'-acf.json');
                break;
        }
        // if acf json is not set return
        if(!$acf_json) return;
        // decode acf json
        $acf_json = json_decode($acf_json, true);

        // foreach acf json field group add field group to acf
        foreach($acf_json as $acf_single){
            // if key is not create a unique acf key
            if(!isset($acf_single['key'])) { 
                $acf_single['key'] = Set::key('group_'.$type.'_'.$set_value);
            }
            // set title
            if(!isset($acf_single['title'])) { 
                $acf_single['title'] = $type === 'tax' ? $name : self::$current_cpt['type']['info']['name'];
            }
            // if fields set
            if(isset($acf_single['fields'])){
                //foreach field
                foreach($acf_single['fields'] as $key => $single_field){
                    if(!isset($single_field['name'])) continue;
                    $name = $single_field['name'];
                    // if no key for field create one
                    if(!isset($single_field['key'])) $acf_single['fields'][$key]['key'] = Set::key('field_'.$type.'_'.$set_value.'_'.$name);
                }
            }
            // if location is not set then set it current post type or taxonomy
            if(!isset($acf_single['location'])) $acf_single['location'] = array(
                array(
                    array(
                        // determine parameter based on type
                        'param' => $type === 'tax' ? 'taxonomy':'post_type',
                        // operator is is allways eqaul to
                        'operator' => '==',
                        // value is determined by type either name or custom post type name
                        'value' => $set_value
                    )
                )
            );

            
            if(!isset($acf_single['active'])) $acf_single['active'] = true;
            if(!isset($acf_single['position'])) $acf_single['position'] = 'normal';
            if(!isset($acf_single['show_in_rest'])) $acf_single['show_in_rest'] = 1;


            
            // add single field group to acf
            acf_add_local_field_group($acf_single);
        }
    }
    
}