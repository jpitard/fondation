<?php

if (!is_admin()) add_action( 'wp_print_scripts', 'sigthemes_add_javascript' );

function sigthemes_add_javascript( ) {

	    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js');
    wp_enqueue_script( 'jquery' );
wp_enqueue_script( 'superfish', get_bloginfo('template_directory').'/includes/js/superfish.js', array( 'jquery' ) );

 wp_enqueue_script( 'slideshow', get_bloginfo('template_directory').'/includes/js/slideshow.js');
	}
	



?>