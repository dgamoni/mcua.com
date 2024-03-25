<?php

/**
 * OneByOne slider's configurations
 *
 * @since The Practice 1.0
 */

$options = array(
    'tabs' => array(
        array(
            'name' => 'Slider Settings',
            'id' => 'slider_settings', #do no t change this ID
            'headings' => array(
                array(
                    'name' => 'Slider Settings',
                    'options' => array(
                        array('name' => 'Slider Title',
                            'desc' => 'Change the title of your slider. Only for internal use (Ex: Homepage)',
                            'id' => 'slider_title',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true),
                        array(
                            'name' => 'Slider Speed',
                            'desc' => 'Set the speed of the sliding animation in milliseconds.',
                            'id' => 'slider_slideSpeed',
                            'value' => '700',
                            'type' => 'text',
                            'required' => TRUE
                        ),
                        array(
                            'name' => 'Animation style',
                            'desc' => 'Set the easing of the sliding animation.',
                            'id' => 'slider_slideEasing',
                            'value' => 'easeInOutExpo',
                            'options' => array('linear' => 'Linear', 'swing' => 'Swing', 'easeInQuad' => 'EaseInQuad', 'easeOutQuad' => 'EaseOutQuad',
                                'easeInOutQuad' => 'EaseInOutQuad', 'easeInCubic' => 'EaseInCubic', 'easeOutCubic' => 'EaseOutCubic', 'easeInOutCubic' => 'EaseInOutCubic',
                                'easeInQuart' => 'EaseInQuart', 'easeOutQuart' => 'EaseOutQuart', 'easeInOutQuart' => 'EaseInOutQuart', 'easeInQuint' => 'EaseInQuint',
                                'easeOutQuint' => 'EaseOutQuint', 'easeInOutQuint' => 'EaseInOutQuint', 'easeInSine' => 'EaseInSine', 'easeOutSine' => 'EaseOutSine',
                                'easeInOutSine' => 'EaseInOutSine', 'easeInExpo' => 'EaseInExpo', 'easeOutExpo' => 'EaseOutExpo', 'easeInOutExpo' => 'EaseInOutExpo',
                                'easeInCirc' => 'EaseInCirc', 'easeOutCirc' => 'EaseOutCirc', 'easeInOutCirc' => 'EaseInOutCirc', 'easeInElastic' => 'EaseInElastic',
                                'easeOutElastic' => 'EaseOutElastic', 'easeInOutElastic' => 'EaseInOutElastic', 'easeInBack' => 'EaseInBack', 'easeOutBack' => 'EaseOutBack',
                                'easeInOutBack' => 'EaseInOutBack', 'easeInBounce' => 'EaseInBounce', 'easeOutBounce' => 'EaseOutBounce', 'easeInOutBounce' => 'EaseInOutBounce' ),
                            'type' => 'select',
                            'required' => TRUE
                        ),
                        array(
                            'name' => 'Randomize',
                            'desc' => ' Activate slides randomize.',
                            'id' => 'slider_randomize',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'required' => TRUE
                        ),
                        array(
                            'name' => 'Play',
                            'desc' => 'Autoplay slideshow, a positive number will set to true and be the time between slide animation in milliseconds',
                            'id' => 'slider_play',
                            'value' => '7000',
                            'type' => 'text',
                            'required' => TRUE
                        ),
                        array(
                            'name' => 'Hover Pause',
                            'desc' => 'Activate pause on hover.',
                            'id' => 'slider_hoverPause',
                            'value' => 'true',
                            'type' => 'checkbox',
                            'required' => TRUE
                        ),
                        array(
                            'name' => 'Pause',
                            'desc' => 'Pause slideshow on click of next/prev or pagination. A positive number will set to true and be the time of pause in milliseconds.',
                            'id' => 'slider_pause',
                            'value' => '7000',
                            'type' => 'text',
                            'required' => TRUE
                        ),
                        array('name' => 'Resize images?',
                            'desc' => 'Want to let our script to resize the images for you? Or do you want to have total control and upload images with the exact slider image size?',
                            'id' => 'slider_image_resize',
                            'value' => 'false',
                            'type' => 'checkbox')
                    )
                )
            )
        ),
        array(
            'name' => 'Add/Edit Slides',
            'id' => 'slider_setup', #do not change ID
            'headings' => array(
                array(
                    'name' => 'Add New Slide', #do not change
                    'options' => array(
                        array('name' => 'Title',
                            'desc' => ' The Title is displayed on the image and will be visible by the users',
                            'id' => 'slide_title',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true),
                        array('name' => 'Link Text',
                            'desc' => 'Set the title for the slide link.',
                            'id' => 'slide_link_text',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true),
                        array('name' => 'Link URL',
                            'desc' => 'Set the slide link URL.',
                            'id' => 'slide_link_url',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true),
                        array('name' => 'Link Target',
                            'desc' => '',
                            'id' => 'slide_link_target',
                            'value' => '',
                            'options' => array('_self' => 'Self', '_blank' => 'Blank'),
                            'type' => 'select',
                            'divider' => true),
                        // Custom Favicon Option
                        array('name' => 'Image <br />(870px × 440px)',
                            'desc' => 'You can upload an image from your hard drive or use one that was already uploaded by pressing  "Insert into Post" button from the image uploader plugin.',
                            'id' => 'slide_src',
                            'value' => '',
                            'type' => 'upload',
                            'media' => 'image',
                            'required' => TRUE),
                        //Image Link
                        array('name' => 'Image link',
                            'desc' => 'Set the image link.',
                            'id' => 'slide_url',
                            'value' => '',
                            'type' => 'text',
                           )
                    )
                )
            )
        ),
        array(
            'name' => 'Category Setup',
            'id' => 'slider_type_categories',
            'headings' => array(
                array(
                    'name' => 'Category options',
                    'options' => array(
                        array(
                            'name' => 'Select specific categories',
                            'desc' => 'Pick one or more 
categories by starting to type the category name. If you leave blank the slider will fetch images 
from all <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=category">Categories</a>.',
                            'id' => 'categories_select',
                            'type' => 'multi',
                            'subtype' => 'category'
                        ),
                        array(
                            'name' => 'Number of images in the slider',
                            'desc' => 'How many images do you want in the slider?',
                            'id' => 'sliders_posts_number',
                            'value' => 6,
                            'type' => 'text'
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Posts Setup',
            'id' => 'slider_type_posts',
            'headings' => array(
                array(
                    'name' => 'Posts options',
                    'options' => array(
                        array(
                            'name' => 'Select specific Posts',
                            'desc' => 'Pick one or more <a target="_new" href="' . get_admin_url() . 'edit.php">posts</a> by starting to type the Post name. The slider will be populated with images from the posts 
you selected.',
                            'id' => 'posts_select',
                            'type' => 'multi',
                            'subtype' => 'post'
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Tags Setup',
            'id' => 'slider_type_tags',
            'headings' => array(
                array(
                    'name' => 'Tags options',
                    'options' => array(
                        array(
                            'name' => 'Select specific tags',
                            'desc' => 'Pick one or more <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=post_tag">tags</a> by starting to type the tag name. The slider will be populated with images from posts 
that have the selected tags.',
                            'id' => 'tags_select',
                            'type' => 'multi',
                            'subtype' => 'post_tag'
                        )
                    )
                )
            )
        )
    )
);
$options['extra_options'] = array();
?>