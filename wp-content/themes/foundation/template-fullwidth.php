<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>
       
    <div id="content" class="page col-full">
		<div id="main_full" class="col-left">
		           
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
                                                                        
                <div class="post">

                    <h1 id="pagetitle" ><a id="paget"class="typeface-js" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>

                    <div class="entry">
	                	<?php the_content(); ?>
	               	</div><!-- /.entry -->

					
                    
                </div><!-- /.post -->
              
                                                    
			<?php endwhile; else: ?>
				<div class="post">
				
					<h2 class="title"><?php _e('Nothing found') ?></h2>
				
                	<div class="entry">
                		<p><?php _e('The page you trying to reach does not exist, or has been moved. Please use the menus or the search box to find what you are looking for.') ?></p>
                	</div>
                	                	
                </div><!-- /.post -->
            <?php endif; ?>  
        
		</div><!-- /#main -->

       

    </div><!-- /#content -->
		
<?php get_footer(); ?>