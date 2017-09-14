<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_56c5c4d919d29',
    'title' => __('Google Analytics', 'google-analytics'),
    'fields' => array(
        0 => array(
            'key' => 'field_56c5c4de2d2a6',
            'label' => __('Google Analytics UA', 'google-analytics'),
            'name' => 'google_analytics_ua',
            'type' => 'text',
            'instructions' => __('To activate Google Analytics please insert your Google Analytics UA.<br>Usally a string like this: UA-XXXXX-Y', 'google-analytics'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'readonly' => 0,
            'disabled' => 0,
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'google-analytics-options',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));
}