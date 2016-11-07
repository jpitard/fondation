<?php

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Show Options Panel after activate
- Admin Backend
	- Tweaked the message on theme activate
- Theme Header ouput - wp_head()
	- Styles
	- Favicon
	- Decode	
	- Localization
	- Date Format
	- sig_head_css
- Output CSS from standarized options
	- Text title
	- Custom.css

-----------------------------------------------------------------------------------*/

define('THEME_FRAMEWORK','lawthemes');

/*-----------------------------------------------------------------------------------*/
/* Add default options and show Options Panel after activate  */
/*-----------------------------------------------------------------------------------*/
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {

	//Call action that sets
	add_action('admin_head','sig_option_setup');
	
	//Do redirect
	header( 'Location: '.admin_url().'admin.php?page=singletheme' ) ;
	
}

function sig_option_setup(){

	//Update EMPTY options
	$sig_array = array();
	add_option('sig_options',$sig_array);
	
	
	$template = get_option('sig_template');
	$saved_options = get_option('sig_options');
	
	foreach($template as $option) {
	
			if($option['type'] != 'heading'){
	
				$id = $option['id'];
				$std = $option['std'];
				$db_option = get_option($id);
				if(empty($db_option)){
				
					if(is_array($option['type'])) {
						foreach($option['type'] as $child){
							$id = $child['id'];
							$std = $child['std'];
							update_option($id,$std);
							$sig_array[$id] = $std; }
						
					
						} else {
						update_option($id,$std);
						$sig_array[$id] = $std;
						}
				
				}
				 else { //So just store the old values over again.
				 	
					$sig_array[$id] = $saved_options[$id];
				 
				 }
				}
				
			
	
	}
	update_option('sig_options',$sig_array);


}

/*-----------------------------------------------------------------------------------*/
/* Admin Backend */
/*-----------------------------------------------------------------------------------*/
function lawthemes_admin_head() { 
	
	//Tweaked the message on theme activate
	?>
    <script type="text/javascript">
    jQuery(function(){
    	
        var message = '<p>This <strong>sigTheme</strong> comes with a <a href="<?php echo admin_url('admin.php?page=lawthemes'); ?>">comprehensive options panel</a>. This theme also supports widgets, please visit the <a href="<?php echo admin_url('widgets.php'); ?>">widgets settings page</a> to configure them.</p>';
    	jQuery('.themes-php #message2').html(message);
    
    });
    </script>
    <?php
    
    //Setup Custom Navigation Menu
	if (function_exists('sig_custom_navigation_setup')) {
		sig_custom_navigation_setup();
	}
	
}

add_action('admin_head', 'lawthemes_admin_head'); 


/*-----------------------------------------------------------------------------------*/
/* Theme Header output - wp_head() */
/*-----------------------------------------------------------------------------------*/
function lawthemes_wp_head() { 
    
	//Styles
	
     
	 
	
	// Favicon
	if(get_option('sig_custom_favicon') != '') {
        echo '<link rel="shortcut icon" href="'.  get_option('sig_custom_favicon')  .'"/>'."\n";
    }    
            
    //Decode
	if(!isset($_REQUEST['decode']))
		$decode = 'false';
	else
		$decode = $_REQUEST['decode'];
		
	if ($decode == 'true') 
		echo '<meta name="generator" content="' . get_option('sig_settings_encode') . '" />';

	// Localization
	load_theme_textdomain('lawthemes');	
	
	// Date format
	$GLOBALS['sigdate'] = get_option('sig_date');	
	if ( $GLOBALS['sigdate'] == "" )
		$GLOBALS['sigdate'] = "d. M, Y";	
		
	// Output CSS from standarized options	
	sig_head_css();

}
add_action('wp_head', 'lawthemes_wp_head');


/*-----------------------------------------------------------------------------------*/
/* Output CSS from standarized options */
/*-----------------------------------------------------------------------------------*/
function sig_head_css() {

	$output = '';
	$text_title = get_option('sig_texttitle');
    $custom_css = get_option('sig_custom_css');

	// Add CSS to output
	if ($text_title == "true") {
		$output .= '#logo img { display:none; }' . "\n";
		$output .= '#logo .site-title, #logo .site-description { display:block; } ' . "\n";
	} 
	
	if ($custom_css <> '') {
		$output .= $custom_css . "\n";
	}
	
	// Output styles
	if ($output <> '') {
		$output = "<!-- sig Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
		echo $output;
	}

}

?>