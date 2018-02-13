<form action="<?php echo home_url('/'); ?>/" id="searchform" method="get">
    <div class="searchform-wrap">
        <input type="text" name="s" id="s" value="<?php esc_html_e( 'Search', 'the-rex'); ?>" onfocus='if (this.value == "<?php esc_html_e( 'Search', 'the-rex'); ?>") { this.value = ""; }' onblur='if (this.value == "") { this.value = "<?php esc_html_e( 'Search', 'the-rex'); ?>"; }'/>
    <div class="search-icon">
        <i class="fa fa-search"></i>
    </div>
    </div>
</form>