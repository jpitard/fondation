<?php
/*---------------------------------------------------------------------------------*/
/* Donate Widget */
/*---------------------------------------------------------------------------------*/

class sig_Donatew extends WP_Widget {

	function sig_Donatew() {
		$widget_ops = array('description' => 'Use this widget to add a donate module to the sidebar.' );
		parent::WP_Widget(false, __('Non-Profit - donate Widget', 'nonprofitthemes'),$widget_ops);      
	}

	function widget($args, $instance) {  
		$title = $instance['title'];
		
		$dcontent = $instance['dcontent'];
		$button = $instance['button'];
		$twitter= $instance['twitter'];
		
		        echo '<div class="donate-widget-border">';

        echo '<div class="donate-widget">';

		
			

		if($title != ''){
		?>
		
		<?php echo '<h3>'.$title.'</h3>'; ?>
        
         <?php echo "<div id='Donatewidg'>" ?>
        
        		<?php } if ($dcontent != '') { ?>
		
			<p><?php echo $dcontent; ?></p>
			
		
            
            	<?php } if ($button != '') { ?>
		
	        <form action="https://www.paypal.com/cgi-bin/webscr" target="_blank" method="post">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="<?php $paypal = get_option('sig_paypal');?><?php if ($paypal != "") {echo $paypal;} else { echo '';}?>">

<input type="hidden" name="item_name" value="<?php $donate_name = get_option('sig_donate_name');?><?php if ($donate_name != "") {echo $donate_name;} else { echo 'Donation';}?>">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="<?php $currency = get_option('sig_currency');?><?php if ($currency != "") {echo $currency;} else { echo 'USD';}?>">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input class="donate_side" type="submit" value="<?php echo $button; ?>"  border="0" name="submit"></div>
        <span class="side_arrow"></span> 
        
          <div class="clear">
		 
        <?php echo '</div>' ?>
        
   
	
            
            
	
		<?php
		}
		echo '</div></div></div>';

	}

	function update($new_instance, $old_instance) {                
		return $new_instance;
	}

	function form($instance) {        
		$title = esc_attr($instance['title']);
		$dcontent = esc_attr($instance['dcontent']);
		$twitter = esc_attr($instance['twitter']);
		$button = esc_attr($instance['button']);
		?>
        
       
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','medicalthemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
		
        <p>
            <label for="<?php echo $this->get_field_id('dcontent'); ?>"><?php _e('Main Text:','medicalthemes'); ?></label>
            <textarea  cols="20" rows="8" type="textarea" class="widefat" id="<?php echo $this->get_field_id('dcontent'); ?>" name="<?php echo $this->get_field_name('dcontent'); ?>"><?php echo $dcontent; ?></textarea>
        </p>
       
      
        
          <p>
            <label for="<?php echo $this->get_field_id('button'); ?>"><?php _e('Button Text:','medicalthemes'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('button'); ?>" value="<?php echo $button; ?>" class="widefat" id="<?php echo $this->get_field_id('button'); ?>" />
        </p>
        <?php
	}
} 

register_widget('sig_Donatew');
?>