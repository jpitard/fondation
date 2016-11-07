<?php
// singletheme Admin Interface

/*-----------------------------------------------------------------------------------



/*-----------------------------------------------------------------------------------*/
/* singletheme Admin Interface - singletheme_add_admin */
/*-----------------------------------------------------------------------------------*/

// Load static framework options pages 
$functions_path = TEMPLATEPATH . '/functions/';





function singletheme_add_admin() {

    global $query_string;
    global $current_user;
    $current_user_id = $current_user->ID;
    $super_user = get_option('framework_sig_super_user');
    
    
    $shortname =  get_option('sig_shortname'); 
   
    if ( isset($_REQUEST['page']) && $_REQUEST['page'] == 'singletheme' ) {
		if (isset($_REQUEST['sig_save']) && 'reset' == $_REQUEST['sig_save']) {

			$options =  get_option('sig_template'); 
			sig_reset_options($options);
			header("Location: admin.php?page=singletheme&reset=true");
			die;
		}
    }
  

    
    // Check all the Options, then if the no options are created for a relative sub-page... it's not created.
	$icon = get_bloginfo('template_url'). '/functions/images/theme-icon.png';
	
   
  
    $sigpage = add_object_page ('Non-Profit Theme Options', 'Non-Profit', 8,'singletheme', 'singletheme_options_page', $icon);
  
	


	
	// Add framework functionaily to the head individually
	add_action("admin_print_scripts-$sigpage", 'sig_load_only');
	add_action("admin_print_scripts-$sigframeworksettings", 'sig_load_only');
	

     
} 

add_action('admin_menu', 'singletheme_add_admin');

/*-----------------------------------------------------------------------------------*/
/* singletheme Reset Function - sig_reset_options */
/*-----------------------------------------------------------------------------------*/

function sig_reset_options($options){

	global $wpdb;
	$query_inner = '';
	$count = 0;
	
	$excludes = array( 'blogname' , 'blogdescription' );
	
	
	foreach($options as $option){
			
		if(isset($option['id'])){ 
			$count++;
			$option_id = $option['id'];
			$option_type = $option['type'];
			
			//Skip assigned id's
			if(in_array($option_id,$excludes)) { continue; }
			
			if($count > 1){ $query_inner .= ' OR '; }
			if($option_type == 'multicheck'){
				$multicount = 0;
				foreach($option['options'] as $option_key => $option_option){
					$multicount++;
					if($multicount > 1){ $query_inner .= ' OR '; }
					$query_inner .= "option_name = '" . $option_id . "_" . $option_key . "'";
					
				}
				
			} else if(is_array($option_type)) {
				$type_array_count = 0;
				foreach($option_type as $inner_option){
					$type_array_count++;
					$option_id = $inner_option['id'];
					if($type_array_count > 1){ $query_inner .= ' OR '; }
					$query_inner .= "option_name = '$option_id'";
				}
				
			} else {
				$query_inner .= "option_name = '$option_id'";
			}
		}
			
	}
	
	//echo $query_inner;
	
	$query = "DELETE FROM $wpdb->options WHERE $query_inner";
	$wpdb->query($query);
		
}




/*-----------------------------------------------------------------------------------*/
/* Framework options panel - singletheme_options_page */
/*-----------------------------------------------------------------------------------*/

function singletheme_options_page(){

    $options =  get_option('sig_template');      
    $themename =  get_option('sig_themename');   
	$themeversion =  get_option('sig_themeversion');    
    $shortname =  get_option('sig_shortname');
    $manualurl =  get_option('sig_manual'); 
   
  
    
    
    //GET themes update RSS feed and do magic
	include_once(ABSPATH . WPINC . '/feed.php');
	
	$pos = strpos($manualurl, 'documentation');
	$theme_slug = str_replace("/", "", substr($manualurl, ($pos + 13))); //13 for the word documentation

	//add filter to make the rss read cache clear every 4 hours
	//add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 14400;' ) );
	
?>
 <script type="text/javascript" src="../wp-includes/js/tinymce/tiny_mce.js"></script>
 
         <?php
wp_tiny_mce( false , // true makes the editor "teeny"
	array(
		'theme' => 'advanced',
		'skin' => 'default',
		'theme_advanced_resizing' => 'false',
		'theme_advanced_path' => 'false',
		'theme_advanced_buttons2' => '',
		'theme_advanced_buttons1' => 'code,bold,italic,underline,|,justifyleft,justifycenter,justifyright,forecolor,fontsizeselect,link,unlink,image', 'width' => '650px'
		
		

		

		
		
		


	)
);


?>
<script type="text/javascript">/* <![CDATA[ */
		jQuery(function($)
		{
			var i=1;
			$('.custosigitor2 textarea').each(function(e)
			{
				var id = $(this).attr('id');
 
				if (!id)
				{
					id = 'custosigitor2-' + i++;
					$(this).attr('id',id);
				}
 
				tinyMCE.execCommand('mceAddControl', false, id);
 
			});
		});
	/* ]]> */</script>
    
<div class="wrap" id="sig_container">
<div id="sig-popup-save" class="sig-save-popup"><div class="sig-save-save">Options Updated</div></div>
<div id="sig-popup-reset" class="sig-save-popup"><div class="sig-save-reset">Options Reset</div></div>
    <form action="" enctype="multipart/form-data" id="sigform">
        <div id="header">
          
            
			
		</div>
        <?php 
		// Rev up the Options Machine
        $return = singletheme_machine($options);
        ?>
		
        <div id="main">
	        <div id="sig-nav">
				<ul class="adnav">
					<?php echo $return[1] ?>
				</ul>		
			</div>
			<div id="content">
	         <?php echo $return[0]; /* Settings */ ?>
	        </div>
	        <div class="clear"></div>
	        
        </div>
        <div class="save_bar_top">
        <img style="display:none" src="<?php echo bloginfo('template_url'); ?>/functions/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
        <input type="submit" value="" class="button submit-button" />        
        </form>
     
        <form action="<?php echo wp_specialchars( $_SERVER['REQUEST_URI'] ) ?>" method="post" style="display:inline" id="sigform-reset">
            <span class="submit-footer-reset">
            <input name="reset" type="submit" value="" class="button submit-button reset-button" onclick="return confirm('Click OK to reset. Any settings will be lost!');" />
            <input type="hidden" name="sig_save" value="reset" /> 
            </span>
        </form>
       
        </div>
        <?php  if (!empty($update_message)) echo $update_message; ?>    

<div style="clear:both;"></div>    
</div><!--wrap-->

    
 



 <?php
}


/*-----------------------------------------------------------------------------------*/
/* sig_load_only */
/*-----------------------------------------------------------------------------------*/

function sig_load_only() {

	add_action('admin_head', 'sig_admin_head');
	
	wp_enqueue_script('jquery-ui-core');
	
	
	function sig_admin_head() { 
			
		echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/functions/admin-style.css" media="screen" />';
		
		 ?>
		<?php
		//AJAX Upload
		?>
		<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/functions/js/ajaxupload.js"></script>
        
		<script type="text/javascript">
			jQuery(document).ready(function(){
			
			var flip = 0;
				
			jQuery('#expand_options').click(function(){
				if(flip == 0){
					flip = 1;
					jQuery('#sig_container #sig-nav').hide();
					jQuery('#sig_container #content').width(755);
					jQuery('#sig_container .group').add('#sig_container .group h2').show();
	
					jQuery(this).text('[-]');
					
				} else {
					flip = 0;
					jQuery('#sig_container #sig-nav').show();
					jQuery('#sig_container #content').width(595);
					jQuery('#sig_container .group').add('#sig_container .group h2').hide();
					jQuery('#sig_container .group:first').show();
					jQuery('#sig_container #sig-nav li').removeClass('current');
					jQuery('#sig_container #sig-nav li:first').addClass('current');
					
					jQuery(this).text('[+]');
				
				}
			
			});
			
				jQuery('.group').hide();
				jQuery('.group:first').fadeIn();
				
				jQuery('.group .collapsed input:checked').parent().parent().parent().nextAll().removeClass('hidden');
				jQuery('.group .collapsed input:checkbox').click(unhideHidden);
				
				function unhideHidden(){
					if (jQuery(this).attr('checked')) {
						jQuery(this).parent().parent().parent().nextAll().removeClass('hidden');
					}
					else {
						jQuery(this).parent().parent().parent().nextAll().addClass('hidden');
					}
				}
				
				jQuery('.sig-radio-img-img').click(function(){
					jQuery(this).parent().parent().find('.sig-radio-img-img').removeClass('sig-radio-img-selected');
					jQuery(this).addClass('sig-radio-img-selected');
					
				});
				jQuery('.sig-radio-img-label').hide();
				jQuery('.sig-radio-img-img').show();
				jQuery('.sig-radio-img-radio').hide();
				jQuery('#sig-nav li:first').addClass('current');
				jQuery('#sig-nav li a').click(function(evt){
				
						jQuery('#sig-nav li').removeClass('current');
						jQuery(this).parent().addClass('current');
						
						var clicked_group = jQuery(this).attr('href');
		 
						jQuery('.group').hide();
						
							jQuery(clicked_group).fadeIn();
		
						evt.preventDefault();
						
					});
				
				if('<?php if(isset($_REQUEST['reset'])) { echo $_REQUEST['reset'];} else { echo 'false';} ?>' == 'true'){
					
					var reset_popup = jQuery('#sig-popup-reset');
					reset_popup.fadeIn();
					window.setTimeout(function(){
						   reset_popup.fadeOut();                        
						}, 2000);
						//alert(response);
					
				}
					
			//Update Message popup
			jQuery.fn.center = function () {
				this.animate({"top":( jQuery(window).height() - this.height() - 200 ) / 2+jQuery(window).scrollTop() + "px"},100);
				this.css("left", 250 );
				return this;
			}
		
			
			jQuery('#sig-popup-save').center();
			jQuery('#sig-popup-reset').center();
			jQuery(window).scroll(function() { 
			
				jQuery('#sig-popup-save').center();
				jQuery('#sig-popup-reset').center();
			
			});
			
			
		
			//AJAX Upload
			jQuery('.image_upload_button').each(function(){
			
			var clickedObject = jQuery(this);
			var clickedID = jQuery(this).attr('id');	
			new AjaxUpload(clickedID, {
				  action: '<?php echo admin_url("admin-ajax.php"); ?>',
				  name: clickedID, // File upload name
				  data: { // Additional data to send
						action: 'sig_ajax_post_action',
						type: 'upload',
						data: clickedID },
				  autoSubmit: true, // Submit file after selection
				  responseType: false,
				  onChange: function(file, extension){},
				  onSubmit: function(file, extension){
						clickedObject.text('Uploading'); // change button text, when user selects file	
						this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
						interval = window.setInterval(function(){
							var text = clickedObject.text();
							if (text.length < 13){	clickedObject.text(text + '.'); }
							else { clickedObject.text('Uploading'); } 
						}, 200);
				  },
				  onComplete: function(file, response) {
				   
					window.clearInterval(interval);
					clickedObject.text('Upload Image');	
					this.enable(); // enable upload button
					
					// If there was an error
					if(response.search('Upload Error') > -1){
						var buildReturn = '<span class="upload-error">' + response + '</span>';
						jQuery(".upload-error").remove();
						clickedObject.parent().after(buildReturn);
					
					}
					else{
						var buildReturn = '<img class="hide sig-option-image" id="image_'+clickedID+'" src="'+response+'" alt="" />';

						jQuery(".upload-error").remove();
						jQuery("#image_" + clickedID).remove();	
						clickedObject.parent().after(buildReturn);
						jQuery('img#image_'+clickedID).fadeIn();
						clickedObject.next('span').fadeIn();
						clickedObject.parent().prev('input').val(response);
					}
				  }
				});
			
			});
			
			//AJAX Remove (clear option value)
			jQuery('.image_reset_button').click(function(){
			
					var clickedObject = jQuery(this);
					var clickedID = jQuery(this).attr('id');
					var theID = jQuery(this).attr('title');	
	
					var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
				
					var data = {
						action: 'sig_ajax_post_action',
						type: 'image_reset',
						data: theID
					};
					
					jQuery.post(ajax_url, data, function(response) {
						var image_to_remove = jQuery('#image_' + theID);
						var button_to_hide = jQuery('#reset_' + theID);
						image_to_remove.fadeOut(500,function(){ jQuery(this).remove(); });
						button_to_hide.fadeOut();
						clickedObject.parent().prev('input').val('');
						
						
						
					});
					
					return false; 
					
				});   	 	
	
	
		
			//Save everything else
			jQuery('#sigform').submit(function(){
											   
											   tinyMCE.triggerSave(true,true);

											   
											 
				
					function newValues() {
						

					  var serializedValues = jQuery("#sigform").serialize();
					  
					     
					  
					  return serializedValues;
					  
					}
					
					jQuery(":checkbox, :radio").click(newValues);
					jQuery("select").change(newValues);
					jQuery('.ajax-loading-img').fadeIn();
					var serializedReturn = newValues();
					
					 
					var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
				
					 //var data = {data : serializedReturn};
					var data = {
						<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'singletheme'){ ?>
						type: 'options',
						<?php } ?>
						
						<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'singletheme_framework_settings'){ ?>
						type: 'framework',
						<?php } ?>
						
					

						action: 'sig_ajax_post_action',
						data: serializedReturn
					};
					
					jQuery.post(ajax_url, data, function(response) {
						var success = jQuery('#sig-popup-save');
						var loading = jQuery('.ajax-loading-img');
						loading.fadeOut();  
						success.fadeIn();
						window.setTimeout(function(){
						   success.fadeOut(); 
						   
												
						}, 2000);
					});
					
					return false; 
					
				});   	 	
				
			});
		</script>
        
     
		
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Ajax Save Action - sig_ajax_callback */
/*-----------------------------------------------------------------------------------*/

add_action('wp_ajax_sig_ajax_post_action', 'sig_ajax_callback');

function sig_ajax_callback() {
	global $wpdb; // this is how you get access to the database
	
		
	$save_type = $_POST['type'];
	//Uploads
	if($save_type == 'upload'){
		
		$clickedID = $_POST['data']; // Acts as the name
		$filename = $_FILES[$clickedID];
       	$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 
		
		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';    
		$uploaded_file = wp_handle_upload($filename,$override);
		 
				$upload_tracking[] = $clickedID;
				update_option( $clickedID , $uploaded_file['url'] );
				
		 if(!empty($uploaded_file['error'])) {echo 'Upload Error: ' . $uploaded_file['error']; }	
		 else { echo $uploaded_file['url']; } // Is the Response
	}
	elseif($save_type == 'image_reset'){
			
			$id = $_POST['data']; // Acts as the name
			global $wpdb;
			$query = "DELETE FROM $wpdb->options WHERE option_name LIKE '$id'";
			$wpdb->query($query);
	
	}	
	elseif ($save_type == 'options' OR $save_type == 'seo' OR $save_type == 'framework') {
		$data = $_POST['data'];
		
		parse_str($data,$output);
		print_r($output);
		
        $options = get_option('sig_template');
		

				
		foreach($options as $option_array){

			$id = $option_array['id'];
			$old_value = get_option($id);
			$new_value = '';
			
			if(isset($output[$id])){
			//Ensure textarea2 tinymce elements get proper paragraph formmating
				if ($option_array['type'] == "textarea2") {$new_value = wpautop($new_value = $output[$option_array['id']]);} else {$new_value = $output[$option_array['id']];}

			}
	
			if(isset($option_array['id'])) { // Non - Headings...
				
				if($id == 'framework_sig_import_options'){
					
					//Decode and over write options.
					$new_import = base64_decode($new_value);
					$new_import = unserialize($new_import);
					
					echo '<pre>';
					print_r($new_import);
					echo '</pre>';
					if(!empty($new_import)) {
						foreach($new_import as $id2 => $value2){
							if(is_serialized($value2)) {
								update_option($id2,unserialize($value2));
							} else {
								update_option($id2,$value2);
							}
						}
					}
					
				} else {
			
					$type = $option_array['type'];
					
					if ( is_array($type)){
						foreach($type as $array){
							if($array['type'] == 'text'){
								$id = $array['id'];
								$new_value = $output[$id];
								update_option( $id, stripslashes($new_value));
							}
						}                 
					}
					elseif($new_value == '' && $type == 'checkbox'){ // Checkbox Save
						
						update_option($id,'false');
					}
					elseif ($new_value == 'true' && $type == 'checkbox'){ // Checkbox Save
						
						update_option($id,'true');
					}
					elseif($type == 'multicheck'){ // Multi Check Save
						
						$option_options = $option_array['options'];
						
						foreach ($option_options as $options_id => $options_value){
							
							$multicheck_id = $id . "_" . $options_id;
							
							if(!isset($output[$multicheck_id])){
							  update_option($multicheck_id,'false');
							}
							else{
							   update_option($multicheck_id,'true'); 
							}
						}
					} 
					elseif($type == 'typography'){
							
						$typography_array = array();	
						
						$typography_array['size'] = $output[$option_array['id'] . '_size'];
							
						$typography_array['face'] = stripslashes($output[$option_array['id'] . '_face']);
							
						$typography_array['style'] = $output[$option_array['id'] . '_style'];
							
						$typography_array['color'] = $output[$option_array['id'] . '_color'];
							
						update_option($id,$typography_array);
							
					}
					elseif($type == 'border'){
							
						$border_array = array();	
						
						$border_array['width'] = $output[$option_array['id'] . '_width'];
							
						$border_array['style'] = $output[$option_array['id'] . '_style'];
							
						$border_array['color'] = $output[$option_array['id'] . '_color'];
							
						update_option($id,$border_array);
							
					}
					elseif($type != 'upload_min'){
					
						update_option($id,stripslashes($new_value));
					}
				}
			}	
		}
	}
	
	
	if( $save_type == 'options' ){
		/* Create, Encrypt and Update the Saved Settings */
		global $wpdb;
		//$options = get_option('sig_template');
		$sig_options = array();
		$query_inner = '';
		$count = 0;
		foreach($options as $option){
			
			if(isset($option['id'])){ 
				$count++;
				$option_id = $option['id'];
				$option_type = $option['type'];
				
				if($count > 1){ $query_inner .= ' OR '; }
				
				if(is_array($option_type)) {
				$type_array_count = 0;
				foreach($option_type as $inner_option){
					$type_array_count++;
					$option_id = $inner_option['id'];
					if($type_array_count > 1){ $query_inner .= ' OR '; }
					$query_inner .= "option_name = '$option_id'";
					}
				}
				else {
				
					$query_inner .= "option_name = '$option_id'";
					
				}
			}
			
		}
		
		$query = "SELECT * FROM $wpdb->options WHERE $query_inner";
				
		$results = $wpdb->get_results($query);
		
		$output = "<ul>";
		
		foreach ($results as $result){
				$name = $result->option_name;
				$value = $result->option_value;
				
				if(is_serialized($value)) {
					
					$value = unserialize($value);
					$sig_array_option = $value;
					$temp_options = '';
					foreach($value as $v){
						if(isset($v))
							$temp_options .= $v . ',';
						
					}	
					$value = $temp_options;
					$sig_array[$name] = $sig_array_option;
				} else {
					$sig_array[$name] = $value;
				}
				
				$output .= '<li><strong>' . $name . '</strong> - ' . $value . '</li>';
		}
		$output .= "</ul>";
		$output = base64_encode($output);
update_option('sig_options',$sig_array);
		update_option('sig_settings_encode',$output);
		
				//Set a variable with button link id, so link remains if page name changed.
$a1 = get_option('sig_more_link');
global $wpdb;
$a2 = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '".$a1."'");

update_option('sig_more_linky',$a2); 
	
	}



  die();

}



/*-----------------------------------------------------------------------------------*/
/* Generates The Options - singletheme_machine */
/*-----------------------------------------------------------------------------------*/

function singletheme_machine($options) {
        
    $counter = 0;
	$menu = '';
	$output = '';
	foreach ($options as $value) {
	   
		$counter++;
		$val = '';
		//Start Heading
		 if ( $value['type'] != "heading" )
		 {
		 	$class = ''; if(isset( $value['class'] )) $class = $value['class'];
			//$output .= '<div class="section section-'. $value['type'] .'">'."\n".'<div class="option-inner">'."\n";
			$output .= '<div class="section section-'.$value['type'].' '. $class .'">'."\n";
			$output .= '<h3 class="heading">'. $value['name'] .'</h3>'."\n";
			$output .= '<div class="option">'."\n" . '<div class="controls">'."\n";

		 } 
		 //End Heading
		$select_value = '';                                   
		switch ( $value['type'] ) {
		
		case 'text':
			$val = $value['std'];
			$std = get_option($value['id']);
			if ( $std != "") { $val = $std; }
			$output .= '<input class="sig-input" name="'. $value['id'] .'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $val .'" />';
		break;
		
		case 'select':

			$output .= '<select class="sig-input" name="'. $value['id'] .'" id="'. $value['id'] .'">';
		
			$select_value = get_option($value['id']);
			 
			foreach ($value['options'] as $option) {
				
				$selected = '';
				
				 if($select_value != '') {
					 if ( $select_value == $option) { $selected = ' selected="selected"';} 
			     } else {
					 if ( isset($value['std']) )
						 if ($value['std'] == $option) { $selected = ' selected="selected"'; }
				 }
				  
				 $output .= '<option'. $selected .'>';
				 $output .= $option;
				 $output .= '</option>';
			 
			 } 
			 $output .= '</select>';

			
		break;
		case 'select2':

			$output .= '<select class="sig-input" name="'. $value['id'] .'" id="'. $value['id'] .'">';
		
			$select_value = get_option($value['id']);
			 
			foreach ($value['options'] as $option => $name) {
				
				$selected = '';
				
				 if($select_value != '') {
					 if ( $select_value == $option) { $selected = ' selected="selected"';} 
			     } else {
					 if ( isset($value['std']) )
						 if ($value['std'] == $option) { $selected = ' selected="selected"'; }
				 }
				  
				 $output .= '<option'. $selected .' value="'.$option.'">';
				 $output .= $name;
				 $output .= '</option>';
			 
			 } 
			 $output .= '</select>';

			
		break;
		case 'calendar':
		
			$val = $value['std'];
			$std = get_option($value['id']);
			if ( $std != "") { $val = $std; }
            $output .= '<input class="sig-input-calendar" type="text" name="'.$value['id'].'" id="'.$value['id'].'" value="'.$val.'">';
		
		break;
		case 'time':
			$val = $value['std'];
			$std = get_option($value['id']);
			if ( $std != "") { $val = $std; }
			$output .= '<input class="sig-input-time" name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. $val .'" />';
		break;

			
		case 'textarea':
			
			$cols = '8';
			$ta_value = '';
			
			if(isset($value['std'])) {
				
				$ta_value = $value['std']; 
				
				if(isset($value['options'])){
					$ta_options = $value['options'];
					if(isset($ta_options['cols'])){
					$cols = $ta_options['cols'];
					} else { $cols = '8'; }
				}
				
			}
				$std = get_option($value['id']);
				if( $std != "") { $ta_value = stripslashes( $std ); }
				$output .= '<div class="custosigitor"><textarea class="" name="'. $value['id'] .'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8">'.$ta_value.'</textarea></div>';
			
			
					break;

			
		case 'textarea2':
			
			$cols = '8';
			$ta_value = '';
			
			if(isset($value['std'])) {
				
				$ta_value = $value['std']; 
				
				if(isset($value['options'])){
					$ta_options = $value['options'];
					if(isset($ta_options['cols'])){
					$cols = $ta_options['cols'];
					} else { $cols = '8'; }
				}
				
			}
				$std = get_option($value['id']);
				if( $std != "") { $ta_value = stripslashes( $std ); }
				$output .= '<div class="custosigitor2"><textarea class="" name="'. $value['id'] .'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8">'.$ta_value.'</textarea></div>';
			
			
			
		break;
		case "radio":
			
			 $select_value = get_option( $value['id']);
				   
			 foreach ($value['options'] as $key => $option) 
			 { 

				 $checked = '';
				   if($select_value != '') {
						if ( $select_value == $key) { $checked = ' checked'; } 
				   } else {
					if ($value['std'] == $key) { $checked = ' checked'; }
				   }
				$output .= '<input class="sig-input sig-radio" type="radio" name="'. $value['id'] .'" value="'. $key .'" '. $checked .' />' . $option .'<br />';
			
			}
			 
		break;
		case "checkbox": 
		
		   $std = $value['std'];  
		   
		   $saved_std = get_option($value['id']);
		   
		   $checked = '';
			
			if(!empty($saved_std)) {
				if($saved_std == 'true') {
				$checked = 'checked="checked"';
				}
				else{
				   $checked = '';
				}
			}
			elseif( $std == 'true') {
			   $checked = 'checked="checked"';
			}
			else {
				$checked = '';
			}
			$output .= '<input type="checkbox" class="checkbox sig-input" name="'.  $value['id'] .'" id="'. $value['id'] .'" value="true" '. $checked .' />';

		break;
		case "multicheck":
		
			$std =  $value['std'];         
			
			foreach ($value['options'] as $key => $option) {
											 
			$sig_key = $value['id'] . '_' . $key;
			$saved_std = get_option($sig_key);
					
			if(!empty($saved_std)) 
			{ 
				  if($saved_std == 'true'){
					 $checked = 'checked="checked"';  
				  } 
				  else{
					  $checked = '';     
				  }    
			} 
			elseif( $std == $key) {
			   $checked = 'checked="checked"';
			}
			else {
				$checked = '';                                                                                    }
			$output .= '<input type="checkbox" class="checkbox sig-input" name="'. $sig_key .'" id="'. $sig_key .'" value="true" '. $checked .' /><label for="'. $sig_key .'">'. $option .'</label><br />';
										
			}
		break;
		case "upload":
			
			$output .= singletheme_uploader_function($value['id'],$value['std'],null);
			
		break;
		case "upload_min":
			
			$output .= singletheme_uploader_function($value['id'],$value['std'],'min');
			
		break;
		case "color":
			$val = $value['std'];
			$stored  = get_option( $value['id'] );
			if ( $stored != "") { $val = $stored; }
			$output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div></div></div>';
			$output .= '<input class="sig-color" name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. $val .'" />';
		break;   
		
		case "typography":
		
			$default = $value['std'];
			$typography_stored = get_option($value['id']);
			
			/* Font Size */
			$val = $default['size'];
			if ( $typography_stored['size'] != "") { $val = $typography_stored['size']; }
			$output .= '<select class="sig-typography sig-typography-size" name="'. $value['id'].'_size" id="'. $value['id'].'_size">';
				for ($i = 9; $i < 71; $i++){ 
					if($val == $i){ $active = 'selected="selected"'; } else { $active = ''; }
					$output .= '<option value="'. $i .'" ' . $active . '>'. $i .'px</option>'; }
			$output .= '</select>';
			
			/* Font Unit 
			$val = $default['unit'];
			if ( $typography_stored['unit'] != "") { $val = $typography_stored['unit']; }
				$em = ''; $px = '';
			if($val == 'em'){ $em = 'selected="selected"'; }
			if($val == 'px'){ $px = 'selected="selected"'; }
			$output .= '<select class="sig-typography sig-typography-unit" name="'. $value['id'].'_unit" id="'. $value['id'].'_unit">';
			$output .= '<option value="px '. $px .'">px</option>';
			$output .= '<option value="em" '. $em .'>em</option>';
			$output .= '</select>';
			*/
			
			/* Font Face */
			/* Font Face */
			$val = $default['face'];
			if ( $typography_stored['face'] != "") 
				$val = $typography_stored['face']; 

			$font01 = ''; 
			$font02 = ''; 
			$font03 = ''; 
			$font04 = ''; 
			$font05 = ''; 
			$font06 = ''; 
			$font07 = ''; 
			$font08 = '';
			$font09 = ''; 
			$font10 = '';
			$font11 = '';
			$font12 = '';
			$font13 = '';
			$font14 = '';
			$font15 = '';

			if (strpos($val, 'Arial, sans-serif') !== false){ $font01 = 'selected="selected"'; }
			if (strpos($val, 'Verdana, Geneva') !== false){ $font02 = 'selected="selected"'; }
			if (strpos($val, 'Trebuchet') !== false){ $font03 = 'selected="selected"'; }
			if (strpos($val, 'Georgia') !== false){ $font04 = 'selected="selected"'; }
			if (strpos($val, 'Times New Roman') !== false){ $font05 = 'selected="selected"'; }
			if (strpos($val, 'Tahoma, Geneva') !== false){ $font06 = 'selected="selected"'; }
			if (strpos($val, 'Palatino') !== false){ $font07 = 'selected="selected"'; }
			if (strpos($val, 'Helvetica') !== false){ $font08 = 'selected="selected"'; }
			if (strpos($val, 'Calibri') !== false){ $font09 = 'selected="selected"'; }
			if (strpos($val, 'Myriad') !== false){ $font10 = 'selected="selected"'; }
			if (strpos($val, 'Lucida') !== false){ $font11 = 'selected="selected"'; }
			if (strpos($val, 'Arial Black') !== false){ $font12 = 'selected="selected"'; }
			if (strpos($val, 'Gill') !== false){ $font13 = 'selected="selected"'; }
			if (strpos($val, 'Geneva, Tahoma') !== false){ $font14 = 'selected="selected"'; }
			if (strpos($val, 'Impact') !== false){ $font15 = 'selected="selected"'; }
			
			$output .= '<select class="sig-typography sig-typography-face" name="'. $value['id'].'_face" id="'. $value['id'].'_face">';
			$output .= '<option value="Arial, sans-serif" '. $font01 .'>Arial</option>';
			$output .= '<option value="Verdana, Geneva, sans-serif" '. $font02 .'>Verdana</option>';
			$output .= '<option value="&quot;Trebuchet MS&quot;, Tahoma, sans-serif"'. $font03 .'>Trebuchet</option>';
			$output .= '<option value="Georgia, serif" '. $font04 .'>Georgia</option>';
			$output .= '<option value="&quot;Times New Roman&quot;, serif"'. $font05 .'>Times New Roman</option>';
			$output .= '<option value="Tahoma, Geneva, Verdana, sans-serif"'. $font06 .'>Tahoma</option>';
			$output .= '<option value="Palatino, &quot;Palatino Linotype&quot;, serif"'. $font07 .'>Palatino</option>';
			$output .= '<option value="&quot;Helvetica Neue&quot;, Helvetica, sans-serif" '. $font08 .'>Helvetica*</option>';
			$output .= '<option value="Calibri, Candara, Segoe, Optima, sans-serif"'. $font09 .'>Calibri*</option>';
			$output .= '<option value="&quot;Myriad Pro&quot;, Myriad, sans-serif"'. $font10 .'>Myriad Pro*</option>';
			$output .= '<option value="&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, sans-serif"'. $font11 .'>Lucida</option>';
			$output .= '<option value="&quot;Arial Black&quot;, sans-serif" '. $font12 .'>Arial Black</option>';
			$output .= '<option value="&quot;Gill Sans&quot;, &quot;Gill Sans MT&quot;, Calibri, sans-serif" '. $font13 .'>Gill Sans*</option>';
			$output .= '<option value="Geneva, Tahoma, Verdana, sans-serif" '. $font14 .'>Geneva*</option>';
			$output .= '<option value="Impact, Charcoal, sans-serif" '. $font15 .'>Impact</option>';
			$output .= '</select>';
			
			/* Font Weight */
			$val = $default['style'];
			if ( $typography_stored['style'] != "") { $val = $typography_stored['style']; }
				$normal = ''; $italic = ''; $bold = ''; $bolditalic = '';
			if($val == 'normal'){ $normal = 'selected="selected"'; }
			if($val == 'italic'){ $italic = 'selected="selected"'; }
			if($val == 'bold'){ $bold = 'selected="selected"'; }
			if($val == 'bold italic'){ $bolditalic = 'selected="selected"'; }
			
			$output .= '<select class="sig-typography sig-typography-style" name="'. $value['id'].'_style" id="'. $value['id'].'_style">';
			$output .= '<option value="normal" '. $normal .'>Normal</option>';
			$output .= '<option value="italic" '. $italic .'>Italic</option>';
			$output .= '<option value="bold" '. $bold .'>Bold</option>';
			$output .= '<option value="bold italic" '. $bolditalic .'>Bold/Italic</option>';
			$output .= '</select>';
			
			/* Font Color */
			$val = $default['color'];
			if ( $typography_stored['color'] != "") { $val = $typography_stored['color']; }			
			$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div></div></div>';
			$output .= '<input class="sig-color sig-typography sig-typography-color" name="'. $value['id'] .'_color" id="'. $value['id'] .'_color" type="text" value="'. $val .'" />';

		break;  
		
		case "border":
		
			$default = $value['std'];
			$border_stored = get_option( $value['id'] );
			
			/* Border Width */
			$val = $default['width'];
			if ( $border_stored['width'] != "") { $val = $border_stored['width']; }
			$output .= '<select class="sig-border sig-border-width" name="'. $value['id'].'_width" id="'. $value['id'].'_width">';
				for ($i = 0; $i < 21; $i++){ 
					if($val == $i){ $active = 'selected="selected"'; } else { $active = ''; }
					$output .= '<option value="'. $i .'" ' . $active . '>'. $i .'px</option>'; }
			$output .= '</select>';
			
			/* Border Style */
			$val = $default['style'];
			if ( $border_stored['style'] != "") { $val = $border_stored['style']; }
				$solid = ''; $dashed = ''; $dotted = '';
			if($val == 'solid'){ $solid = 'selected="selected"'; }
			if($val == 'dashed'){ $dashed = 'selected="selected"'; }
			if($val == 'dotted'){ $dotted = 'selected="selected"'; }
			
			$output .= '<select class="sig-border sig-border-style" name="'. $value['id'].'_style" id="'. $value['id'].'_style">';
			$output .= '<option value="solid" '. $solid .'>Solid</option>';
			$output .= '<option value="dashed" '. $dashed .'>Dashed</option>';
			$output .= '<option value="dotted" '. $dotted .'>Dotted</option>';
			$output .= '</select>';
			
			/* Border Color */
			$val = $default['color'];
			if ( $border_stored['color'] != "") { $val = $border_stored['color']; }			
			$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div></div></div>';
			$output .= '<input class="sig-color sig-border sig-border-color" name="'. $value['id'] .'_color" id="'. $value['id'] .'_color" type="text" value="'. $val .'" />';

		break;   
		
		case "images":
			$i = 0;
			$select_value = get_settings( $value['id']);
				   
			foreach ($value['options'] as $key => $option) 
			 { 
			 $i++;

				 $checked = '';
				 $selected = '';
				   if($select_value != '') {
						if ( $select_value == $key) { $checked = ' checked'; $selected = 'sig-radio-img-selected'; } 
				    } else {
						if ($value['std'] == $key) { $checked = ' checked'; $selected = 'sig-radio-img-selected'; }
						elseif ($i == 1  && !isset($select_value)) { $checked = ' checked'; $selected = 'sig-radio-img-selected'; }
						elseif ($i == 1  && $value['std'] == '') { $checked = ' checked'; $selected = 'sig-radio-img-selected'; }
						else { $checked = ''; }
					}	
				
				$output .= '<span>';
				$output .= '<input type="radio" id="sig-radio-img-' . $value['id'] . $i . '" class="checkbox sig-radio-img-radio" value="'.$key.'" name="'. $value['id'].'" '.$checked.' />';
				$output .= '<div class="sig-radio-img-label">'. $key .'</div>';
				$output .= '<img src="'.$option.'" alt="" class="sig-radio-img-img '. $selected .'" onClick="document.getElementById(\'sig-radio-img-'. $value['id'] . $i.'\').checked = true;" />';
				$output .= '</span>';
				
			}
		
		break; 
		
		case "info":
			$default = $value['std'];
			$output .= $default;
		break;                                   
		
		case "heading":
			
			if($counter >= 2){
			   $output .= '</div>'."\n";
			}
			$jquery_click_hook = ereg_replace("[^A-Za-z0-9]", "", strtolower($value['name']) );
			$jquery_click_hook = "sig-option-" . $jquery_click_hook;
//			$jquery_click_hook = "sig-option-" . str_replace("&","",str_replace("/","",str_replace(".","",str_replace(")","",str_replace("(","",str_replace(" ","",strtolower($value['name'])))))));
			$menu .= '<li class="'.  $value['name'] .'"><a title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'">'.  $value['name'] .'</a></li>';
			$output .= '<div class="group" id="'. $jquery_click_hook  .'"><h2>'.$value['name'].'</h2>'."\n";
		break;                                  
		} 
		
		// if TYPE is an array, formatted into smaller inputs... ie smaller values
		if ( is_array($value['type'])) {
			foreach($value['type'] as $array){
			
					$id =   $array['id']; 
					$std =   $array['std'];
					$saved_std = get_option($id);
					if($saved_std != $std && !empty($saved_std) ){$std = $saved_std;} 
					$meta =   $array['meta'];
					
					if($array['type'] == 'text') { // Only text at this point
						 
						 $output .= '<input class="input-text-small sig-input" name="'. $id .'" id="'. $id .'" type="text" value="'. $std .'" />';  
						 $output .= '<span class="meta-two">'.$meta.'</span>';
					}
				}
		}
		if ( $value['type'] != "heading" ) { 
			if ( $value['type'] != "checkbox" ) 
				{ 
				$output .= '<br/>';
				}
			$output .= '</div><div class="explain">'. $value['desc'] .'</div>'."\n";
			$output .= '<div class="clear"> </div></div></div>'."\n";
			}
	   
	}
    $output .= '</div>';
    return array($output,$menu);

}



/*-----------------------------------------------------------------------------------*/
/* singletheme Uploader - singletheme_uploader_function */
/*-----------------------------------------------------------------------------------*/

function singletheme_uploader_function($id,$std,$mod){

    //$uploader .= '<input type="file" id="attachement_'.$id.'" name="attachement_'.$id.'" class="upload_input"></input>';
    //$uploader .= '<span class="submit"><input name="save" type="submit" value="Upload" class="button upload_save" /></span>';
    
	$uploader = '';
    $upload = get_option($id);
	
	if($mod != 'min') { 
			$val = $std;
            if ( get_option( $id ) != "") { $val = get_option($id); }
            $uploader .= '<input class="sig-input" name="'. $id .'" id="'. $id .'_upload" type="text" value="'. $val .'" />';
	}
	
	$uploader .= '<div class="upload_button_div"><span class="button image_upload_button" id="'.$id.'">Upload Image</span>';
	
	if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
	
	$uploader .= '<span class="button image_reset_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
	$uploader .='</div>' . "\n";
    $uploader .= '<div class="clear"></div>' . "\n";
	if(!empty($upload)){
		//$upload = cleanSource($upload); // Removed since V.2.3.7 it's not showing up
    	$uploader .= '<a class="sig-uploaded-image" href="'. $upload . '">';
    	$uploader .= '<img class="sig-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
    	$uploader .= '</a>';
		}
	$uploader .= '<div class="clear"></div>' . "\n"; 


return $uploader;
}

/*-----------------------------------------------------------------------------------*/
/* slide_uploader_function */
/*-----------------------------------------------------------------------------------*/


function slide_uploader_function($id,$std,$mod){

    
	global $meta_box, $post;
	$uploader = '';
    $upload = get_post_meta($post->ID, 'slide_image', true);
	
	if($mod != 'min') { 
			$val = $std;
            if ( get_post_meta($post->ID, 'slide_image', true) != "") { $val = get_post_meta($post->ID, 'slide_image', true); }
            $uploader .= '<input class="sig-input" name="'. $id .'" id="'. $id .'_upload" type="text" value="'. $val .'" />'; }
	
	$uploader .= '<div class="slide_upload_button_div"><span class="button image_upload_button" id="'.$id.'">Upload Image</span>';
	if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
	
	$uploader .= '<span class="button image_reset_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
	$uploader .='</div>' . "\n";
    $uploader .= '<div class="clear"></div>' . "\n";
	if(!empty($upload)){
	
    	
    	$uploader .= '<img width="100px;" border="1" class="sig-slide-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
    
		}
	$uploader .= '<div class="clear"></div>' . "\n"; 


return $uploader;
}

 



/*-----------------------------------------------------------------------------------*/
/* singletheme Theme Version Checker - singletheme_version_checker */
/* @local_version is the installed theme version number */
/*-----------------------------------------------------------------------------------*/


function singletheme_version_checker ($local_version) {

	function do_not_cache_feeds(&$feed) {
		$feed->enable_cache(false);
	}
	add_action( 'wp_feed_options', 'do_not_cache_feeds' );

	// Get a SimplePie feed object from the specified feed source.
	$theme_name = str_replace("-","",strtolower(get_option('sig_themename')));
	$feed_url = 'http://www.singletheme.com/?feed=updates&theme=' . $theme_name;

	$rss = fetch_feed($feed_url);
	
	// Of the RSS is failed somehow.
	if ( is_wp_error($rss) ) {
								
		$error = $rss->get_error_code();
		
		$update_message = '<div class="update_available">Update notifier failed (<code>'.$error.'</code>)</div>';
	
		return $update_message;
	
	}
	
	//Figure out how many total items there are, but limit it to 5. 
	$maxitems = $rss->get_item_quantity(100); 
		
	// Build an array of all the items, starting with element 0 (first element).
	$rss_items = $rss->get_items(0, $maxitems); 
	if ($maxitems == 0) { $latest_version_via_rss = 0; }
		else {
		// Loop through each feed item and display each item as a hyperlink.
		foreach ( $rss_items as $item ) : 
			$latest_version_via_rss = $item->get_title();
		endforeach; 
	}
	//Check if version is the latest - assume standard structure x.x.x
	$pieces_rss = explode(".", $latest_version_via_rss);
	$pieces_local = explode(".", $local_version);
	//account for null values in second position x.2.x
	
	if(isset($pieces_rss[0]) && $pieces_rss[0] != 0) {
	
		if (!isset($pieces_rss[1])) 
			$pieces_rss[1] = '0';
		
		if (!isset($pieces_local[1]))
			$pieces_local[1] = '0';
		
		//account for null values in third position x.x.3
		if (!isset($pieces_rss[2]))
			$pieces_rss[2] = '0';
		
		
		if (!isset($pieces_local[2])) 
			$pieces_local[2] = '0';
		
	
		//do the comparisons
		$version_sentinel = false;

		if ($pieces_rss[0] > $pieces_local[0]) {
			$version_sentinel = true;
		}
		if (($pieces_rss[1] > $pieces_local[1]) AND ($version_sentinel == false) AND ($pieces_rss[0] == $pieces_local[0])) {
			$version_sentinel = true;
		}
		if (($pieces_rss[2] > $pieces_local[2]) AND ($version_sentinel == false) AND ($pieces_rss[0] == $pieces_local[0]) AND ($pieces_rss[1] == $pieces_local[1])) {
			$version_sentinel = true;
		}
		
		//set version checker message
		if ($version_sentinel == true) {
			$update_message = '<div class="update_available">Theme update is available (v.' . $latest_version_via_rss . ') - <a href="http://www.racktheme.com">Get the new version</a>.</div>';
		}
		else {
			$update_message = '';
		}
	} else {
			$update_message = '';
	}
	 
	return $update_message;

}

/* Load Ajax upload javascript if editing a slide */
function add_ajax_upload() {
  global $post_type; if (($_GET['post_type'] == 'slides') || ($post_type == 'slides'))  { 
	?>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/functions/admin-style.css" media="screen" />	
		
		
		<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/functions/js/ajaxupload.js"></script>
        
		<script type="text/javascript">
			jQuery(document).ready(function(){
			//AJAX Upload
			jQuery('.image_upload_button').each(function(){
			
			var clickedObject = jQuery(this);
			var clickedID = jQuery(this).attr('id');	
			new AjaxUpload(clickedID, {
				  action: '<?php echo admin_url("admin-ajax.php"); ?>',
				  name: clickedID, // File upload name
				  data: { // Additional data to send
						action: 'sig_ajax_post_action',
						type: 'upload',
						data: clickedID },
				  autoSubmit: true, // Submit file after selection
				  responseType: false,
				  onChange: function(file, extension){},
				  onSubmit: function(file, extension){
						clickedObject.text('Uploading'); // change button text, when user selects file	
						this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
						interval = window.setInterval(function(){
							var text = clickedObject.text();
							if (text.length < 13){	clickedObject.text(text + '.'); }
							else { clickedObject.text('Uploading'); } 
						}, 200);
				  },
				  onComplete: function(file, response) {
				   
					window.clearInterval(interval);
					clickedObject.text('Upload Image');	
					this.enable(); // enable upload button
					
					// If there was an error
					if(response.search('Upload Error') > -1){
						var buildReturn = '<span class="upload-error">' + response + '</span>';
						jQuery(".upload-error").remove();
						clickedObject.parent().after(buildReturn);
					
					}
					else{
						var buildReturn = '<img class="hide sig-option-image" id="image_'+clickedID+'" src="'+response+'" alt="" />';

						jQuery(".upload-error").remove();
						jQuery("#image_" + clickedID).remove();	
						clickedObject.parent().after(buildReturn);
						jQuery('img#image_'+clickedID).fadeIn();
						clickedObject.next('span').fadeIn();
						clickedObject.parent().prev('input').val(response);
					}
				  }
				});
			
			});
			
			//AJAX Remove (clear option value)
			jQuery('.image_reset_button').click(function(){
			
					var clickedObject = jQuery(this);
					var clickedID = jQuery(this).attr('id');
					var theID = jQuery(this).attr('title');	
	
					var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
				
					var data = {
						action: 'sig_ajax_post_action',
						type: 'image_reset',
						data: theID
					};
					
					jQuery.post(ajax_url, data, function(response) {
						var image_to_remove = jQuery('#image_' + theID);
						var button_to_hide = jQuery('#reset_' + theID);
						image_to_remove.fadeOut(500,function(){ jQuery(this).remove(); });
						button_to_hide.fadeOut();
						clickedObject.parent().prev('input').val('');
						
						
						
					});
					
					return false; 
					
				});   	 	
});
		</script>
   <?php      
     }
}

add_action('admin_head', 'add_ajax_upload');
?>