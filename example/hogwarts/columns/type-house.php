<?php
/**
* Availble variables:
* @param $column
* @param $post_id
*/
$awaiting = 'Awaiting the sorting hat.';
$terms = get_the_terms( $post_id, 'houses' );
if ( $terms && !is_wp_error( $terms ) ) {
    $houses = array();
    foreach ( $terms as $term ) {
        $houses[] = $term->name;
    }
    echo !empty($houses) ? join( ', ', $houses ) : $awaiting;
} else echo $awaiting;