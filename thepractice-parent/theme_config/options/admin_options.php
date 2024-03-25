<?php

/* ----------------------------------------------------------------------------------- */
/* Initializes all the theme settings option fields for admin area. */
/* ----------------------------------------------------------------------------------- */

$options = array(
    'tabs' => array(
        array(
            'name' => 'General',
            'type' => 'tab',
            'id' => TF_THEME_PREFIX . '_general',
            'headings' => array(
                array(
                    'name' => 'General Settings',
                    'options' => array(/* 1 */
                        // Custom Logo Option
                        array(
                            'name' => 'Custom Logo',
                            'desc' => 'Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)',
                            'id' => TF_THEME_PREFIX . '_logo',
                            'value' => '',
                            'type' => 'upload'
                        ),
                        // Custom Favicon Option
                        array(
                            'name' => 'Custom Favicon <br /> (16px x 16px)',
                            'desc' => 'Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.',
                            'id' => TF_THEME_PREFIX . '_favicon',
                            'value' => '',
                            'type' => 'upload',
                            'divider' => true
                        ),
                        // Search Box Text
                        array(
                            'name' => 'Search Box text',
                            'desc' => 'Enter your Search Box text',
                            'id' => TF_THEME_PREFIX . '_search_box_text',
                            'value' => 'Search this blog',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Tracking Code Option
                        array(
                            'name' => 'Tracking Code',
                            'desc' => 'Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.',
                            'id' => TF_THEME_PREFIX . '_google_analytics',
                            'value' => '',
                            'type' => 'textarea',
                            'divider' => true
                        ),
                        // Custom CSS Option
                        array(
                            'name' => 'Custom CSS',
                            'desc' => 'Quickly add some CSS to your theme by adding it to this block.',
                            'id' => TF_THEME_PREFIX . '_custom_css',
                            'value' => '',
                            'type' => 'textarea'
                        )
                    ) /* E1 */
                ),
                array(
                    'name' => 'Social',
                    'options' => array(
                        // RSS URL Option
                        array('name' => 'RSS URL',
                            'desc' => 'Enter your preferred RSS URL. (Feedburner or other)',
                            'id' => TF_THEME_PREFIX . '_feedburner_url',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // E-Mail URL Option
                        array('name' => 'E-Mail URL',
                            'desc' => 'Enter your preferred E-mail subscription URL. (Feedburner or other)',
                            'id' => TF_THEME_PREFIX . '_feedburner_id',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Facebook URL
                        array('name' => 'Facebook URL',
                            'desc' => 'Enter Facebook URL',
                            'id' => TF_THEME_PREFIX . '_facebook',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Twitter URL
                        array('name' => 'Twitter URL',
                            'desc' => 'Enter Twitter URL',
                            'id' => TF_THEME_PREFIX . '_twitter',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Twitter URL
                        array('name' => 'Devian Art URL',
                            'desc' => 'Enter Devian Art URL',
                            'id' => TF_THEME_PREFIX . '_devian',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Twitter URL
                        array('name' => 'Flickr URL',
                            'desc' => 'Enter Flickr URL',
                            'id' => TF_THEME_PREFIX . '_flickr',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        )
                    )
                ),
                array(
                    'name' => 'Copyright',
                    'options' => array(
                        //copyright
                        array('name' => 'Custom Copyright',
                            'desc' => 'Create your custom copyright',
                            'id' => TF_THEME_PREFIX . '_custom_copyright',
                            'value' => '<p>copyright 2012 - <strong>Law & Legal WordPress theme</strong> <br> made by Themefuse - <a href="http://themefuse.com">WordPress themes</a></p>',
                            'type' =>'textarea'
                        )
                    )
                ),
                array(
                    'name' => 'Disable Theme settings',
                    'options' => array(
                        // Remove To Top
                        array('name' => 'Remove TO TOP',
                            'desc' => 'Remove "TO TOP" scroll button',
                            'id' => TF_THEME_PREFIX . '_disable_to_top',
                            'value' => '',
                            'type' => 'checkbox'
                        ),
                        // Disable Image for All Single Posts
                        array('name' => 'Image on Single Post',
                            'desc' => 'Disable Image on All Single Posts? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_image',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Video for All Single Posts
                        array('name' => 'Video on Single Post',
                            'desc' => 'Disable Video on All Single Posts? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_video',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Comments for All Posts
                        array('name' => 'Post Comments',
                            'desc' => 'Disable Comments for All Posts? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_posts_comments',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Comments for All Pages
                        array('name' => 'Page Comments',
                            'desc' => 'Disable Comments for All Pages? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_pages_comments',
                            'value' => 'true',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Author Info
                        array('name' => 'Author Info',
                            'desc' => 'Disable Author Info? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_author_info',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Post Meta
                        array('name' => 'Post meta',
                            'desc' => 'Disable Post meta? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_post_meta',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Post Published Date
                        array('name' => 'Post Published Date',
                            'desc' => 'Disable Post Published Date? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_published_date',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable preloadCssImages plugin
                        array('name' => 'preloadCssImages',
                            'desc' => 'Disable jQuery-Plugin "preloadCssImages"? This plugin loads automatic all images from css.If you prefer performance(less requests) deactivate this plugin',
                            'id' => TF_THEME_PREFIX . '_disable_preload_css',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'on_update' => 'reload_page',
                            'divider' => true
                        ),
                        // Disable SEO
                        array('name' => 'SEO Tab',
                            'desc' => 'Disable SEO option?',
                            'id' => TF_THEME_PREFIX . '_disable_tfuse_seo_tab',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'on_update' => 'reload_page',
                            'divider' => true
                        ),
                        // Enable Dynamic Image Resizer Option
                        array('name' => 'Dynamic Image Resizer',
                            'desc' => 'This will Disable the thumb.php script that dynamicaly resizes images on your site. We recommend you keep this enabled, however note that for this to work you need to have "GD Library" installed on your server. This should be done by your hosting server administrator.',
                            'id' => TF_THEME_PREFIX . '_disable_resize',
                            'value' => 'false',
                            'type' => 'checkbox'
                        ),
						 array('name' => 'Image from content',
                            'desc' => 'If no thumbnail is specified then the first uploaded image in the post is used.',
                            'id' => TF_THEME_PREFIX . '_enable_content_img',
                            'value' => 'false',
                            'type' => 'checkbox'
                        ),
                        // Remove wordpress versions for security reasons
                        array(
                            'name' => 'Remove Wordpress Versions',
                            'desc' => 'Remove Wordpress versions from the source code, for security reasons.',
                            'id' => TF_THEME_PREFIX . '_remove_wp_versions',
                            'value' => FALSE,
                            'type' => 'checkbox'
                        )
                    )
                ),
                array(
                    'name' => 'WordPress Admin Style',
                    'options' => array(
                        // Disable Themefuse Style
                        array('name' => 'Disable Themefuse Style',
                            'desc' => 'Disable Themefuse Style',
                            'id' => TF_THEME_PREFIX . '_deactivate_tfuse_style',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'on_update' => 'reload_page'
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Homepage',
            'id' => TF_THEME_PREFIX . '_homepage',
            'headings' => array(
                array(
                    'name' => 'Homepage Population',
                    'options' => array(
                        array('name' => 'Homepage Population',
                            'desc' => ' Select which categories to display on homepage. More over you can choose to load a specific page or change the number of posts on the homepage from <a target="_blank" href="' . network_admin_url('options-reading.php') . '">here</a>',
                            'id' => TF_THEME_PREFIX . '_homepage_category',
                            'value' => '',
                            'options' => array('all' => 'From All Categories', 'specific' => 'From Specific Categories','page' =>'From Specific Page'),
                            'type' => 'select',
                            'install' => 'cat'
                        ),
                        array(
                            'name' => 'Select specific categories to display on homepage',
                            'desc' => 'Pick one or more
                            categories by starting to type the category name.',
                            'id' => TF_THEME_PREFIX . '_categories_select_categ',
                            'type' => 'multi',
                            'subtype' => 'category',
                        ),
                        // page on homepage
                        array('name' => 'Select Page',
                            'desc' => 'Select the page',
                            'id' => TF_THEME_PREFIX . '_home_page',
                            'value' => 'image',
                            'options' => tfuse_list_page_options(),
                            'type' => 'select',
                        ),
                        array('name' => 'Use page options',
                            'desc' => 'Use page options',
                            'id' => TF_THEME_PREFIX . '_use_page_options',
                            'value' => 'false',
                            'type' => 'checkbox'
                        )
                    )
                ),
                array(
                    'name' => 'Homepage Header',
                    'options' => array(
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
                        )
                    )
                ),
                array(
                    'name' => 'Homepage Shortcodes',
                    'options' => array(
                        // Bottom Shortcodes
                        array('name' => 'Shortcodes after Content',
                            'desc' => 'In this textarea you can input your prefered custom shotcodes.',
                            'id' => TF_THEME_PREFIX . '_content_bottom',
                            'value' => '',
                            'type' => 'textarea'
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Blog',
            'id' => TF_THEME_PREFIX . '_blogpage',
            'headings' => array(
                array(
                    'name' => 'Blog Page Population',
                    'options' => array(
                        array('name' => 'Select Page',
                            'desc' => 'Select the page',
                            'id' => TF_THEME_PREFIX . '_blog_page',
                            'value' => 'image',
                            'options' => tfuse_list_page_options(),
                            'type' => 'select',
                        ),
                        array('name' => 'Blog Page Population',
                            'desc' => ' Select which categories to display on blog page. More over you can choose to load a specific page or change the number of posts on the homepage from <a target="_blank" href="' . network_admin_url('options-reading.php') . '">here</a>',
                            'id' => TF_THEME_PREFIX . '_blogpage_category',
                            'value' => '',
                            'options' => array('all' => 'From All Categories', 'specific' => 'From Specific Categories'),
                            'type' => 'select',
                            'install' => 'cat'
                        ),
                        array(
                            'name' => 'Select specific categories to display on blog page',
                            'desc' => 'Pick one or more
                            categories by starting to type the category name.',
                            'id' => TF_THEME_PREFIX . '_categories_select_categ_blog',
                            'type' => 'multi',
                            'subtype' => 'category',
                        )
                    )
                ),
                array(
                    'name' => 'Blog Page Header',
                    'options' => array(
                        // Element of Hedear
                        array('name' => 'Element of Hedear',
                            'desc' => 'Select type of element on the header.',
                            'id' => TF_THEME_PREFIX . '_header_element_blog',
                            'value' => 'image',
                            'options' => array('none' => 'Without Header Element', 'slider' => 'Slider on Header', 'image' => 'Image on Header','map'=>'Map on Header'),
                            'type' => 'select',
                            'divider' => true
                        ),
                        // Quote Before Slider
                        array('name' => 'Quote Before Slider',
                            'desc' => 'Quote Before Slider',
                            'id' => TF_THEME_PREFIX . '_quote_before_slider_blog',
                            'value' => '',
                            'type' => 'textarea',
                            'divider' => true
                        ),
                        // Select Slider
                        $this->ext->slider->model->has_sliders() ?
                            array(
                                'name' => 'Slider',
                                'desc' => 'Select a slider for your post. The sliders are created on the <a href="' . admin_url( 'admin.php?page=tf_slider_list' ) . '" target="_blank">Sliders page</a>.',
                                'id' => TF_THEME_PREFIX . '_select_slider_blog',
                                'value' => '',
                                'options' => $TFUSE->ext->slider->get_sliders_dropdown(),
                                'type' => 'select'
                            ) :
                            array(
                                'name' => 'Slider',
                                'desc' => '',
                                'id' => TF_THEME_PREFIX . '_select_slider_blog',
                                'value' => '',
                                'html' => 'No sliders created yet. You can start creating one <a href="' . admin_url('admin.php?page=tf_slider_list') . '">here</a>.',
                                'type' => 'raw'
                            ),
                        // Header Image
                        array('name' => 'Header Image',
                            'desc' => 'Upload an image for your header. It will be resized to 870x276 px',
                            'id' => TF_THEME_PREFIX . '_header_image_blog',
                            'value' => '',
                            'type' => 'upload',
                            'divider' => true
                        ),
                        // Image Caption
                        array('name' => 'Image Caption',
                            'desc' => 'Caption pentru imagine',
                            'id' => TF_THEME_PREFIX . '_image_caption_blog',
                            'value' => '',
                            'type' => 'text',
                        ),
                        // Link Text
                        array('name' => 'Link Text',
                            'desc' => 'Test pentru link',
                            'id' => TF_THEME_PREFIX . '_link_text_blog',
                            'value' => '',
                            'type' => 'text',
                        ),
                        // Link Text
                        array('name' => 'Link URL',
                            'desc' => 'URL pentru link',
                            'id' => TF_THEME_PREFIX . '_link_url_blog',
                            'value' => '',
                            'type' => 'text',
                        ),
                        // Link Target
                        array('name' => 'Link Target',
                            'desc' => 'Target pentru link',
                            'id' => TF_THEME_PREFIX . '_link_target_blog',
                            'value' => '_self',
                            'options' => array('_self' => 'Self', '_blank' => 'Blank'),
                            'type' => 'select',
                            'divider' => true
                        ),
                        // Quote After Image
                        array('name' => 'Quote After Image',
                            'desc' => 'Quote After Image',
                            'id' => TF_THEME_PREFIX . '_quote_after_image_blog',
                            'value' => '',
                            'type' => 'textarea',
                        ),
                        // Map Latitude
                        array('name' => 'Latitude',
                            'desc' => 'Specifies the latitude of the map',
                            'id' => TF_THEME_PREFIX . '_map_lat_blog',
                            'value' => '',
                            'type' => 'text',
                        ),
                        // Map Longitude
                        array('name' => 'Longitude',
                            'desc' => 'Specifies the longitude of the map',
                            'id' => TF_THEME_PREFIX . '_map_long_blog',
                            'value' => '',
                            'type' => 'text',
                        ),
                        // Map Zoom
                        array('name' => 'Zoom',
                            'desc' => 'Specifies the zooming of the map',
                            'id' => TF_THEME_PREFIX . '_map_zoom_blog',
                            'value' => '3',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Map Type
                        array('name' => 'Type',
                            'desc' => 'Specifies the type of the map',
                            'id' => TF_THEME_PREFIX . '_map_type_blog',
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
                            'id' => TF_THEME_PREFIX . '_map_address_blog',
                            'value' => '',
                            'type' => 'text',
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Posts',
            'id' => TF_THEME_PREFIX . '_posts',
            'headings' => array(
                array(
                    'name' => 'Default Post Options',
                    'options' => array(
                        // Cases per page
                        array('name' => 'Cases per page',
                            'desc' => 'Set how many cases will have a page taxonomy.',
                            'id' => TF_THEME_PREFIX . '_cases_per_page',
                            'value' => '4',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Post Content
                        array('name' => 'Post Content',
                            'desc' => 'Select if you want to show the full content (use <em>more</em> tag) or the excerpt on posts listings (categories).',
                            'id' => TF_THEME_PREFIX . '_post_content',
                            'value' => 'excerpt',
                            'options' => array('excerpt' => 'The Excerpt', 'content' => 'Full Content'),
                            'type' => 'select',
                            'divider' => true
                        ),
                        // Single Image Position
                        array('name' => 'Image Position',
                            'desc' => 'Select your preferred image alignment',
                            'id' => TF_THEME_PREFIX . '_single_image_position',
                            'value' => 'alignleft',
                            'type' => 'images',
                            'options' => array('alignleft' => array($url . 'left_off.png', 'Align to the left'), 'alignright' => array($url . 'right_off.png', 'Align to the right'))
                        ),
                        // Single Image Dimensions
                        array('name' => 'Image Resize (px)',
                            'desc' => 'These are the default width and height values. If you want to resize the image change the values with your own. If you input only one, the image will get resized with constrained proportions based on the one you specified.',
                            'id' => TF_THEME_PREFIX . '_single_image_dimensions',
                            'value' => array(576, 262),
                            'type' => 'textarray',
                            'divider' => true
                        ),
                        // Thumbnail Posts Position
                        array('name' => 'Thumbnail Position',
                            'desc' => 'Select your preferred thumbnail alignment',
                            'id' => TF_THEME_PREFIX . '_thumbnail_position',
                            'value' => 'alignleft',
                            'type' => 'images',
                            'options' => array('alignleft' => array($url . 'left_off.png', 'Align to the left'), 'alignright' => array($url . 'right_off.png', 'Align to the right'))
                        ),
                        // Posts Thumbnail Dimensions
                        array('name' => 'Thumbnail Resize (px)',
                            'desc' => 'These are the default width and height values. If you want to resize the thumbnail change the values with your own. If you input only one, the thumbnail will get resized with constrained proportions based on the one you specified.',
                            'id' => TF_THEME_PREFIX . '_thumbnail_dimensions',
                            'value' => array(576, 262),
                            'type' => 'textarray',
                            'divider' => true
                        ),
                        // Video Position
                        array('name' => 'Video Position',
                            'desc' => 'Select your preferred video alignment',
                            'id' => TF_THEME_PREFIX . '_video_position',
                            'value' => 'alignleft',
                            'type' => 'images',
                            'options' => array('alignleft' => array($url . 'left_off.png', 'Align to the left'), 'alignright' => array($url . 'right_off.png', 'Align to the right'))
                        ),
                        // Video Dimensions
                        array('name' => 'Video Resize (px)',
                            'desc' => 'These are the default width and height values. If you want to resize the video change the values with your own. If you input only one, the video will get resized with constrained proportions based on the one you specified.',
                            'id' => TF_THEME_PREFIX . '_video_dimensions',
                            'value' => array(576, 349),
                            'type' => 'textarray'
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Background',
            'id' => TF_THEME_PREFIX . '_background',
            'headings' => array(
                array(
                    'name' => 'Background',
                    'options' => array(
                        array('name' => 'Color',
                            'desc' => 'Choose background color.',
                            'id' => TF_THEME_PREFIX . '_background_color',
                            'value' => '#dadada',
                            'type' => 'colorpicker',
                            'divider' => true
                        ),
                        array('name' => 'Pattern',
                            'desc' => 'Choose background pattern.',
                            'id' => TF_THEME_PREFIX . '_background_pattern',
                            'value' => '',
                            'type' => 'upload',
                        )

                    )
                )

            )
        ),
        array(
            'name' => 'Footer',
            'id' => TF_THEME_PREFIX . '_footer',
            'headings' => array(
                array(
                    'name' => 'Footer Content',
                    'options' => array(
                        // Enable Footer Shortcodes
                        array('name' => 'Enable Footer Shortcodes',
                            'desc' => 'This will enable footer shortcodes.',
                            'id' => TF_THEME_PREFIX . '_enable_footer_shortcodes',
                            'value' => '',
                            'type' => 'checkbox'
                        ),
                        // Footer Shortcodes
                        array('name' => 'Footer Shortcodes',
                            'desc' => 'In this textarea you can input your prefered custom shotcodes.',
                            'id' => TF_THEME_PREFIX . '_footer_shortcodes',
                            'value' => '',
                            'type' => 'textarea'
                        ),
                        // Enable Footer Support
                        array('name' => 'Enable Footer Suport',
                            'desc' => 'This will enable footer support.',
                            'id' => TF_THEME_PREFIX . '_enable_footer_support',
                            'value' => '',
                            'type' => 'checkbox'
                        ),
                        // Footer Support
                        array('name' => 'Footer Support',
                            'desc' => 'In this textarea you can input your prefered custom shotcodes.',
                            'id' => TF_THEME_PREFIX . '_footer_support',
                            'value' => '',
                            'type' => 'textarea'
                        )
                    )
                )
            )
        )
    )
);
?>