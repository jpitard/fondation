<?php 

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Custom fields for WP write panel - lawthemes_metabox_create
- lawthemes_uploader_custom_fields
- lawthemes_metabox_handle
- lawthemes_metabox_add
- lawthemes_metabox_header

-----------------------------------------------------------------------------------*/



/*-----------------------------------------------------------------------------------*/
// Custom fields for WP write panel
// This code is protected under Creative Commons License: http://creativecommons.org/licenses/by-nc-nd/3.0/
/*-----------------------------------------------------------------------------------*/

function lawthemes_metabox_create() {
    global $post;
    $sig_metaboxes = get_option('sig_custom_template');
    
    $seo_metaboxes = get_option('sig_custom_seo_template');  
    
    if(!empty($seo_metaboxes)){
    	$sig_metaboxes = array_merge($sig_metaboxes,$seo_metaboxes);
    }

    $output = '';
    $output .= '<table class="sig_metaboxes_table">'."\n";
    foreach ($sig_metaboxes as $sig_id => $sig_metabox) {
    if(        
                $sig_metabox['type'] == 'text' 
		OR      $sig_metabox['type'] == 'select' 
		OR      $sig_metabox['type'] == 'checkbox' 
		OR      $sig_metabox['type'] == 'textarea'
		OR      $sig_metabox['type'] == 'calendar'
		OR      $sig_metabox['type'] == 'time'
		OR      $sig_metabox['type'] == 'radio'
		OR      $sig_metabox['type'] == 'images') {
            $sig_metaboxvalue = get_post_meta($post->ID,$sig_metabox["name"],true);
			}
            
            if (empty($sig_metaboxvalue) && isset($sig_metabox['std'])) {
                $sig_metaboxvalue = $sig_metabox['std'];
            }

            if($sig_metabox['type'] == 'text'){
            
                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="sig_metabox_names"><label for="'.$sig_id.'">'.$sig_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td><input class="sig_input_text" type="'.$sig_metabox['type'].'" value="'.$sig_metaboxvalue.'" name="lawthemes_'.$sig_metabox["name"].'" id="'.$sig_id.'"/>';
                $output .= '<span class="sig_metabox_desc">'.$sig_metabox['desc'].'</span></td>'."\n";
                $output .= "\t".'<td></td></tr>'."\n";  
                              
            }
            
            elseif ($sig_metabox['type'] == 'textarea'){
            
                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="sig_metabox_names"><label for="'.$sig_metabox.'">'.$sig_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td><textarea class="sig_input_textarea" name="lawthemes_'.$sig_metabox["name"].'" id="'.$sig_id.'">' . $sig_metaboxvalue . '</textarea>';
                $output .= '<span class="sig_metabox_desc">'.$sig_metabox['desc'].'</span></td>'."\n";
                $output .= "\t".'<td></td></tr>'."\n";  
                              
            }
            
            elseif ($sig_metabox['type'] == 'calendar'){
            	
                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="sig_metabox_names"><label for="'.$sig_metabox.'">'.$sig_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td><input class="sig_input_calendar" type="text" name="lawthemes_'.$sig_metabox["name"].'" id="'.$sig_id.'" value="'.$sig_metaboxvalue.'">';
                $output .= '<span class="sig_metabox_desc">'.$sig_metabox['desc'].'</span></td>'."\n";
                $output .= "\t".'<td></td></tr>'."\n";  
                              
            }
            
            elseif ($sig_metabox['type'] == 'time'){
            	
                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="sig_metabox_names"><label for="'.$sig_id.'">'.$sig_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td><input class="sig_input_time" type="'.$sig_metabox['type'].'" value="'.$sig_metaboxvalue.'" name="lawthemes_'.$sig_metabox["name"].'" id="'.$sig_id.'"/>';
                $output .= '<span class="sig_metabox_desc">'.$sig_metabox['desc'].'</span></td>'."\n";
                $output .= "\t".'<td></td></tr>'."\n"; 
                              
            }

            elseif ($sig_metabox['type'] == 'select'){
                       
                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="sig_metabox_names"><label for="'.$sig_id.'">'.$sig_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td><select class="sig_input_select" id="'.$sig_id.'" name="lawthemes_'. $sig_metabox["name"] .'">';
                $output .= '<option value="">Select to return to default</option>';
                
                $array = $sig_metabox['options'];
                
                if($array){
                
                    foreach ( $array as $id => $option ) {
                        $selected = '';
                       
                        if(isset($sig_metabox['default']))  {                            
							if($sig_metabox['default'] == $option && empty($sig_metaboxvalue)){$selected = 'selected="selected"';} 
							else  {$selected = '';}
						}
                        
                        if($sig_metaboxvalue == $option){$selected = 'selected="selected"';}
                        else  {$selected = '';}  
                        
                        $output .= '<option value="'. $option .'" '. $selected .'>' . $option .'</option>';
                    }
                }
                
                $output .= '</select><span class="sig_metabox_desc">'.$sig_metabox['desc'].'</span></td></td><td></td>'."\n";
                $output .= "\t".'</tr>'."\n";
            }
            
            elseif ($sig_metabox['type'] == 'checkbox'){
            
                if($sig_metaboxvalue == 'true') { $checked = ' checked="checked"';} else {$checked='';}

                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="sig_metabox_names"><label for="'.$sig_id.'">'.$sig_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td><input type="checkbox" '.$checked.' class="sig_input_checkbox" value="true"  id="'.$sig_id.'" name="lawthemes_'. $sig_metabox["name"] .'" />';
                $output .= '<span class="sig_metabox_desc" style="display:inline">'.$sig_metabox['desc'].'</span></td></td><td></td>'."\n";
                $output .= "\t".'</tr>'."\n";
            }
            
            elseif ($sig_metabox['type'] == 'radio'){
            
            $array = $sig_metabox['options'];
            
            if($array){
            
            $output .= "\t".'<tr>';
            $output .= "\t\t".'<th class="sig_metabox_names"><label for="'.$sig_id.'">'.$sig_metabox['label'].'</label></th>'."\n";
            $output .= "\t\t".'<td>';
            
                foreach ( $array as $id => $option ) {

                    if($sig_metaboxvalue == $id) { $checked = ' checked';} else {$checked='';}

                        $output .= '<input type="radio" '.$checked.' value="' . $id . '" class="sig_input_radio"  name="lawthemes_'. $sig_metabox["name"] .'" />';
                        $output .= '<span class="sig_input_radio_desc" style="display:inline">'. $option .'</span><div class="sig_spacer"></div>';
                    }
                    $output .=  '</td></td><td></td>'."\n";
                    $output .= "\t".'</tr>'."\n";    
                 }
            }
			elseif ($sig_metabox['type'] == 'images')
			{
			
			$i = 0;
			$select_value = '';
			$layout = '';

			foreach ($sig_metabox['options'] as $key => $option) 
				 { 
				 $i++;
				 
				 $checked = '';
				 $selected = '';
				 if($sig_metaboxvalue != '') {
				 	if ($sig_metaboxvalue == $key) { $checked = ' checked'; $selected = 'sig-meta-radio-img-selected'; }
				 } 
				 else {
				 	if ($option['std'] == $key) { $checked = ' checked'; } 
					elseif ($i == 1) { $checked = ' checked'; $selected = 'sig-meta-radio-img-selected'; }
					else { $checked=''; }
					
				 }
					
					$layout .= '<div class="sig-meta-radio-img-label">';			
					$layout .= '<input type="radio" id="sig-meta-radio-img-' . $sig_metabox["name"] . $i . '" class="checkbox sig-meta-radio-img-radio" value="'.$key.'" name="lawthemes_'. $sig_metabox["name"].'" '.$checked.' />';
					$layout .= '&nbsp;' . $key .'<div class="sig_spacer"></div></div>';
					$layout .= '<img src="'.$option.'" alt="" class="sig-meta-radio-img-img '. $selected .'" onClick="document.getElementById(\'sig-meta-radio-img-'. $sig_metabox["name"] . $i.'\').checked = true;" />';
				}
			
			$output .= "\t".'<tr>';
			$output .= "\t\t".'<th class="sig_metabox_names"><label for="'.$sig_id.'">'.$sig_metabox['label'].'</label></th>'."\n";
			$output .= "\t\t".'<td class="sig_metabox_fields">';
			$output .= $layout;
			$output .= '<span class="sig_metabox_desc">'.$sig_metabox['desc'].'</span></td></td><td></td>'."\n";
			$output .= '</td>'."\n";
			$output .= "\t".'</tr>'."\n";
						
			}
            
            elseif($sig_metabox['type'] == 'upload')
            {
				if(isset($sig_metabox["default"])) $default = $sig_metabox["default"];
				else $default = '';
            
                $output .= "\t".'<tr>';
                $output .= "\t\t".'<th class="sig_metabox_names"><label for="'.$sig_id.'">'.$sig_metabox['label'].'</label></th>'."\n";
                $output .= "\t\t".'<td class="sig_metabox_fields">'. lawthemes_uploader_custom_fields($post->ID,$sig_metabox["name"],$default,$sig_metabox["desc"]);
                $output .= '</td>'."\n";
                $output .= "\t".'</tr>'."\n";
                
            }
        }
    
    $output .= '</table>'."\n\n";
    echo $output;
}



/*-----------------------------------------------------------------------------------*/
// lawthemes_uploader_custom_fields
/*-----------------------------------------------------------------------------------*/

function lawthemes_uploader_custom_fields($pID,$id,$std,$desc){

    // Start Uploader
    $upload = get_post_meta( $pID, $id, true);
	$href = cleanSource($upload);
	$uploader = '';
    $uploader .= '<input class="sig_input_text" name="'.$id.'" type="text" value="'.$upload.'" />';
    $uploader .= '<div class="clear"></div>'."\n";
    $uploader .= '<input type="file" name="attachement_'.$id.'" />';
    $uploader .= '<input type="submit" class="button button-highlighted" value="Save" name="save"/>';
    if ( $href ) 
		$uploader .= '<span class="sig_metabox_desc">'.$desc.'</span></td>'."\n".'<td class="sig_metabox_image"><a href="'. $upload .'"><img src="'.get_bloginfo('template_url').'/thumb.php?src='.$href.'&w=150&h=80&zc=1" alt="" /></a>';

return $uploader;
}



/*-----------------------------------------------------------------------------------*/
// lawthemes_metabox_handle
/*-----------------------------------------------------------------------------------*/

function lawthemes_metabox_handle(){   
    
    global $globals;
    $sig_metaboxes = get_option('sig_custom_template');  
    
    $seo_metaboxes = get_option('sig_custom_seo_template');  
    
    if(!empty($seo_metaboxes)){
    	$sig_metaboxes = array_merge($sig_metaboxes,$seo_metaboxes);
    }
       
    if(isset($_POST['post_ID']))
		$pID = $_POST['post_ID'];
    $upload_tracking = array();
	
    
    if (isset($_POST['action']) && $_POST['action'] == 'editpost'){                                   
        foreach ($sig_metaboxes as $sig_metabox) { // On Save.. this gets looped in the header response and saves the values submitted
            if($sig_metabox['type'] == 'text' 
			OR $sig_metabox['type'] == 'calendar' 
			OR $sig_metabox['type'] == 'time'
			OR $sig_metabox['type'] == 'select' 
			OR $sig_metabox['type'] == 'radio'
			OR $sig_metabox['type'] == 'checkbox' 
			OR $sig_metabox['type'] == 'textarea' 
			OR $sig_metabox['type'] == 'images' ) // Normal Type Things...
                {
                    $var = "lawthemes_".$sig_metabox["name"];
                    if (isset($_POST[$var])) {            
                        if( get_post_meta( $pID, $sig_metabox["name"] ) == "" )
                            add_post_meta($pID, $sig_metabox["name"], $_POST[$var], true );
                        elseif($_POST[$var] != get_post_meta($pID, $sig_metabox["name"], true))
                            update_post_meta($pID, $sig_metabox["name"], $_POST[$var]);
                        elseif($_POST[$var] == "") {
                           delete_post_meta($pID, $sig_metabox["name"], get_post_meta($pID, $sig_metabox["name"], true));
                        }
                    }
                    elseif(!isset($_POST[$var]) && $sig_metabox['type'] == 'checkbox') { 
                        update_post_meta($pID, $sig_metabox["name"], 'false'); 
                    }      
                    else {
                          delete_post_meta($pID, $sig_metabox["name"], get_post_meta($pID, $sig_metabox["name"], true)); // Deletes check boxes OR no $_POST
                    }    
                }
          
            elseif($sig_metabox['type'] == 'upload') // So, the upload inputs will do this rather
                {
                $id = $sig_metabox['name'];
                $override['action'] = 'editpost';
                
                    if(!empty($_FILES['attachement_'.$id]['name'])){ //New upload
                    $_FILES['attachement_'.$id]['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $_FILES['attachement_'.$id]['name']); 
                           $uploaded_file = wp_handle_upload($_FILES['attachement_' . $id ],$override); 
                           $uploaded_file['option_name']  = $sig_metabox['label'];
                           $upload_tracking[] = $uploaded_file;
                           update_post_meta($pID, $id, $uploaded_file['url']);
                    }
                    elseif(empty( $_FILES['attachement_'.$id]['name']) && isset($_POST[ $id ])){
                        update_post_meta($pID, $id, $_POST[ $id ]); 
                    }
                    elseif($_POST[ $id ] == '')  { delete_post_meta($pID, $id, get_post_meta($pID, $id, true));
                    }
                }
               // Error Tracking - File upload was not an Image
               update_option('sig_custom_upload_tracking', $upload_tracking);
            }
            
        }
}



/*-----------------------------------------------------------------------------------*/
// lawthemes_metabox_add
/*-----------------------------------------------------------------------------------*/

function lawthemes_metabox_add() {
    if ( function_exists('add_meta_box') ) {
        add_meta_box('lawthemes-settings',get_option('sig_themename').' Custom Settings','lawthemes_metabox_create','post','normal');
        add_meta_box('lawthemes-settings',get_option('sig_themename').' Custom Settings','lawthemes_metabox_create','page','normal');
    }
}



/*-----------------------------------------------------------------------------------*/
// lawthemes_metabox_header
/*-----------------------------------------------------------------------------------*/

function lawthemes_metabox_header(){
?>
<script type="text/javascript">

    jQuery(document).ready(function(){
		
        jQuery('form#post').attr('enctype','multipart/form-data');
        jQuery('form#post').attr('encoding','multipart/form-data');
        
         //JQUERY DATEPICKER
		jQuery('.sig_input_calendar').each(function (){
			jQuery('#' + jQuery(this).attr('id')).datepicker({showOn: 'button', buttonImage: '<?php echo get_bloginfo('template_directory');?>/functions/images/calendar.gif', buttonImageOnly: true});
		});
		
		//JQUERY TIME INPUT MASK
		jQuery('.sig_input_time').each(function (){
			jQuery('#' + jQuery(this).attr('id')).mask("99:99");
		});
		
        jQuery('.sig_metaboxes_table th:last, .sig_metaboxes_table td:last').css('border','0');
        var val = jQuery('input#title').attr('value');
        if(val == ''){ 
        jQuery('.sig_metabox_fields .button-highlighted').after("<em class='sig_red_note'>Please add a Title before uploading a file</em>");
        };
		jQuery('.sig-meta-radio-img-img').click(function(){
				jQuery(this).parent().find('.sig-meta-radio-img-img').removeClass('sig-meta-radio-img-selected');
				jQuery(this).addClass('sig-meta-radio-img-selected');
				
			});
			jQuery('.sig-meta-radio-img-label').hide();
			jQuery('.sig-meta-radio-img-img').show();
			jQuery('.sig-meta-radio-img-radio').hide();
        <?php //Errors
        $error_occurred = false;
        $upload_tracking = get_option('sig_custom_upload_tracking');
        if(!empty($upload_tracking)){
        $output = '<div style="clear:both;height:20px;"></div><div class="errors"><ul>' . "\n";
            $error_shown == false;
            foreach($upload_tracking as $array )
            {
                 if(array_key_exists('error', $array)){
                        $error_occurred = true;
                        ?>
                        jQuery('form#post').before('<div class="updated fade"><p>lawthemes Upload Error: <strong><?php echo $array['option_name'] ?></strong> - <?php echo $array['error'] ?></p></div>');
                        <?php
                }
            }
        }
		
        delete_option('sig_upload_custom_errors');
        ?>
    });

</script>
<style type="text/css">
.sig_input_text { margin:0 0 10px 0; background:#f4f4f4; color:#444; width:80%; font-size:11px; padding: 5px;}
.sig_input_select { margin:0 0 10px 0; background:#f4f4f4; color:#444; width:60%; font-size:11px; padding: 5px;}
.sig_input_checkbox { margin:0 10px 0 0; }
.sig_input_radio { margin:0 10px 0 0; }
.sig_input_radio_desc { font-size: 12px; color: #666 ; }
.sig_spacer { display: block; height:5px}
.sig_metabox_desc { font-size:10px; color:#aaa; display:block}
.sig_metaboxes_table{ border-collapse:collapse; width:100%}
.sig_metaboxes_table tr:hover th,
.sig_metaboxes_table tr:hover td { background:#f8f8f8}
.sig_metaboxes_table th,
.sig_metaboxes_table td{ border-bottom:1px solid #ddd; padding:10px 10px;text-align: left; vertical-align:top}
.sig_metabox_names { width:20%}
.sig_metabox_fields { width:70%}
.sig_metabox_image { text-align: right;}
.sig_red_note { margin-left: 5px; color: #c77; font-size: 10px;}
.sig_input_textarea { width:80%; height:120px;margin:0 0 10px 0; background:#f0f0f0; color:#444;font-size:11px;padding: 5px;}
.sig-meta-radio-img-img { border:3px solid #fff; margin:0 5px 10px 0; display:none; cursor:pointer;}
.sig-meta-radio-img-selected { border:3px solid #ccc}
.sig-meta-radio-img-label { font-size:12px}
.sig-meta-radio-img-img:hover {opacity:.8; }
</style>
<?php
 echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/functions/css/jquery-ui-datepicker.css" />';
}


?>