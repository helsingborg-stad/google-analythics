<?php

namespace GoogleAnalytics;

class Options
{
    public function __construct()
    {
        if (function_exists('acf_add_options_sub_page')) {
            acf_add_options_sub_page(array(
                'page_title'    => __('Google Analytics options', 'content-scheduler'),
                'menu_title'    => __('Google Analytics', 'content-scheduler'),
                'menu_slug'     => 'google-analytics-options',
                'parent_slug'   => 'options-general.php',
                'capability'    => 'manage_options'
            ));
        }
    }
}
