<?php

add_action('init','sig_options');  

function sig_options(){
	
// VARIABLES
$themename = "Foundation";

$themeversion = "1.0";

$shortname = "sig";

$GLOBALS['template_path'] = get_bloginfo('template_directory');

//Access the WordPress Categories via an Array
$sig_categories = array();  
$sig_categories_obj = get_categories('hide_empty=0');
foreach ($sig_categories_obj as $sig_cat) {
    $sig_categories[$sig_cat->cat_ID] = $sig_cat->cat_name;}
$categories_tmp = array_unshift($sig_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$sig_pages = array();
$sig_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($sig_pages_obj as $sig_page) {
    $sig_pages[$sig_page->ID] = $sig_page->post_title; }
$sig_pages_tmp = array_unshift($sig_pages, "Select a page:");     
    

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

//Testing 
$options_select = array("one","two","three","four","five");
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

//Stylesheets Reader
$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options
$all_uploads_path = get_bloginfo('home') . '/wp-content/uploads/';
$all_uploads = get_option('sig_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6");
$recent_entries = array("Select a number:","2","4","6","8","10","12");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

// THIS IS THE DIFFERENT FIELDS
$options = array();  

					
$options[] = array( "name" => "General Settings",
                    "type" => "heading");
					
$options[] = array( "name" => "Custom Logo",
					"desc" => "Upload your logo to replace the sample logo. Keep the image to a maximum height of 70px for optimal view. For best results use an image with a transparent background.",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload"); 
					
					
$options[] = array( "name" => "Color Scheme",
					"desc" => "Select your themes alternative color scheme.",
					"id" => $shortname."_alt_stylesheet",
					"std" => "default.css",
					"type" => "select",
					"options" => $alt_stylesheets);

          
$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px image to use for the website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload"); 
                                               
$options[] = array( "name" => "Analytics Code",
					"desc" => "Paste your Google Analytics code here. This will be added into the footer.",
					"id" => $shortname."_ana",
					"std" => "",
					"type" => "textarea");        

$options[] = array( "name" => "Header",
                    "type" => "heading");
                        
$options[] = array( "name" => "Header Title",
					"desc" => "Enter the homepage header title",
					"id" => $shortname."_header_title",
					"std" => "Lorem Ipsum Dolor Amet",
					"type" => "text");
					
					
$options[] = array( "name" => "Header Content Text",
					"desc" => "Enter hompage header text to be displayed below the title",
					"id" => $shortname."_header_text",
					"std" => "",
					"type" => "textarea");
					
$options[] = array( "name" => "Button Link",
					"desc" => "Select a page to link the button to. (leave unselected to display no button)",
					"id" => $shortname."_more_link",
					'type' => 'select',
					'options' => $sig_pages,
					"std" => "");
					
$options[] = array( "name" => "Homepage",
                    "type" => "heading");
					
$options[] = array( "name" => "Left Content Title",
					"desc" => "Enter the title for the bottom left content",
					"id" => $shortname."_hleft_title",
					"std" => "Mission",
					"type" => "text");
					
$options[] = array( "name" => "Left Content",
					"desc" => "",
					"id" => $shortname."_hleft_text",
					"std" => "",
					"type" => "textarea2");
					
$options[] = array( "name" => "Right Content Title",
					"desc" => "Enter the title for the bottom right content",
					"id" => $shortname."_hright_title",
					"std" => "Events",
					"type" => "text");
					
$options[] = array( "name" => "Right Content",
					"desc" => "",
					"id" => $shortname."_hright_text",
					"std" => "",
					"type" => "textarea2");
					
$options[] = array( "name" => "Slideshow",
					"type" => "heading");
	
$options[] = array( "name" => "Slideshow Speed",
					"desc" => "Select a speed for the slideshow transitions",
					"id" => $shortname."_slide_speed",
					"std" => "Normal",
					"options" => array("Slow","Normal","Fast"),
					"type" => "select");
					
$options[] = array( "name" => "Embed A Video Instead Of Using Images",
					"desc" => "Place your viedo emebed code here. By using a video, this will disable all slide images.<br><br>
					 Vide should be 390px by 320px for optimal view.",
					"id" => $shortname."_video",
					"std" => "",
					"type" => "textarea"); 		
					
					$options[] = array( "name" => "Donate",
                    "type" => "heading");
					
$options[] = array( "name" => "Paypal Email Address",
					"desc" => "Enter the paypal account email address to use for the donate feature.",
					"id" => $shortname."_paypal",
					"std" => "",
					"type" => "text");
					
					
$options[] = array( "name" => "Donation Purpose",
					"desc" => "Enter the name of the donation purpose. Leave blank to use default name - donation. This will show up in paypal as the purpose of the donation.",
					"id" => $shortname."_donate_name",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Donation Currency",
					"desc" => "Enter currency to use for donations.<br> <b>Must be written in CAPITALS.</b><br> Leave blank for USD.",
					"id" => $shortname."_currency",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Homepage Donate Bar Title",
					"desc" => "Enter text for the donate bar title. (by default- Help Support Our Cause)",
					"id" => $shortname."_donate_title",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Homepage Donate Bar Description text",
					"desc" => "Enter text for the donate bar description",
					"id" => $shortname."_donate_desc",
					"std" => "",
					"type" => "textarea");
					
$options[] = array( "name" => "Donate Button Text",
					"desc" => "Enter custom text for the donate button. Leave blank to keep standard dontate now text.",
					"id" => $shortname."_donate_but",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Disable HomePage Donate Bar?",
					"desc" => "If checked, the will remove donate bar from the homepage header",
					"id" => $shortname."_disable_donate",
					"std" => "false",
					"type" => "checkbox");
							
					
$options[] = array( "name" => "Footer",
                    "type" => "heading");
					
$options[] = array( "name" => "Footer Copyright Text",
					"desc" => "Enter custom footer copyright text (leave blank to display standard copyright).",
					"id" => $shortname."_footx",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Facebook URL",
					"desc" => "Enter your full facebook URL for the footer facebook icon.",
					"id" => $shortname."_fb",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Twitter URL",
					"desc" => "Enter your full twitter URL for the twitter icon.",
					"id" => $shortname."_twit",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Disable Footer Social Icons?",
					"desc" => "If checked, the will remove the social icons from the footer.",
					"id" => $shortname."_disable_social",
					"std" => "false",
					"type" => "checkbox");
					  
                                              

update_option('sig_template',$options);      
update_option('sig_themename',$themename);   
update_option('sig_themeversion',$themeversion); 
update_option('sig_shortname',$shortname);
update_option('sig_manual',$manualurl);

                                     
// sig Metabox Options
$sig_metaboxes = array();

$sig_metaboxes[] = array (	"name" => "image",
							"label" => "Image",
							"type" => "upload",
							"desc" => "Upload file here...");
							
$sig_metaboxes[] = array (	"name"  => "embed",
							"std"  => "",
							"label" => "Embed Code",
							"type" => "textarea",
							"desc" => "Add your video embed code here");
    
update_option('sig_custom_template',$sig_metaboxes);      

}



?>