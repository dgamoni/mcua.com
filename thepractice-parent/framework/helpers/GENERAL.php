<?php
add_action('wp_ajax_change_gallery_id', 'change_gallery_id');
function change_gallery_id()
{
    $post_id   = $_REQUEST['post_id'];
    if(!tfuse_parse_boolean($_REQUEST['change'])) {echo json_encode(array('id'=> $post_id));die;}
    $id        = $_REQUEST['input_id'];
    $media     = $_REQUEST['media'];

    $_token    = (trim($id) != '') ? $id . '_' . $post_id : $post_id;
    $post_fnc  = ($media == 'image') ? 'tfuse_gallery_group_post' : 'tfuse_download_group_post';
    $post_type = str_replace('_post', '', $post_fnc);
    $post      = get_post($post_id);
    if ($post->post_type != $post_type)
        $post_id = $post_fnc($_token);
    echo json_encode(array('id'=> $post_id));
    die;
}

add_filter('attachment_fields_to_edit', 'media_galery_image_edit', 11, 2);
function media_galery_image_edit($form_fields, $post)
{
    $content = get_post_meta($post->ID,'image_options',true);
    $form_fields['tfseek_exclude_slider'] = array(
        'label' => __('Exclude from slider', 'tfuse'),
        'input' => 'html',
        'html'  => '<label for="imgexcludefromslider_check"><input id="imgexcludefromslider_check" type="checkbox" ' . (@$content['imgexcludefromslider_check'] ? 'checked' : '') . ' value="yes" name="imgexcludefromslider_check_'.$post->ID.'"/> <span>' . __('Yes', 'tfuse') . '</span></label>'
    );

    $form_fields['tfseek_main'] = array(
        'label' => __('Set as main', 'tfuse'),
        'input' => 'html',
        'html'  => '<label for="imgmain_check"><input id="imgmain_check" type="checkbox" ' . (@$content['imgmain_check']== 'yes'? 'checked' : '') . ' value="yes" name="imgmain_check_'.$post->ID.'"/> <span>' . __('Yes', 'tfuse') . '</span></label>'
    );

    return $form_fields;
}

function tfuse_get_gallery_images($post_id,$input_id){
    $_token = $input_id . '_' . $post_id;
    global $wpdb;
    $_args = array('post_type' => 'tfuse_gallery_group', 'post_name' => 'tf_gallery_' . $_token, 'post_status' => 'draft', 'comment_status' => 'closed', 'ping_status' => 'closed');
    $query = 'SELECT ID FROM ' . $wpdb->posts . ' WHERE post_parent = 0';

    foreach ($_args as $k => $v) {
        $query .= ' AND ' . $k . ' = "' . $v . '"';
    }
    $query .= ' LIMIT 1';

    $_posts = $wpdb->get_row($query);
    $images = array();
    if ($_posts) $images = &get_children('post_type=attachment&post_parent='.$_posts->ID);
    foreach($images as $key=>$image){
        $images[$key]->image_options = get_post_meta($image->ID,'image_options',true);
    }
    return $images;
}

add_filter('attachment_fields_to_save', 'media_galery_image_save', 11, 2);
function media_galery_image_save($post, $attachment){
    $a = array();
    if(isset($_POST['imgexcludefromslider_check_'.$post['ID']]))
        $a['imgexcludefromslider_check'] = $_POST['imgexcludefromslider_check_'.$post['ID']];
    if(isset($_POST['imgmain_check_'.$post['ID']]))
        $a['imgmain_check'] = $_POST['imgmain_check_'.$post['ID']];
    update_post_meta($post['ID'],'image_options',$a);
    return $post;
}

function remove_media_tabs($tabs)
{
    if (isset($_REQUEST['no_tabs'])) {
        unset($tabs['library']);
        unset($tabs['type_url']);
    }
    return $tabs;
}
add_filter('media_upload_tabs', 'remove_media_tabs');

/**
 * Extract form options array for optigen/interface, only id=>value
 */
function tf_only_options(&$options, $without_types = array(), $only_types = array(), &$__recursionData = NULL)
{
    global $TFUSE;
    if (gettype(@$TFUSE->optigen) != 'object') die( user_error('$TFUSE is not loaded', E_USER_ERROR) );

    if ($__recursionData === NULL)
    {
        $__recursionData['without_types']   = (array)$without_types;
        $__recursionData['only_types']      = (array)$only_types;
        $__recursionData['check_without']   = count($without_types);
        $__recursionData['check_only']      = count($only_types);
    }

    $collectedOptions = array();

    if (is_array($options) && count($options)) {
        foreach ($options as $key=>$option)
        {
            if (!is_array($option))
                continue;

            // Check if option has correct structure
            if (isset($option['type'])
                && substr($option['type'], 0, 1) != '_'
                && method_exists($TFUSE->optigen, $option['type'])
                && isset($option['id'])
            ){
                if ($__recursionData['check_only'])
                    if (!in_array($option['type'], $__recursionData['only_types']))
                        continue;
                if ($__recursionData['check_without'])
                    if (in_array($option['type'], $__recursionData['without_types']))
                        continue;

                $collectedOptions[$option['id']] = $option;
            }
            else
            {
                $collectedOptions = array_merge(
                    $collectedOptions,
                    tf_only_options( $option, array(), array(), $__recursionData)
                );
            }
        }
    }

    return $collectedOptions;
}

if (!function_exists('tfuse_qtranslate')) :

//qTranslate for custom fields
    function tfuse_qtranslate($text)
    {
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

        if (function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage'))
            $text = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);

        return $text;
    }

endif;

function tf_print($output, $die = false)
{
    static $first = false;
    if (!$first) echo '<div style="height:25px;"></div>';
    $first = true;

    echo '<div style="max-height:500px;overflow-y:scroll;background:#111;margin:10px;padding:0;border:1px solid #F5F5F5;">';
        echo '<pre style="color:#47EE47;text-shadow:1px 1px 0 #000;font-family:Consolas,monospace;font-size:12px;margin:0;padding:5px;display:block;line-height:16px;">';
            print htmlentities( print_r($output, true), ENT_QUOTES, 'UTF-8');
        echo '</pre>';
    echo '</div>';

    if ($die) die();
}

function tfuse_parse_boolean($option)
{
    return filter_var($option, FILTER_VALIDATE_BOOLEAN);
}

function tfuse_options($option_name, $default = NULL, $cat_id = NULL)
{
    global $tfuse_options;

    // optiunile sunt slavate cu PREFIX in fata, dar extragem scrim fara PREFIX
    // pentru a obtine PREFIX_logo vom folosi tfuse_options('logo')
    $option_name = TF_THEME_PREFIX . '_' . $option_name;

    if ($cat_id !== NULL) {
        if (@isset($tfuse_options['taxonomy'][$cat_id][$option_name]))
            $value = $tfuse_options['taxonomy'][$cat_id][$option_name];
    }
    else {
        if (!isset($tfuse_options['framework']))
            $tfuse_options['framework'] = decode_tfuse_options(get_option(TF_THEME_PREFIX . '_tfuse_framework_options'));

        if (isset($tfuse_options['framework'][$option_name]))
            $value = $tfuse_options['framework'][$option_name];
    }

    if (isset($value) && $value !== '')
        return $value;
    else
        return $default;
}

function tfuse_set_option($option_name, $value, $cat_id = NULL)
{
    global $tfuse_options;

    // optiunile sunt slavate cu PREFIX in fata, dar cind le setam scriem fara PREFIX
    // pentru a seta PREFIX_logo vom folosi tfuse_set_option('logo','http://themefuse.com/images/logo.png')
    $option_name = TF_THEME_PREFIX . '_' . $option_name;

    if ($cat_id !== NULL) {
        if (isset($tfuse_options['taxonomy']))
            $tfuse_taxonomy_options = $tfuse_options['taxonomy'];
        else
            $tfuse_taxonomy_options = $tfuse_options['taxonomy'] = decode_tfuse_options(get_option(TF_THEME_PREFIX . '_tfuse_taxonomy_options'));

        @$tfuse_options['taxonomy'][$cat_id][$option_name] = @$tfuse_taxonomy_options[$cat_id][$option_name] = $value;

        return update_option(TF_THEME_PREFIX . '_tfuse_taxonomy_options', encode_tfuse_options($tfuse_taxonomy_options));
    }
    else {
        if (isset($tfuse_options['framework']))
            $tfuse_framework_options = $tfuse_options['framework'];
        else
            $tfuse_framework_options = $tfuse_options = decode_tfuse_options(get_option(TF_THEME_PREFIX . '_tfuse_framework_options'));

        $tfuse_options['framework'][$option_name] = $tfuse_framework_options[$option_name] = $value;

        return update_option(TF_THEME_PREFIX . '_tfuse_framework_options', encode_tfuse_options($tfuse_framework_options) );
    }
}

function tfuse_page_options($option_name, $default = NULL, $post_id = NULL)
{
    global $post, $tfuse_options;

    if (!isset($post_id) && isset($post))
        $post_id = $post->ID;
    if (!isset($post_id))
        return;

    // optiunile sunt slavate cu PREFIX in fata, dar extragem scrim fara PREFIX
    // pentru a obtine PREFIX_logo vom folosi tfuse_page_options('logo')
    $option_name = TF_THEME_PREFIX . '_' . $option_name;

    if (isset($tfuse_options['post'][$post_id][$option_name]))
        $value = $tfuse_options['post'][$post_id][$option_name];
    else {
        $_options                        = get_post_meta($post_id, TF_THEME_PREFIX . '_tfuse_post_options', true);
        $tfuse_options['post'][$post_id] = decode_tfuse_options($_options);
        if (isset($tfuse_options['post'][$post_id][$option_name]))
            $value = $tfuse_options['post'][$post_id][$option_name];
    }

    if (isset($value) && $value !== '')
        return $value;
    else
        return $default;
}

function tfuse_set_page_option($option_name, $value, $post_id = NULL)
{
    global $post, $tfuse_options;

    if (!isset($post_id) && isset($post))
        $post_id = $post->ID;
    if (!isset($post_id))
        return;

    // optiunile sunt slavate cu PREFIX in fata, dar extragem scrim fara PREFIX
    // pentru a obtine PREFIX_logo vom folosi tfuse_page_options('logo')
    $option_name = TF_THEME_PREFIX . '_' . $option_name;

    if (!isset($tfuse_options['post'][$post_id]))
        $tfuse_options['post'][$post_id] = decode_tfuse_options( get_post_meta($post_id, TF_THEME_PREFIX . '_tfuse_post_options', true) );

    $tfuse_options['post'][$post_id][$option_name] = $value;

    update_post_meta($post_id, TF_THEME_PREFIX . '_tfuse_post_options', encode_tfuse_options($tfuse_options['post'][$post_id]));
}

function decode_tfuse_options($tfuse_options)
{
    if (!is_array($tfuse_options))
        return;
    array_walk_recursive($tfuse_options, 'tfuse_apply_qtranslate');
    return $tfuse_options;
}
function tfuse_apply_qtranslate(&$item)
{
    if (strtolower($item) === 'true')
        $item = TRUE;
    elseif (strtolower($item) === 'false')
        $item = FALSE;
    else
        $item = tfuse_qtranslate($item);
}

function encode_tfuse_options($tfuse_options)
{
    if (!is_array($tfuse_options))
        return tfuse_unapply_qtranslate($tfuse_options);

    array_walk_recursive($tfuse_options, 'tfuse_unapply_qtranslate');
    return $tfuse_options;
}

function tfuse_unapply_qtranslate(&$item)
{
    if ($item === true)
        $item = 'true';
    elseif ($item === false)
        $item = 'false';
    else
        $item = $item;
}

function tfget(&$val)
{
    if (isset($val))
        return $val;
    else
        return NULL;
}

/**
 * Obtine o pparte specifica din string
 * @param string $str Stringul di ncare vrem sa opbtinem prescurtata ...
 * @param string $more Stringul di ncare vrem sa opbtinem prescurtata ...
 * @param int $length Stringul di ncare vrem sa opbtinem prescurtata ...
 * @param int $minword Stringul di ncare vrem sa opbtinem prescurtata ...
 * @return string The image link if one is located.
 */
function tfuse_substr($str, $length, $more = '...', $minword = 3)
{
    $sub = '';
    $len = 0;

    foreach (explode(' ', $str) as $word) {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);

        if (strlen($word) > $minword && strlen($sub) >= $length)
            break;
    }

    return (($len < strlen($str)) ? $sub . ' ' . $more : $sub);
}

/**
 * Retrieve the uri of the highest priority file that exists.
 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
 * inherit from a parent theme can just overload one file.
 * @since 2.0
 * @param string $file File to search for, in order.
 * @return string The file link if one is located.
 */
function tfuse_get_file_uri($file)
{
    $file = ltrim($file, '/');
    if (file_exists(STYLESHEETPATH . '/' . $file))
        return get_stylesheet_directory_uri() . '/' . $file;
    else if (file_exists(TEMPLATEPATH . '/' . $file))
        return get_template_directory_uri() . '/' . $file;
    else
        return $file;
}

function tfuse_logo($echo = FALSE)
{
    $logo = tfuse_get_file_uri('/images/logo.png');
    return tfuse_options('logo', $logo);
}

function tfuse_logo_footer($echo = FALSE)
{
    $logo_footer = tfuse_get_file_uri('/images/logo_footer.png');
    return tfuse_options('logo_footer', $logo_footer);
}

function tfuse_favicon_and_css()
{
    // Favicon
    $favicon = tfuse_options('favicon');
    if (!empty($favicon))
        echo '<link rel="shortcut icon" href="' . $favicon . '"/>' . PHP_EOL;

    // Custom CSS block in header
    $custom_css = tfuse_options('custom_css');
    if (!empty($custom_css)) {
        $output = '<style type="text/css">' . PHP_EOL;
        $output .= esc_attr($custom_css) . PHP_EOL;
        $output .= '</style>' . PHP_EOL;
        echo $output;
    }
}

add_action('wp_head', 'tfuse_favicon_and_css');

function tfuse_analytics()
{
    echo tfuse_options('google_analytics');
}

add_action('wp_footer', 'tfuse_analytics', 100);

function tf_extimage($extension_name, $image_name)
{
    $extension_name = strtolower($extension_name);
    return TFUSE_EXT_URI . '/' . $extension_name . '/static/images/' . $image_name;
}

function tf_config_extimage($extension_name, $image_name)
{
    $extension_name = strtolower($extension_name);
    return TFUSE_EXT_CONFIG_URI . '/' . $extension_name . '/static/images/' . $image_name;
}

function tfuse_formatter($content)
{
    $new_content      = '';
    $pattern_full     = '{(\[raw\].*?\[/raw\])}is';
    $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
    $pieces           = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

    foreach ($pieces as $piece) {
        if (preg_match($pattern_contents, $piece, $matches)) {
            $new_content .= $matches[1];
        } else {
            $new_content .= wptexturize(wpautop($piece));
        }
    }
    return $new_content;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'tfuse_formatter', 99);
add_filter('themefuse_shortcodes', 'tfuse_formatter', 99);

/**
 * JSON encodes the array, echoes it and dies.
 * Mainly used in AJAX returns
 * @param array $array
 */
function tfjecho($array)
{
    die(json_encode($array));
}

function tfuse_pk($data)
{
    return urlencode(serialize($data));
}

function tfuse_unpk($data)
{
    return tfuse_mb_unserialize(urldecode($data));
}

function tfuse_mb_unserialize($serial_str)
{
    static $adds_slashes = -1;
    if ($adds_slashes === -1) // Check if preg replace adds slashes
        $adds_slashes = (false !== strpos( preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", 's:1:""";'), '\"' ));

    $result = @unserialize( preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str) );
    return ( $adds_slashes ? tf_stripslashes_deep( $result ) : $result );
}
function tf_stripslashes_deep($value)
{
    return is_array($value)
        ? array_map('stripslashes_deep', $value)
        : ( is_string($value)
            ? stripslashes($value)
            : $value );
}

function thumb_link($url)
{
    if (is_multisite()) {
        global $blog_id;
        if (isset($blog_id) && $blog_id > 0) {
            $imageParts = explode('/files/', $url);
            if (isset($imageParts[1]))
                $url = network_site_url() . '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
        }
    }
    return $url;
}

function tf_can_ajax()
{
    if (!current_user_can('publish_pages'))
        tfjecho(array('status'  => -1,
                      'message' => 'You do not have the required privileges for this action.'));
}

function is_tf_front_page()
{
    global $is_tf_front_page;
    return (bool)$is_tf_front_page;
}

function tf_cdata_decode($value)
{
    return preg_replace('/<!\[CDATA\[\s*|\s*\]\]>/uis', '', $value);
}
function tf_is_cdata($value){
    return preg_match('/^<!\[CDATA\[/uis', trim($value));
}

function tf_mb_unserialize($serial_str)
{
    $result = unserialize( $serial_str );

    if($result === false){ // if failed, try this
        $serial_str = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen(stripcslashes('$2')).':\"'.stripcslashes('$2').'\";'", $serial_str );
        $serial_str = str_replace("\r", "", $serial_str);
        //$serial_str= str_replace("\n", "", $serial_str);

        $result = unserialize($serial_str);
    }

    return $result;
}

/**
 * Find recursively keys value in array
 * $keys can be explode('.', 'a.b') or 'a.b'
 *
 * Initial array(a=>array(b=>foo))
 * $keys=[a,b] -> return array[a][b] -> value
 * $keys=[a.c] -> return array[a][ UNDEFINED ] -> NULL
 *
 * TEST:
$temp = array('a' => array('b'=>'val1') );
var_dump( array(
    tf_array_get_keys_value('a', $temp),
    tf_array_get_keys_value('a.b', $temp),
    tf_array_get_keys_value('a.b.c', $temp),
    tf_array_get_keys_value('a.c', $temp),
));
 */
function tf_akg($keys, $array, $defaultValue = NULL){ return tf_array_get_keys_value ($keys, $array, $defaultValue); }
// Alias
function tf_array_get_keys_value ($keys, $array, $defaultValue = NULL) {
    if (is_string($keys) || is_int($keys))
        $keys = explode('.', (string)$keys );

    $key = array_shift($keys);
    if ($key === NULL) return $defaultValue;

    if (!isset($array[$key])) return $defaultValue;

    if (isset($keys[0])) { // not used count() for performance reasons
        return tf_array_get_keys_value($keys, $array[$key], $defaultValue);
    } else {
        return $array[$key];
    }
}

/**
 * Set (or create if not exists) value for specified key in some keys level
 *
 * TEST:
$test = array();
tf_array_set_keys_value('a.b', 2, $test);
tf_array_set_keys_value('a.b.c', 3, $test);
tf_array_set_keys_value('a.c', array('test'), $test);
tf_print($test);
tf_print( tf_array_get_keys_value('a.b', $test) );
 */
function tf_aks($keys, $value, &$array){ return tf_array_set_keys_value ($keys, $value, $array); }
// Alias
function tf_array_set_keys_value ($keys, $value, &$array) {
    if (is_string($keys) || is_int($keys))
        $keys = explode('.', (string)$keys );

    $key = array_shift($keys);
    if ($key === NULL) return;

    if (!isset($array[$key])) $array[$key] = array();

    if (isset($keys[0])) { // not used count() for performance reasons
        if (!is_array($array[$key])) $array[$key] = array();

        tf_array_set_keys_value($keys, $value, $array[$key]);
    } else {
        $array[$key] = $value;
        return;
    }
}

/**
 * Generate random unique md5
 */
function tf_md5rand()
{
    static $i = 0;

    return md5( time() .'-'. ($i++) .'-'. mt_rand(3, 777) );
}

/**
 * usort() but maintain the order of equal members
 */
function tf_usort(&$array, $cmp_function) {
    // Arrays of size < 2 require no action.
    if (count($array) < 2) return;
    // Split the array in half
    $halfway = count($array) / 2;
    $array1 = array_slice($array, 0, $halfway);
    $array2 = array_slice($array, $halfway);
    // Recurse to sort the two halves
    tf_usort($array1, $cmp_function);
    tf_usort($array2, $cmp_function);
    // If all of $array1 is <= all of $array2, just append them.
    if (call_user_func($cmp_function, end($array1), $array2[0]) < 1) {
        $array = array_merge($array1, $array2);
        return;
    }
    // Merge the two sorted arrays into a single sorted array
    $array = array();
    $ptr1 = $ptr2 = 0;
    while ($ptr1 < count($array1) && $ptr2 < count($array2)) {
        if (call_user_func($cmp_function, $array1[$ptr1], $array2[$ptr2]) < 1) {
            $array[] = $array1[$ptr1++];
        }
        else {
            $array[] = $array2[$ptr2++];
        }
    }
    // Merge the remainder
    while ($ptr1 < count($array1)) $array[] = $array1[$ptr1++];
    while ($ptr2 < count($array2)) $array[] = $array2[$ptr2++];
    return;
}