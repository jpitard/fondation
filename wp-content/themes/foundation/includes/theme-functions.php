<?php

/*-----------------------------------------------------------------------------------*/
 
// Set Slideshow Speed

function slides_speed() { 

if (get_option('sig_slide_speed') == "Slow") { echo "9000"; } elseif (get_option('sig_slide_speed') == "Normal") { echo "5000"; } elseif (get_option('sig_slide_speed') == "Fast") { echo "3000";} elseif (get_option('sig_slide_speed') == "") { echo "5000"; }

}

/*Plugin Name: Limit Posts http://labitacora.net/comunBlog/limit-post.phps*/

function the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);

	 $content = preg_replace('/<p\sclass=\"wp\-caption\-text\">[^<]+<\/p>/i', '', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
	  $content = strip_tags($content);
	  $thelink = get_permalink($post->ID);
	  


   if (strlen($_GET['p']) > 0) {
      echo "<div>";
      echo $content;
      echo ' <a class="read_more" href="' . the_permalink() . '">Read More</a></div>';
	  
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo "<p>";
        echo $content;
        echo "...";
        echo ' <a class="read_more" href="' . $thelink . '">Read More</a></p>';
   }
   else {
      echo "<p>";
      echo $content;
      echo "</p>";
   }
}


/*-----------------------------------------------------------------------------------*/
 
// Create custom Post Type Slides

  register_post_type( 'slides',
    array(
      'labels' => array(
        'name' => __( 'Slides' ), //this name will be used when will will call the slides in our theme
        'singular_name' => __( 'Slide' ),
		'add_new' => _x('Add New', 'Slide'),
		'add_new_item' => __('Add New Slide'), //custom name to show up instead of Add New Post. Same for the following
		'edit_item' => __('Edit Slide'),
		'new_item' => __('New Slide')
		
      ),
      'public' => true,
	  'show_ui' => true,
	  'hierarchical' => false, //it means we cannot have parent and sub pages
	  'capability_type' => 'post', //will act like a normal post
	  'rewrite' => 'slide', //this is used for rewriting the permalinks
	  'query_var' => false,
	  'menu_icon' => get_bloginfo('template_directory') . '/functions/images/slide_icon.gif',
	  'supports' => array( 'title', 'page-attributes') //the editing regions that will support
    )
  );
  
  
/*-----------------------------------------------------------------------------------*/  
  
//ENABLE POST THUMBNAILS FOR ALL POSTS AND PAGES
add_theme_support( 'post-thumbnails');



/*-----------------------------------------------------------------------------------*/


//Access the WordPress Pages via an Array
$sig_pages = array();
$sig_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($sig_pages_obj as $sig_page) {
    $sig_pages[$sig_page->ID] = $sig_page->post_title; }
$sig_pages_tmp = array_unshift($sig_pages, "Select a page:");     

 // Add meta boxes for costom post type - slides
 
$meta_box = array(
	'id' => 'slide-meta-box',
	'title' => 'Slide',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
	
	array(
			'name' => 'Slide Image',
			'desc' => 'Upload a slide image',
			'id' => 'slide_image',
			'type' => 'upload',
			'std' => ''
		),

	)
);
 
add_action('admin_menu', 'mytheme_add_box');
 
// Add meta box
function mytheme_add_box() {
	global $meta_box;
 
	add_meta_box($meta_box['id'], $meta_box['title'], 'mytheme_show_box', 'slides', $meta_box['context'], $meta_box['priority']);

}


/*-----------------------------------------------------------------------------------*/

 
// Callback function to show fields in meta box
function mytheme_show_box() {
	global $meta_box, $post;
 
	// Use nonce for verification
	echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo '<table class="form-table">';
 
	foreach ($meta_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
 
		echo '<tr>',
				'<th style="width:20%"><label class="slide-meta" for="', $field['id'], '">', $field['name'], '</label></th>',
				'<td>';
		switch ($field['type']) {
		
		 case 'text':
                echo '<input class="slide-meta-input" type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br /><span class="meta-desc">', $field['desc'], '</span>';
                break;
				
				
				
				case 'select':

			 $output .= '<select class="sig-input" name="'. $field['id'] .'" id="'. $field['id'] .'">';
		
			$select_value = $meta ? $meta : $field['std'];
			 
			foreach ($field['options'] as $option) {
				
				$selected = '';
				
				 if($select_value != '') {
					 if ( $select_value == $option) { $selected = ' selected="selected"';} 
			     } else {
					 if ( isset($field['std']) )
						 if ($field['std'] == $option) { $selected = ' selected="selected"'; }
				 }
				  
				 $output .= '<option'. $selected .'>';
				 $output .= $option;
				 $output .= '</option>';
			 
			 } 
			 $output .= '</select>';
			 
			  $output .= '<br /><span class="meta-desc">' . $field['desc'] . '</span>';
			 
			 echo $output;
			 
			 break;
			 
            case 'textarea':
                echo '<textarea class="slide-meta-input" name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br /><span class="meta-desc">', $field['desc'], '</span>';
                break;
				
				
				
				case "upload":
			
			echo slide_uploader_function($field['id'],$value['std'],null);
			
		break;
		}
		echo 	'<td>',
			'</tr>';
	}
 
	echo '</table>';
}


add_action('save_post', 'mytheme_save_data');
 
// Save data from meta box
function mytheme_save_data($post_id) {






	global $meta_box;
 
	// verify nonce
	if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}
 
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
 
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
 
	foreach ($meta_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
 
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
	
	// Save the page ID for the button link

	
}


/*-----------------------------------------------------------------------------------*/


/* Add column in slides admin to display slide image thumbnail */

if ( !function_exists('slides_AddThumbColumn') && ($_GET['post_type'] == 'slides') || ($post_type == 'slides') ) {
function slides_AddThumbColumn($cols) { 
		$cols['thumbnail'] = __('Image'); 
		return $cols;
	}
 
	function slides_AddThumbValue($column_name, $post_id) {
if ( 'thumbnail' == $column_name ) {
$thumb = get_post_meta($post_id, 'slide_image', true);
				
					if ( isset($thumb) && $thumb ) {
						echo"<img src=\""; bloginfo('template_directory'); echo"/includes/js/timthumb.php?src="; echo $thumb; echo"&amp;w=120&amp;h=120&amp;zc=1\" />";		} else {
						echo __('None');
					}
			}
	}
 
	add_filter( 'manage_posts_columns', 'slides_AddThumbColumn' );
	add_action( 'manage_posts_custom_column', 'slides_AddThumbValue', 10, 2 );
	
} 

/*-----------------------------------------------------------------------------------*/


/* Add Advance SEO options to post/pages */


if (get_option('sig_advanced_seo') == "Enabled") {

$meta_seo_box = array(
	'id' => 'my-meta-box2',
	'title' => 'Advanced SEO Options',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'Meta Title',
			'desc' => 'Enter a meta title',
			'id' => '_st_meta_title',
			'type' => 'text',
			'std' => ''
		),
	array(
			'name' => 'Meta Keywords',
			'desc' => 'Enter meta keywords',
			'id' => '_st_meta_keywords',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => 'Meta Description',
			'desc' => 'Enter meta description',
			'id' => '_st_meta_description',
			'type' => 'text',
			'std' => ''
		),
	
	)
);
 
add_action('admin_menu', 'mytheme_add_box2');}
 
// Add meta box2
function mytheme_add_box2() {
	global $meta_seo_box;
 
	add_meta_box($meta_seo_box['id'], $meta_seo_box['title'], 'mytheme_show_box2', 'post', $meta_seo_box['context'], $meta_seo_box['priority']);
	add_meta_box($meta_seo_box['id'], $meta_seo_box['title'], 'mytheme_show_box2', 'page', $meta_seo_box['context'], $meta_seo_box['priority']);
}


 
// Callback function to show fields in meta box2
function mytheme_show_box2() {
	global $meta_seo_box, $post;
 
	// Use nonce for verification
	echo '<input type="hidden" name="mytheme_meta_box2_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo '<table class="form-table">';
 
	foreach ($meta_seo_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
 
		echo '<tr>',
				'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
				'<td>';
		switch ($field['type']) {

//If Text		
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />',
					'<br />', $field['desc'];
				break;

		}
		echo 	'<td>',
			'</tr>';
	}
 
	echo '</table>';
}
 
add_action('save_post', 'save_seo_data');
 
// Save data from meta box2
function save_seo_data($post_id) {
	global $meta_seo_box;
 
	// verify nonce
	if (!wp_verify_nonce($_POST['mytheme_meta_box2_nonce'], basename(__FILE__))) {
		return $post_id;
	}
 
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
 
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
 
	foreach ($meta_seo_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
 
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}

?>