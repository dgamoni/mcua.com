<?php
    /**
     * Daca a fost selectat sa fie imagine in header, optinem imaginea
     * in functia tfuse_get_header_content() ce se afla in
     * theme_config/theme_includes/THEME_HEADER_CONTENT.php
     * imaginea se transmite prin variabila globala $header_image
     */
    global $header_image;
    if ( !empty($header_image['image']) ) :
        if (empty($header_image['link_url']) || ($header_image['link_url']== '') ) $header_image['link_url'] = '#';
        ?>
    <!-- top Slider/Image -->
    <div class="header_image">

        <div class="topimage">
            <?php
            $image = new TF_GET_IMAGE();
            echo $image->width(870)->src($header_image['image'])->get_img();
            ?>
            <?php if (!empty($header_image['caption']) || !empty($header_image['link_text'])): ?>
            <div class="caption">
                <p><?php echo '<span>' . $header_image['caption'] .'</span>';?> <?php if( !empty($header_image['link_text']) &&  !empty($header_image['link_url'])) echo '<a href="' . $header_image['link_url'] . '" class="link-more" target="' . $header_image['link_target'] . '">' . $header_image['link_text'] . '</a>';?></p>
            </div>
            <?php endif;?>

        </div>
        <?php if (isset($header_image['quote_after_image']) && ($header_image['quote_after_image']!= '')) : ?>
        <div class="header_quote">
            <p><?php echo $header_image['quote_after_image'];?></p>
        </div>
        <?php endif; ?>

    </div>
    <!--/ top Slider/Image -->

    <?php endif; ?>
