
<div id="loopedSlider">
    
    <?php
		$featposts = get_option('med_featured_entries'); // Number of featured entries to be shown
		$GLOBALS[feat_tags_array] = explode(',',get_option('med_featured_tags')); // Tags to be shown
        foreach ($GLOBALS[feat_tags_array] as $tags){ 
			$tag = get_term_by( 'name', trim($tags), 'post_tag', 'ARRAY_A' );
			if ( $tag['term_id'] > 0 )
				$tag_array[] = $tag['term_id'];
		}
    ?>
	
	<?php $saved = $wp_query; query_posts(array('tag__in' => $tag_array, 'showposts' => $featposts)); ?>
	<?php if (have_posts()) : $count = 0; ?>

    <div class="container">
    
        <div class="slides">
        
            <?php while (have_posts()) : the_post(); $GLOBALS['shownposts'][$count] = $post->ID; $count++; ?>
            
            <div id="slide-<?php echo $count; ?>" class="slide">
        
            	<?php med_get_image('image',620,250,'feat-image'); ?>
            	
            	<div class="slide-content">
            	
       		     	<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
       		     	
       		     	<p><?php echo med_excerpt( get_the_excerpt(), '150'); ?></p>
       		     	       		 		
       		 	</div><!-- /.slide-content -->
       		     	
       		    <div class="fix"></div>
        
            </div>
            
		<?php endwhile; ?> 
			
		</div><!-- /.slides -->
		
		<ul class="nav-buttons">
    		<li id="n"><a href="#" class="next"><img src="<?php bloginfo('template_directory'); ?>/images/btn-slider-next.png" alt="&gt;" /></a></li>
            <li id="p"><a href="#" class="previous"><img src="<?php bloginfo('template_directory'); ?>/images/btn-slider-prev.png" alt="&lt;" /></a></li>
        </ul>
		
    </div><!-- /.container -->
    
	<div class="fix"></div>
    
    <?php endif; $wp_query = $saved; ?> 
    <?php update_option("med_exclude", $GLOBALS['shownposts']); ?>
    
        
</div><!-- /#loopedSlider -->
