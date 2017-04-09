<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'] = function () {
    $instance = &get_instance();

    // Switch language if needed
    if ($instance->input->method(false) === 'get' && in_array($instance->input->get('language'), array('english', 'estonian'))) {
        $instance->session->language = $instance->input->get('language');
    }

    // Load language files
    $instance->lang->load('main', $instance->session->language ? $instance->session->language : 'english');
};