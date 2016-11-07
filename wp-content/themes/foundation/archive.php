<?php get_header(); ?>
       
    <div id="content" class="col-full">
		<div id="main" class="col-left">
        
        <?php if (have_posts()) : $count = 0; ?>
        
            <?php if (is_category()) { ?>
            <span class="archive_header"><span class="fl cat"><?php _e('Archive'); ?> | <?php echo single_cat_title(); ?></span> <span class="fr catrss"><?php $cat_obj = $wp_query->get_queried_object(); $cat_id = $cat_obj->cat_ID; echo '<a href="'; get_category_rss_link(true, $cat, ''); echo '">RSS feed for this section</a>'; ?></span></span>        
        
            <?php } elseif (is_day()) { ?>
            <span class="archive_header"><?php _e('Archive', 'medicalthemes'); ?> | <?php the_time($GLOBALS['meddate']); ?></span>

            <?php } elseif (is_month()) { ?>
            <span class="archive_header"><?php _e('Archive', 'medicalthemes'); ?> | <?php the_time('F, Y'); ?></span>

            <?php } elseif (is_year()) { ?>
            <span class="archive_header"><?php _e('Archive', 'medicalthemes'); ?> | <?php the_time('Y'); ?></span>

            <?php } elseif (is_author()) { ?>
            <span class="archive_header"><?php _e('Archive by Author', 'medicalthemes'); ?></span>

            <?php } elseif (is_tag()) { ?>
            <span class="archive_header"><?php _e('Tag Archives:', 'medicalthemes'); ?> <?php echo single_tag_title('', true); ?></span>
            
            <?php } ?>
            
            <div class="fix"></div>
            
            <div id="recent-posts">
        
        	<?php 
        	
            while (have_posts()) : the_post(); $count++; 
         
        ?>
                                                                    
            <!-- Post Starts -->
    			   			
    		

<div id="blogpost">
<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<div class="blog-posted">
                          <?php the_time('F d, Y');?>&nbsp; | &nbsp; Posted by : <?php the_author_posts_link();?>&nbsp; | &nbsp; <?php the_category(',');?> &nbsp; | &nbsp;  <?php comments_popup_link('0 Comment','1 Comment','% Comments');?>
                          </div>
<div class="entry"><?php the_excerpt(); ?>
		<a href="<?php the_permalink() ?>" rel="bookmark">Read More &raquo</a><br /><br /></p></div>

</a></div>
   			
        <?php endwhile; ?> 
      
       	<div class="fix"></div>
    	
    	</div><!-- /#recent-posts -->
        
        <?php else: ?>
            <div class="post none">
				
				<h1 class="title"><?php _e('Nothing found', 'medicalthemes') ?></h1>
			
               	<div class="entry">
               		<p><?php _e('The page you trying to reach does not exist, or has been moved. Please use the menus or the search box to find what you are looking for.') ?></p>
               	</div>
                	                	
            </div><!-- /.post -->  
        <?php endif; ?>  
    	
		
                
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>