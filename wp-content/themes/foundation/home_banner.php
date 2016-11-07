  <div id="banner">
        
     <div id="banner_left">
     
     <h1><?php $header_title  = get_option('sig_header_title');?><?php if ($header_title != "") {echo $header_title;} else { echo 'Lorem Ipsum Dolor Amet';}?></h1>
     
  <p><?php $header_text  = get_option('sig_header_text');?><?php if ($header_text != "") {echo $header_text;} else { echo 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat.';}?></p>
     


    <?php if (get_option('sig_more_link') !="" && get_option('sig_more_link') !="Select a page:") { ?><a class="more" href="<?php $more_link  = get_option('sig_more_linky');?><?php if ($more_link != "") {echo bloginfo('url') . "/?page_id=" .$more_link;} else { echo '#';}?>">Read More</a><?php } ?>
    
     
     </div>
     
     <div id="banner_right">
     
     <ul style="<?php if (get_option('sig_video') != "") echo "display:none" ?>" id="nav">
			<li id="prev"><a href="#">Previous</a></li>
			<li id="next"><a href="#">Next</a></li>
		</ul>
     
     <div style="overflow: hidden;" id="slideshow">
		
	
		<ul  id="slides">
        <?php if (get_option('sig_video') != "") echo get_option('sig_video'); else { ?>
        <?php $loop = new WP_Query( array( 'post_type' => 'slides', 'orderby' => 'menu_order', 'order' => 'ASC') ); ?>
 			<?php if ( $loop->have_posts()) { while ( $loop->have_posts()) : $loop->the_post(); ?>
            
             <li style="height:320px;"><img src="<?php bloginfo('template_directory'); ?>/includes/js/timthumb.php?src=<?php echo get_post_meta($post->ID, 'slide_image', true); ?>&amp;w=390&amp;h=320&amp;zc=1" /></li>
              
                    <?php endwhile; ?>
                     <?php } else {?>
                     <!-- If no slides created, display placeholder -->
                    	<li><img src="<?php bloginfo('template_directory');?>/images/no_slides.png"></li>
                        
                    <?php }}?>
            
    
		
		</ul>
	</div>
     
     </div>
        
        </div>
        
         
	  </div>
 
        <div class="<?php if (get_option('sig_disable_donate') != 'true') echo 'full'; else echo 'short' ?>" id="ribbon">
        
        
        <?php if (get_option('sig_disable_donate') != 'true') { ?> 
        <table class="donate_bar" style="margin: 0 auto;" cellpadding="0" cellpadding="0" width="977px"><tr>
<td  class="title"><h2 id="donate_left"><?php $donate_title = get_option('sig_donate_title');?><?php if ($donate_title != "") {echo $donate_title;} else { echo 'Help Support Our Cause';}?></h2></td>

<td class="text"><p class="donate_mid"><?php $donate_desc = get_option('sig_donate_desc');?><?php if ($donate_desc != "") {echo $donate_desc;} else { echo 'Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. ';}?></p></td>

<td valign="top" class="butt"><form class="donate" action="https://www.paypal.com/cgi-bin/webscr" target="_blank" method="post">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="<?php $paypal = get_option('sig_paypal');?><?php if ($paypal != "") {echo $paypal;} else { echo '';}?>">

<input type="hidden" name="item_name" value="<?php $donate_name = get_option('sig_donate_name');?><?php if ($donate_name != "") {echo $donate_name;} else { echo 'Donation';}?>">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="<?php $currency = get_option('sig_currency');?><?php if ($currency != "") {echo $currency;} else { echo 'USD';}?>">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input class="donate" type="submit" value="<?php $donate_but = get_option('sig_donate_but');?><?php if ($donate_but != "") {echo $donate_but;} else { echo 'Donate Now';}?>"  border="0" name="submit">

</form></td>

</tr></table>
        <?php } ?>
        </div>
       