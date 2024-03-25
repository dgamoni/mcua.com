<div class="widget-container widget_search">
    <form method="get" id="searchform" action="<?php echo home_url( '/' ) ?>">
        <div>
            <label class="screen-reader-text" for="s"><?php _e('Search for','tfuse'); ?>:</label>
            <input type="text" name="s" id="s" class="inputField" onblur="if (this.value == '') {this.value = '<?php echo tfuse_options('search_box_text'); ?>';}" onfocus="if (this.value == '<?php echo tfuse_options('search_box_text'); ?>') {this.value = '';}" value="<?php echo tfuse_options('search_box_text'); ?>">
            <input type="submit" id="searchsubmit" class="btn-submit" value="Search">
            <div class="clear"></div>
        </div>
    </form>
</div>
