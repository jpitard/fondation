<?php

// Register widgetized areas

function the_widgets_init() {
    if ( !function_exists('register_sidebars') )
        return;
   
    register_sidebar(array('name' => 'General','id' => 'general','description' => "General Sidebar", 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '<span>&nbsp;</span></h3>'));   
 
}

add_action( 'init', 'the_widgets_init' );


    
?>