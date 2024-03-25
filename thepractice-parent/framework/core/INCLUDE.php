<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

/**
 * Description of STATIC
 *
 */
class TF_INCLUDE extends TF_TFUSE {

    public $_the_class_name = 'INCLUDE';
    protected $css = array();
    protected $js = array();
    protected $types = array();
    protected $min_url;
    protected $js_enq = array();

    public function __construct() {
        parent::__construct();
    }

    public function __init() {
        $this->min_url = TFUSE_THEME_URI . '/framework/min/index.php?g';
        if (!defined('TF_DISABLE_INCLUDES'))
            $this->buffer->add_filter(array(&$this, 'include_all'));
    }

    public function css($css_name, $type, $placeholder = 'tf_head', $version = '1.0', $condition_ie = '') {
        $to_store = array('name' => $css_name, 'type' => $type, 'placeholder' => $placeholder, 'version' => $version, 'condition_ie' => $condition_ie);
        if (!in_array($to_store, $this->css) && file_exists($this->types[$type] . '/' . $css_name . '.css'))
            $this->css[] = $to_store;
    }

    public function js($js_name, $type, $placeholder = 'tf_head', $priority = 10, $version = '1.0') {
        $to_store = array('name' => $js_name, 'type' => $type, 'placeholder' => $placeholder, 'priority' => $priority, 'version' => $version);
        if (!in_array($to_store, $this->js) && file_exists($this->types[$type] . '/' . $js_name . '.js'))
            $this->js[] = $to_store;
    }

    protected function order_js() {

        function cmp($a, $b) {
            if ($a['priority'] == $b['priority'])
                return 0;
            if ($a['priority'] < $b['priority'])
                return -1;
            return 1;
        }

        tf_usort($this->js, 'cmp');
    }

    public function js_enq($param_name, $param_value) {
        $this->js_enq[$param_name] = $param_value;
    }

    protected function get_js_enq() {
        $out = "\n" . '<script type="text/javascript">';
        $out .= "\n" . 'window.tfuseNameSpace = window.tfuseNameSpace || {};';
        if (count($this->js_enq) > 0) {
            $out .= "\n" . 'tf_script=' . json_encode($this->js_enq) . ';';
        }
        $out .= "\n" . '</script>' . "\n";
        return $out;
    }

    public function type_is_registered($name) {
        return array_key_exists($name, $this->types);
    }

    public function register_type($name, $path) {
        if ($this->type_is_registered($name))
            return;
        if (!file_exists($path))
            die('Register Type: path does not exist.(' . $name . ':' . $path . ')');
        $this->types[$name] = $path;
    }

    public function include_all($buffer) {
        $placeholders_css = $placeholders_js = array();
        $to_out = array();
        $to_file = array();

        $template_directory         = str_replace('\\','/',get_template_directory());
        $template_directory         = str_replace('//','/',$template_directory);
        $template_directory_uri     = get_template_directory_uri();
        $stylesheet_directory       = str_replace('\\','/',get_stylesheet_directory());
        $stylesheet_directory       = str_replace('//','/',$stylesheet_directory);
        $stylesheet_directory_uri   = get_stylesheet_directory_uri();

        #orders js files so that they are included by priorities
        $this->order_js();
        foreach ($this->css as $css) {
            $placeholders_css[$css['placeholder']][] = $css;
        }
        foreach ($this->js as $js) {
            $placeholders_js[$js['placeholder']][] = $js;
        }
        foreach ($placeholders_css as $name => $css_arr) {
            $to_file[$name . '_css'] = array();
            foreach ($css_arr as $css) {
                $path = $this->types[$css['type']] . '/' . $css['name'] . '.css';
                $to_file[$name . '_css'][] = $path;
                if (!isset($to_out[$name]))
                    $to_out[$name] = '';
                $link = '';
                $rel_path = str_replace(array($template_directory,$stylesheet_directory), '', str_replace('\\','/',$path));
                if(file_exists($stylesheet_directory . $rel_path))
                    $link = $stylesheet_directory_uri . $rel_path;
                elseif(file_exists($template_directory . $rel_path))
                    $link = $template_directory_uri . $rel_path;
                if($css['condition_ie'] !== '')
                    $to_out[$name] .= "\n<!--[if ".$css['condition_ie']."]>";
                $to_out[$name] .= "\n".'<link rel="stylesheet"  href="' . $link . '?ver=' . esc_attr($css['version']) . '" type="text/css" media="all" />';
                if($css['condition_ie'] !== '')
                    $to_out[$name] .= "\n<![endif]-->";
            }
        }
        foreach ($placeholders_js as $name => $js_arr) {
            $to_file[$name . '_js'] = array();
            foreach ($js_arr as $js) {
                $path = $this->types[$js['type']] . '/' . $js['name'] . '.js';
                $to_file[$name . '_js'][] = $path;
                if (!isset($to_out[$name]))
                    $to_out[$name] = '';
                $link = '';
                $rel_path = str_replace(array($template_directory,$stylesheet_directory), '', str_replace('\\','/',$path));
                if(file_exists($stylesheet_directory . $rel_path))
                    $link = $stylesheet_directory_uri . $rel_path;
                elseif(file_exists($template_directory . $rel_path))
                    $link = $template_directory_uri . $rel_path;
                $to_out[$name] .= "\n" . '<script type="text/javascript" src="' . $link . '?ver=' . esc_attr($js['version']) . '"></script>';
            }
        }
        if (isset($this->theme->theme_info['disable_minifier']) && $this->theme->theme_info['disable_minifier'] === FALSE && 1==2) {
            $hash = hash('sha256', serialize($to_file));
            $to_out = array();
            file_put_contents(TFUSE_MIN_CACHE . '/' . $hash . '.cache', serialize($to_file));
            foreach ($placeholders_css as $name => $css) {
                $to_out[$name] = '<link rel="stylesheet"  href="' . $this->min_url . '=' . $name . '_css&source=' . $hash . '" type="text/css" media="all" />';
            }
            foreach ($placeholders_js as $name => $js) {
                if (!array_key_exists($name, $to_out))
                    $to_out[$name] = '';
                $to_out[$name].="\n" . '<script type="text/javascript" src="' . $this->min_url . '=' . $name . '_js&source=' . $hash . '"></script>';
            }
        }
        foreach ($to_out as $name => $out) {
            if ($name == 'tf_head') {
                $out = $this->get_js_enq() . $out;
                $buffer = preg_replace('#<\s*/\s*head\s*>#Uis', $out . '</head>', $buffer);
            }
            if ($name == 'tf_footer') {
                $buffer = preg_replace('#<\s*/\s*body*>#Uis', $out . '</body>', $buffer);
            }
        }
        return $buffer;
    }

}
