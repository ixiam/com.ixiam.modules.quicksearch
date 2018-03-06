<?php
/*
 * Settings metadata file
 */
return array(
  'quicksearch_basic_fields' => array(
    'group_name' => 'Quicksearch Preferences',
    'group' => 'quicksearch',
    'name' => 'quicksearch_basic_fields',
    'type' => 'String',
    'quick_form_type' => 'CheckBox',
    'pseudoconstant' => array(
      'callback' => 'CRM_Quicksearch_Form_Setting::getBasicFields',
    ),
    'add' => '4.7',
    'title' => 'Quicksearch Basic Fields',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => "Selected fields will be displayed in back-office autocomplete dropdown search results (Quick Search, etc.). Contact Name is always included.",
    'help_text' => NULL,
  ),
);
