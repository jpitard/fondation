<?php
/*-----------------------------------------------------------------------------------

- Loads all the .php files found in /includes/widgets/ directory

----------------------------------------------------------------------------------- */

    $med_widgets_dir = ABSPATH . "wp-content/themes/".get_option('template')."/includes/widgets/";
	$med_widgets_dh = opendir($med_widgets_dir);
	
  	while (($med_widgets_file = readdir($med_widgets_dh)) !== false) {
  	
			if(strpos($med_widgets_file,'.php') && $med_widgets_file != "widget-blank.php") {
				include_once($med_widgets_dir . $med_widgets_file);
			
		}
	
	}

	closedir($med_widgets_dh);
	
/*---------------------------------------------------------------------------------*/
/* Deregister Default Widgets */
/*---------------------------------------------------------------------------------*/



?>