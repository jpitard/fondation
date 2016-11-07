<?php 

/*-----------------------------------------------------------------------------------*/
/* lawthemes Framework Version & Theme Version */
/*-----------------------------------------------------------------------------------*/
function sig_version_init(){

    $sig_framework_version = '1.0';
    update_option('sig_framework_version',$sig_framework_version);
	
}
add_action('init','sig_version_init');

function sig_version(){
    
    $theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
    $theme_version = $theme_data['Version'];
    $sig_framework_version = get_option('sig_framework_version');

   
    
   
}
add_action('wp_head','sig_version');

/*-----------------------------------------------------------------------------------*/
/* Load the required Framework Files */
/*-----------------------------------------------------------------------------------*/

$functions_path = TEMPLATEPATH . '/functions/';

require_once ($functions_path . 'admin-setup.php');			// Options panel variables and functions
require_once ($functions_path . 'admin-custom.php');		// Custom fields 
require_once ($functions_path . 'admin-interface.php');		// Admin Interfaces (options,framework, seo)
require_once ($functions_path . 'admin-hooks.php');			// Definition of sigHooks



?>