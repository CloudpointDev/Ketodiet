<form action="<?php echo home_url(); ?>/" id="searchform" method="get">
        <input type="text" id="s" name="s" value="<?php esc_html_e('Search', 'malina'); ?>" onfocus="if(this.value=='<?php esc_html_e('Search', 'malina') ?>')this.value='';" onblur="if(this.value=='')this.value='<?php esc_html_e('Search', 'malina') ?>';" autocomplete="off" />
        <input type="submit" value="<?php esc_html_e('Search', 'malina'); ?>" id="searchsubmit" />
</form>