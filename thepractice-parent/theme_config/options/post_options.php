<?php

/* ----------------------------------------------------------------------------------- */
/* Initializes all the theme settings option fields for posts area. */
/* ----------------------------------------------------------------------------------- */

$options = array(
    /* ----------------------------------------------------------------------------------- */
    /* Sidebar */
    /* ----------------------------------------------------------------------------------- */

    /* Single Post */
    array('name' => 'Single Post',
        'id' => TF_THEME_PREFIX . '_side_media',
        'type' => 'metabox',
        'context' => 'side',
        'priority' => 'low' /* high/low */
    ),
    // Disable Single Post Image
    array('name' => 'Disable Image',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_image',
        'value' => tfuse_options('disable_image','false'),
        'type' => 'checkbox'
    ),
    // Disable Single Post Video
    array('name' => 'Disable Video',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_video',
        'value' => tfuse_options('disable_video','false'),
        'type' => 'checkbox'
    ),
    // Disable Single Post Comments
    array('name' => 'Disable Comments',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_comments',
        'value' => tfuse_options('disable_posts_comments','false'),
        'type' => 'checkbox',
        'divider' => true
    ),
    // Author Info
    array('name' => 'Disable Author Info',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_author_info',
        'value' => tfuse_options('disable_author_info','false'),
        'type' => 'checkbox'
    ),
    // Post Meta
    array('name' => 'Disable Meta',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_post_meta',
        'value' => tfuse_options('disable_post_meta','false'),
        'type' => 'checkbox'
    ),
    // Published Date
    array('name' => 'Disable Published Date',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_published_date',
        'value' => tfuse_options('disable_published_date','false'),
        'type' => 'checkbox'
    ),
    // Share Buttons
    array('name' => 'Disable Share Buttons',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_share_buttons',
        'value' => tfuse_options('_disable_share_buttons','false'),
        'type' => 'checkbox'
    ),
    /* ----------------------------------------------------------------------------------- */
    /* After Textarea */
    /* ----------------------------------------------------------------------------------- */

    /* Post Media */
    array('name' => 'Media',
        'id' => TF_THEME_PREFIX . '_media',
        'type' => 'metabox',
        'context' => 'normal'
    ),
    // Single Image
    array('name' => 'Image',
        'desc' => 'This is the main image for your post. Upload one from your computer, or specify an online address for your image (Ex: http://yoursite.com/image.png).',
        'id' => TF_THEME_PREFIX . '_single_image',
        'value' => '',
        'type' => 'upload',
        'hidden_children' => array(
            TF_THEME_PREFIX . '_single_img_dimensions',
            TF_THEME_PREFIX . '_single_img_position'
        )
    ),
    // Single Image Dimensions
    array('name' => 'Image Resize (px)',
        'desc' => 'These are the default width and height values. If you want to resize the image change the values with your own. If you input only one, the image will get resized with constrained proportions based on the one you specified.',
        'id' => TF_THEME_PREFIX . '_single_img_dimensions',
        'value' => tfuse_options('single_image_dimensions'),
        'type' => 'textarray'
    ),
    // Single Image Position
    array('name' => 'Image Position',
        'desc' => 'Select your preferred image  alignment',
        'id' => TF_THEME_PREFIX . '_single_img_position',
        'value' => tfuse_options('single_image_position'),
        'options' => array(
            '' => array($url . 'full_width.png', 'Don\'t apply an alignment'),
            'alignleft' => array($url . 'left_off.png', 'Align to the left'),
            'alignright' => array($url . 'right_off.png', 'Align to the right')
            ),
        'type' => 'images',
        'divider' => true
    ),
    // Thumbnail Image
    array('name' => 'Thumbnail',
        'desc' => 'This is the thumbnail for your post. Upload one from your computer, or specify an online address for your image (Ex: http://yoursite.com/image.png).',
        'id' => TF_THEME_PREFIX . '_thumbnail_image',
        'value' => '',
        'type' => 'upload',
        'hidden_children' => array(
            TF_THEME_PREFIX . '_thumbnail_dimensions',
            TF_THEME_PREFIX . '_thumbnail_position'
        )
    ),
    // Posts Thumbnail Dimensions
    array('name' => 'Thumbnail Dimension (px)',
        'desc' => 'These are the default width and height values. If you want to resize the thumbnail change the values with your own. If you input only one, the thumbnail will get resized with constrained proportions based on the one you specified.',
        'id' => TF_THEME_PREFIX . '_thumbnail_dimensions',
        'value' => tfuse_options('thumbnail_dimensions'),
        'type' => 'textarray'
    ),
    // Thumbnail Position
    array('name' => 'Thumbnail Position',
        'desc' => 'Select your preferred thumbnail alignment',
        'id' => TF_THEME_PREFIX . '_thumbnail_position',
        'value' => tfuse_options('thumbnail_position'),
        'options' => array(
            'frame_box' => array($url . 'full_width.png', 'Don\'t apply an alignment'),
            'frame_left' => array($url . 'left_off.png', 'Align to the left'),
            'frame_right' => array($url . 'right_off.png', 'Align to the right')
            ),
        'type' => 'images',
        'divider' => true
    ),
    // Custom Post Video
    array('name' => 'Video',
        'desc' => 'Copy paste the video URL or embed code. The video URL works only for Vimeo and YouTube videos. Read <a target="_blank" href="http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/">prettyPhoto documentation</a>
                    for more info on how to add video or flash in this text area
                    ',
        'id' => TF_THEME_PREFIX . '_video_link',
        'value' => '',
        'type' => 'textarea',
        'hidden_children' => array(
            TF_THEME_PREFIX . '_video_dimensions',
            TF_THEME_PREFIX . '_video_position'
        )
    ),
    // Video Dimensions
    array('name' => 'Video Size (px)',
        'desc' => 'These are the default width and height values. If you want to resize the video change the values with your own. If you input only one, the video will get resized with constrained proportions based on the one you specified.',
        'id' => TF_THEME_PREFIX . '_video_dimensions',
        'value' => tfuse_options('video_dimensions'),
        'type' => 'textarray'
    ),
    // Video Position
    array('name' => 'Video Position',
        'desc' => 'Select your preferred video alignment',
        'id' => TF_THEME_PREFIX . '_video_position',
        'value' => tfuse_options('video_position'),
        'options' => array(
            'noalign' => array($url . 'full_width.png', 'Don\'t apply an alignment'),
            'alignleft' => array($url . 'left_off.png', 'Align to the left'),
            'alignright' => array($url . 'right_off.png', 'Align to the right')
        ),
        'type' => 'images'
    ),
    /* Header Options */
    array('name' => 'Header',
        'id' => TF_THEME_PREFIX . '_header_option',
        'type' => 'metabox',
        'context' => 'normal'
    ),
    // Element of Hedear
    array('name' => 'Element of Hedear',
        'desc' => 'Select type of element on the header.',
        'id' => TF_THEME_PREFIX . '_header_element',
        'value' => 'image',
        'options' => array('none' => 'Without Header Element', 'slider' => 'Slider on Header', 'image' => 'Image on Header'),
        'type' => 'select',
    ),
    // Header Image
    array('name' => 'Quote Before Slider',
        'desc' => 'Quote Before Slider',
        'id' => TF_THEME_PREFIX . '_quote_before_slider',
        'value' => '',
        'type' => 'textarea',
    ),
    // Select Slider
    $this->ext->slider->model->has_sliders() ?
        array(
            'name' => 'Slider',
            'desc' => 'Select a slider for your post. The sliders are created on the <a href="' . admin_url( 'admin.php?page=tf_slider_list' ) . '" target="_blank">Sliders page</a>.',
            'id' => TF_THEME_PREFIX . '_select_slider',
            'value' => '',
            'options' => $TFUSE->ext->slider->get_sliders_dropdown(),
            'type' => 'select'
        ) :
        array(
            'name' => 'Slider',
            'desc' => '',
            'id' => TF_THEME_PREFIX . '_select_slider',
            'value' => '',
            'html' => 'No sliders created yet. You can start creating one <a href="' . admin_url('admin.php?page=tf_slider_list') . '">here</a>.',
            'type' => 'raw'
        ),
    // Header Image
    array('name' => 'Header Image',
        'desc' => 'Upload an image for your header. It will be resized to 870x276 px',
        'id' => TF_THEME_PREFIX . '_header_image',
        'value' => '',
        'type' => 'upload',
        'divider' => true
    ),
    // Image Caption
    array('name' => 'Image Caption',
        'desc' => 'Caption pentru imagine',
        'id' => TF_THEME_PREFIX . '_image_caption',
        'value' => '',
        'type' => 'text',
    ),
    // Link Text
    array('name' => 'Link Text',
        'desc' => 'Test pentru link',
        'id' => TF_THEME_PREFIX . '_link_text',
        'value' => '',
        'type' => 'text',
    ),
    // Link Text
    array('name' => 'Link URL',
        'desc' => 'URL pentru link',
        'id' => TF_THEME_PREFIX . '_link_url',
        'value' => '',
        'type' => 'text',
        'divider' => true
    ),
    // Link Target
    array('name' => 'Link Target',
        'desc' => 'Target pentru link',
        'id' => TF_THEME_PREFIX . '_link_target',
        'value' => '_self',
        'options' => array('_self' => 'Self', '_blank' => 'Blank'),
        'type' => 'select',
    ),
    // Quote After Image
    array('name' => 'Quote After Image',
        'desc' => 'Quote After Image',
        'id' => TF_THEME_PREFIX . '_quote_after_image',
        'value' => '',
        'type' => 'textarea',
    )
);
?>