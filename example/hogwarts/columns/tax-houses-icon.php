<?php
/**
* Availble variables:
* @param $content
* @param $column
* @param $term_id
* @param $taxonomy
* @param $term_meta
*/
//get icon from this taxonomy
$icon = get_field('icon', $taxonomy . '_' . $term_id);
if($icon) echo '<img src="' . $icon['url'] . '" alt="' . $icon['alt'] . '" />';