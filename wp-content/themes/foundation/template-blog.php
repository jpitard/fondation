<?php
/*
Template Name: Blog Page
*/
?>
<?php get_header(); ?>
       
    <div id="content" class="page col-full">
		<div id="main" class="col-left">
		<h1 id="pagetitle" ><a id="paget"class="typeface-js" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
             
<?php $page = (get_query_var('paged')) ? get_query_var('paged') : 1; query_posts("showposts=5&paged=$page"); while ( have_posts() ) : the_post() ?>

<div id="blogpost">
<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<div class="blog-posted">
                          <?php the_time('F d, Y');?>&nbsp; | &nbsp; Posted by : <?php the_author_posts_link();?>&nbsp; | &nbsp; <?php the_category(',');?> &nbsp; | &nbsp;  <?php comments_popup_link('0 Comments','1 Comment','% Comments');?>
                          </div>
<div class="entry"><?php the_excerpt(); ?>
		<a href="<?php the_permalink() ?>" rel="bookmark">Read More &raquo</a><br /><br /></p></div>
</div>

                   <?php endwhile;?>
                          <div class="blog-pagination"><!-- page pagination -->                                       	     			
                      		<div class="navigation">
                      			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
                      			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
                      			<div class="clear"></div>
                      		</div>
                                                 
                                             </div>               
                    
      </div>
        
		<!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>