    <form method="get" class="searchform" action="<?php bloginfo('url'); ?>" >
        <input type="text" class="field s" name="s" value="<?php _e('Search...', 'medicalthemes') ?>" onfocus="if (this.value == '<?php _e('Search...', 'medicalthemes') ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search...', 'medicalthemes') ?>';}" />
        <input type="submit" class="submit button" name="submit" value="<?php _e('Search', 'medicalthemes'); ?>" />
        <div class="fix"></div>
    </form>    
    
