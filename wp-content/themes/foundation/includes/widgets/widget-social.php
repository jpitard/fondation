<?php
/*---------------------------------------------------------------------------------*/
/* Social Widget */
/*---------------------------------------------------------------------------------*/

class med_Socialw extends WP_Widget {

	function med_Socialw() {
		$widget_ops = array('description' => 'Use this widget to add your social links to the sidebar.' );
		parent::WP_Widget(false, __('Non-Profit - Social Widget', 'medicalthemes'),$widget_ops);      
	}

	function widget($args, $instance) {  
		$title = $instance['title'];
		
		$facebook = $instance['facebook'];
		$youtube = $instance['youtube'];
		$twitter= $instance['twitter'];

        echo '<div class="social-widget widget">';

		
			

		if($title != ''){
		?>
		
		<?php echo '<h3>'.$title.'</h3>'; ?>
        
         <?php echo "<div id='socialwidg'>" ?>
        
        		<?php } if ($facebook != '') { ?>
		
			<a target="_blank" class="social" href="<?php echo $facebook; ?>"><img src="<?php echo (get_bloginfo('template_url').'/images/facebook.png'); ?>"/></a>
			
			
			<?php } if ($twitter != '') { ?>
		
			<a  target="_blank" class="social" href="<?php echo $twitter; ?>"><img src="<?php echo (get_bloginfo('template_url').'/images/twitter.png'); ?>"/></a>
            
            	<?php } if ($youtube != '') { ?>
		
			<a  target="_blank" class="social" href="<?php echo $youtube; ?>"><img src="<?php echo (get_bloginfo('template_url').'/images/youtube.png'); ?>"/></a>
        
        
		 
        <?php echo '</div>' ?>
        
   
	
            
            
	
		<?php
		}
		
		echo '</div>';

	}

	function update($new_instance, $old_instance) {                
		return $new_instance;
	}

	function form($instance) {        
		$title = esc_attr($instance['title']);
		$facebook = esc_attr($instance['facebook']);
		$twitter = esc_attr($instance['twitter']);
		$youtube = esc_attr($instance['youtube']);
		?>
        
       
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):','medicalthemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
		
        <p>
            <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook Url:','medicalthemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo $facebook; ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
        </p>
       
        <p>
            <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:','medicalthemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo $twitter; ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
        </p>
        
          <p>
            <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('Youtube URL:','medicalthemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo $youtube; ?>" class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" />
        </p>
        <?php
	}
} 

register_widget('med_Socialw');
?>