<?php
add_action('init', function() {
    if(class_exists('MBC\\inc\\WPDocsify')) MBC\inc\WPDocsify::register(
        array(
            array(
                'title'=>'Types',
                'label'=>'Types',
                'slug'=>'types',
                'location'=> plugin_dir_url( __FILE__ ).'docs/',
                'restricted'=> array('administrator'),
                'restrict_operator'=> 'and',
                'config'=> array(
                    'maxLevel'=> 4,
                    'subMaxLevel'=> 2,
                    'loadSidebar'=> "_sidebar.md",
                    'homepage'=> "types_gettingstarted.md",
                ),
            )
        )
    );
}); 