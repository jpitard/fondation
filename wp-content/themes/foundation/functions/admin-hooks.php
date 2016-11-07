<?php

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Hook Definitions

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Hook Definitions */
/*-----------------------------------------------------------------------------------*/

// header.php
function sig_head() { do_action( 'sig_head' ); }					
function sig_top() { do_action( 'sig_top' ); }					
function sig_header_before() { do_action( 'sig_header_before' ); }			
function sig_header_inside() { do_action( 'sig_header_inside' ); }				
function sig_header_after() { do_action( 'sig_header_after' ); }			
function sig_nav_before() { do_action( 'sig_nav_before' ); }					
function sig_nav_inside() { do_action( 'sig_nav_inside' ); }					
function sig_nav_after() { do_action( 'sig_nav_after' ); }		

// Template files: 404, archive, single, page, sidebar, index, search
function sig_content_before() { do_action( 'sig_content_before' ); }					
function sig_content_after() { do_action( 'sig_content_after' ); }					
function sig_main_before() { do_action( 'sig_main_before' ); }					
function sig_main_after() { do_action( 'sig_main_after' ); }					
function sig_post_before() { do_action( 'sig_post_before' ); }					
function sig_post_after() { do_action( 'sig_post_after' ); }					
function sig_post_inside_before() { do_action( 'sig_post_inside_before' ); }					
function sig_post_inside_after() { do_action( 'sig_post_inside_after' ); }	
function sig_loop_before() { do_action( 'sig_loop_before' ); }	
function sig_loop_after() { do_action( 'sig_loop_after' ); }	

// Sidebar
function sig_sidebar_before() { do_action( 'sig_sidebar_before' ); }					
function sig_sidebar_inside_before() { do_action( 'sig_sidebar_inside_before' ); }					
function sig_sidebar_inside_after() { do_action( 'sig_sidebar_inside_after' ); }					
function sig_sidebar_after() { do_action( 'sig_sidebar_after' ); }					

// footer.php
function sig_footer_top() { do_action( 'sig_footer_top' ); }					
function sig_footer_before() { do_action( 'sig_footer_before' ); }					
function sig_footer_inside() { do_action( 'sig_footer_inside' ); }					
function sig_footer_after() { do_action( 'sig_footer_after' ); }	
function sig_foot() { do_action( 'sig_foot' ); }					

?>