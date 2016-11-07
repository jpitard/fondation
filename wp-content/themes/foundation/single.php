<?php get_header(); ?>
       
    <div id="content" class="col-full">
		<div id="main" class="col-left">
		           
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
            
				<div <?php post_class(); ?>>

                  
                    
                    <p class="post-meta">
                    	<span class="post-category"><?php the_category(', ') ?></span> | 
                    	<span class="post-date"><?php the_time($GLOBALS['meddate']); ?></span>
                    	<?php _e('by', 'medicalthemes') ?> <span class="post-author"><?php the_author_posts_link(); ?></span> | 
                    	<span class="comments"><?php comments_popup_link(__('0 Comments', 'medicalthemes'), __('1 Comment', 'medicalthemes'), __('% Comments', 'medicalthemes')); ?></span>
   	                 
                    </p>
                    
                    <div class="entry">
                    	
                    	
                    	<?php the_content(); ?>
                    	
					</div>
										
					<?php the_tags('<p class="tags">Tags: ', ', ', '</p>'); ?>

              
                    
                </div><!-- /.post -->
                
            
                
              
	                <?php comments_template('', true); ?>
             
                                                    
			<?php endwhile; else: ?>
				<div class="post none">
				
					<h1 class="title"><?php _e('Nothing found', 'medicalthemes') ?></h1>
				
                	<div class="entry">
                		<p>'The page you trying to reach does not exist, or has been moved. Please use the menus or the search box to find what you are looking for.</p>
                	</div>
                	                	
                </div><!-- /.post -->             
           	<?php endif; ?>  
        
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>