<?php
function fandom_comm__enqueue_styles() {

    $parent_style = 'twentysixteen'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'fandom_comm__enqueue_styles' );

// removes the user page select meta-box for user roles that are not admins
add_action( 'admin_menu', 'restrict_access' );
function restrict_access() {
// if the user is not admin - you can add any user roles or multiple roles
if(!current_user_can('administrator')){
   // Not tested but think this is the correct code for page template meta-box
   remove_meta_box( 'pageparentdiv', 'fanfic','normal' );
   }
}

?>
