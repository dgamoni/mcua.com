<?php

/* ----------------------------------------------------------------------------------- */
/* Initializes all the theme settings option fields for pages area. */
/* ----------------------------------------------------------------------------------- */

$options = array(
    /* ----------------------------------------------------------------------------------- */
    /* Sidebar */
    /* ----------------------------------------------------------------------------------- */

    /* Single Page */
    array('name' => 'Single Page',
        'id' => TF_THEME_PREFIX . '_side_media',
        'type' => 'metabox',
        'context' => 'side',
        'priority' => 'low' /* high/low */
    ),
    // Disable Page Comments
    array('name' => 'Disable Comments',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_comments',
        'value' => tfuse_options('disable_page_comments','true'),
        'type' => 'checkbox',
        'divider' => true
    ),
    // Page Title
    array('name' => 'Page Title',
        'desc' => 'Select your preferred Page Title.',
        'id' => TF_THEME_PREFIX . '_page_title',
        'value' => 'default_title',
        'options' => array('hide_title' => 'Hide Page Title', 'default_title' => 'Default Title', 'custom_title' => 'Custom Title'),
        'type' => 'select'
    ),
    // Custom Title
    array('name' => 'Custom Title',
        'desc' => 'Enter your custom title for this page.',
        'id' => TF_THEME_PREFIX . '_custom_title',
        'value' => '',
        'type' => 'text'
    ),
    
    /* ----------------------------------------------------------------------------------- */
    /* After Textarea */
    /* ----------------------------------------------------------------------------------- */

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
        'options' => array('none' => 'Without Header Element', 'slider' => 'Slider on Header', 'image' => 'Image on Header','map'=>'Map on Header'),
        'type' => 'select',
        'divider' => true
    ),
    // Quote Before Slider
    array('name' => 'Quote Before Slider',
        'desc' => 'Quote Before Slider',
        'id' => TF_THEME_PREFIX . '_quote_before_slider',
        'value' => '',
        'type' => 'textarea',
        'divider' => true
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
    ),
    // Link Target
    array('name' => 'Link Target',
        'desc' => 'Target pentru link',
        'id' => TF_THEME_PREFIX . '_link_target',
        'value' => '_self',
        'options' => array('_self' => 'Self', '_blank' => 'Blank'),
        'type' => 'select',
        'divider' => true
    ),
    // Quote After Image
    array('name' => 'Quote After Image',
        'desc' => 'Quote After Image',
        'id' => TF_THEME_PREFIX . '_quote_after_image',
        'value' => '',
        'type' => 'textarea',
    ),
    // Map Latitude
    array('name' => 'Latitude',
        'desc' => 'Specifies the latitude of the map',
        'id' => TF_THEME_PREFIX . '_map_lat',
        'value' => '',
        'type' => 'text',
    ),
    // Map Longitude
    array('name' => 'Longitude',
        'desc' => 'Specifies the longitude of the map',
        'id' => TF_THEME_PREFIX . '_map_long',
        'value' => '',
        'type' => 'text',
    ),
    // Map Zoom
    array('name' => 'Zoom',
        'desc' => 'Specifies the zooming of the map',
        'id' => TF_THEME_PREFIX . '_map_zoom',
        'value' => '3',
        'type' => 'text',
        'divider' => true
    ),
    // Map Type
    array('name' => 'Type',
        'desc' => 'Specifies the type of the map',
        'id' => TF_THEME_PREFIX . '_map_type',
        'value' => '',
        'options' => array(
            'map1' => '1',
            'map2' => '2',
            'map3' => '3'
        ),
        'type' => 'select'
    ),
    // Map Address
    array('name' => 'Address',
        'desc' => 'Specifies the address of the map',
        'id' => TF_THEME_PREFIX . '_map_address',
        'value' => '',
        'type' => 'text',
    ),
    // Bottom Shortcodes
    array('name' => 'Shortcodes after Content',
        'desc' => 'In this textarea you can input your prefered custom shotcodes.',
        'id' => TF_THEME_PREFIX . '_content_bottom',
        'value' => '',
        'type' => 'textarea'
    )

);
/* * *********************************************************
  Advanced
 * ********************************************************** */
?>