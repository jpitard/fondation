
	<div id="footer">
	
		<div class="inner">
	
			
			<!-- Footer Menu-->
			
           <?php $menuClass = 'nuv';
				$primaryNav = '';
				
				if (function_exists('wp_nav_menu')) {
					$primaryNav = wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
				};
				if ($primaryNav == '') { ?>
					<ul class="<?php echo $menuClass; ?>">
					
							<li <?php if (is_front_page()) echo('class="current_page_item"') ?>><a href="<?php bloginfo('url'); ?>"><?php _e('Home','Minimal'); ?></a></li>
                            
                          <?php wp_list_pages('title_li=&sort_column=menu_order&depth=1');?>
						
					</ul>
				<?php }
				else echo($primaryNav); ?>
                
                <!-- Get Social Icons -->
				
                 <?php if (get_option('sig_disable_social') != 'true') { ?> 
                <div id="social_foot">
                
                  <a target="_blank" href="<?php $fb  = get_option('sig_fb');?><?php if ($fb != "") {echo $fb;} else { echo '#';}?>"><img src="<?php bloginfo('template_directory');?>/images/fb_icon.png" /></a>
                  
                  <a target="_blank" href="<?php $twit  = get_option('sig_twit');?><?php if ($twit != "") {echo $twit;} else { echo '#';}?>"><img src="<?php bloginfo('template_directory');?>/images/tw_icon.png" /></a>
                  
                  <a href="/feed"><img src="<?php bloginfo('template_directory');?>/images/rss_icon.png" /></a>
               
                </div><?php } ?>
			 
			
			   <div class="clear"></div>
		</div>
        
        <!-- Footer copywrite text  -->
<div id="copywrite">   <p>
		<?php $footx  = get_option('sig_footx');?><?php if ($footx != "") {echo $footx;} else { echo '&copy; ' . date('Y') . '&nbsp;'; echo bloginfo('name') . '. All rights Reserved.';}?></p><a target="_blank" class="logo_icon" href="http://www.wordpressnonprofit.com">Non-Profit Wordpress Themes</a>
                </div>
		
		<div class="fix"></div>
		
	</div><!-- /#footer  -->

</div><!-- /#wrapper -->
<?php wp_footer(); ?>
<!-- /Get Analytics Code -->
<?php $ana = get_option('sig_ana');?><?php echo $ana; ?>
</body>
</html>