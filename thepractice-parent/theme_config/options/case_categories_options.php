<?php

/* ----------------------------------------------------------------------------------- */
/* Initializes all the theme settings option fields for categories area.             */
/* ----------------------------------------------------------------------------------- */

$options = array(
    // Element of Hedear
    array('name' => 'Element of Hedear',
        'desc' => 'Select type of element on the header.',
        'id' => TF_THEME_PREFIX . '_header_element',
        'value' => 'image',
        'options' => array('none' => 'Without Header Element', 'slider' => 'Slider on Header', 'image' => 'Image on Header','map'=>'Map on Header'),
        'type' => 'select',
    ),
    // Quote Before Slider
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
    )
);

?>