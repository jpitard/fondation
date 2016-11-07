<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<title><?php if (is_home () ) { bloginfo('name'); echo " - "; bloginfo('description'); 
} elseif (is_category() ) {single_cat_title(); echo " - "; bloginfo('name');
} elseif (is_single() || is_page() ) {single_post_title(); echo " - "; bloginfo('name');
} elseif (is_search() ) {bloginfo('name'); echo " search results: "; echo wp_specialchars($s);
} else { wp_title('',true); }?></title>

<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<!-- Check if alternitive color scheme is choosen -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory');?>/styles/<?php $color = get_option('sig_alt_stylesheet');?><?php if ($color != "") {echo $color;} else { echo 'default.css';}?>" media="screen" />

<!-- Load Rich JS fonts -->

<script type="text/javascript" src="<?php bloginfo('template_directory');?>/includes/js/typeface-0.15.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/includes/js/droid_serif_bold.typeface.js"></script>


      

<?php wp_head(); ?>

<!-- Start slideshow -->
<?php if (is_front_page()) {?>
<script type="text/javascript">$(document).ready(function() {
	$("#slideshow").css("overflow", "hidden");
	
	$("ul#slides").cycle({
		fx: 'fade',
timeout: <?php slides_speed() ?>, 
		prev: '#prev',
		next: '#next'
	});
	

	
});</script><?php } ?>


</head>

<body <?php if (is_front_page()) echo('class="home"') ?>>



<div id="wrapper">

<div id="<?php if (is_front_page()) echo('head'); else echo('head_content'); ?>">

<div id="head_wrap">

  <!-- Header Menu  -->

	<div class="typeface-js" id="top-nav">
		
         <a class="<?php if (is_front_page()) echo "home_active"; else echo "home";?>" href="<?php bloginfo('url'); ?>" ></a>
         
         
           <?php $menuClass = 'nav';
				$primaryNav = '';
				
				if (function_exists('wp_nav_menu')) {
					$primaryNav = wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'link_before' => '<span class="menu">', 'link_after' => '</span>', 'echo' => false ) );
				};
				if ($primaryNav == '') { ?>
					<ul class="<?php echo $menuClass; ?>">
					
 <?php wp_list_pages('title_li=&sort_column=menu_order&depth=2&link_before=<span class="menu">&link_after=</span>');?>
						
					</ul> 
				<?php }
				else echo($primaryNav); ?><!-- /Menu -->
                
               
	</div>
    
      <!-- Logo  -->
    
                <div id="logo">
	       
		
            <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>"><img src="<?php $logo = get_option('sig_logo');?><?php if ($logo != "") {echo $logo;} else { echo bloginfo('template_directory') . '/images/logo.png';}?>" /></a>
	      	
		</div><!-- /#logo -->
       
        
        
        <div class="clear"></div>
        
        
             <!-- Check if is homepage, if is include slideshow  -->

    <?php if (is_front_page()) require(TEMPLATEPATH.'/home_banner.php'); else { ?>

    </div></div>
    
    <div id="ribbon_content">
    
    <div id="ribbon_title">
    
       <h1 id="pagetitle" ><a id="pagetitle" href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
       
    </div></div>
    <?php ;} ?>
    
   


       