<?php get_header(); ?>

    <div id="content" class="col-full">
		<div id="main">
        
        <div id="welcome_home">
        
        <h2><?php $hleft_title  = get_option('sig_hleft_title');?><?php if ($hleft_title != "") {echo $hleft_title;} else { echo 'Mission';}?></h2>
        
       
        
        <p><?php $hleft_text  = get_option('sig_hleft_text');?><?php if ($hleft_text != "") {echo $hleft_text;} else { echo '<i>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</i> Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie.</p>
<p>Consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.<br><a href="#">Read More</a></p>';}?></p>
        

        
        </div>
        
        
        <div class="roundify" id="home_box">
        
        <div id="inner_box">
        
        <h2><?php $hright_title  = get_option('sig_hright_title');?><?php if ($hright_title != "") {echo $hright_title;} else { echo 'Events';}?></h2>
        
         <p><?php $hright_text  = get_option('sig_hright_text');?><?php if ($hright_text != "") {echo $hright_text;} else { echo '<b>Lorem ipsum dolor sit amet</b>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. <p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat.';}?></p>
        
       
        
       
</div>
        </div>
         

<div style="clear:both;"></div>
		
    
			
                
		</div><!-- /#main -->

    

    </div><!-- /#content -->
		
<?php get_footer(); ?>