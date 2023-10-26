<?php
namespace MBC\inc\types;
defined( 'ABSPATH' ) || exit;
new Save();
class Save extends types {
    public function __construct(){
        add_action('save_post', array($this, 'save'));
    }
    /**
     * Save Post
     * Load custom function on post update
     * @param postid
     */
    public function save($postid){
        $current_post_type = get_post_type($postid);
        $post_type = array_filter(self::$cptv_all, function($cpt) use ($current_post_type){
            return $cpt->name == $current_post_type;
        });
        if(!empty($post_type)){
            $post_type = array_shift($post_type);
            $post_data = $_POST;
            $post_meta = array();
            foreach(get_post_meta($postid) as $cfkey => $cfvalue){
                if(is_array($cfvalue)){
                    if(count($cfvalue)>1) {
                        $post_meta[$cfkey] = $cfvalue;
                    } else {
                        $cfvalue = array_shift($cfvalue);
                        if(preg_match('/^a:\d+:{.*;}$/s', $cfvalue)){
                            $cfvalue = unserialize($cfvalue);
                        }
                        $post_meta[$cfkey] = $cfvalue;
                    }
                } else {
                    $post_meta[$cfkey] = $cfvalue;
                }
                
            }
            if($post_type->save) require $post_type->save;
        }
    }
    
}
