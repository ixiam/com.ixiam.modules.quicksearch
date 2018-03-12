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
    'title' => 'Basic Fields',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => "Basic fields that are shwon by default in quicksearch",
    'help_text' => NULL,
  ),
);
