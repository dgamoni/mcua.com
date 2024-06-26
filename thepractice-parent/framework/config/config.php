<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');
/*
 * File containing config data
 */
$cfg['restricted_names'] = array('load', 'buffer', 'include', 'get', 'theme', 'ajax', 'optigen', 'optisave', 'interface', 'ext', 'init', 'callbacks', 'input', 'updater', 'import', 'export', 'shortcodes', 'mem');
$cfg['init_classes'] = array('LOAD', 'INPUT', 'MEM', 'BUFFER', 'INCLUDE', 'GET', 'THEME', 'OPTIGEN', 'CALLBACKS', 'OPTISAVE', 'INTERFACE', 'INIT', 'EXT', 'UPDATER', 'AJAX');
$cfg['init_helpers'] = array('GENERAL', 'INTERFACE', 'GET_EMBED', 'GET_IMAGE', 'DB_CONTAINER');
