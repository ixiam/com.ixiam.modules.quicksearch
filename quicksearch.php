<?php

require_once 'quicksearch.civix.php';

use CRM_Quicksearch_ExtensionUtil as E;

/**
 * Implements hook_civicrm_post().
 */
function quicksearch_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  if (($objectName == 'CustomField') && ($op == 'edit')) {
    // update custom field label in settings, just in case it changed
    $customFieldsEnabled = CRM_Quicksearch_BAO_Setting::getCustomFieldsEnabled();
    if (in_array($objectId, $customFieldsEnabled)) {
      $customFields = Civi::settings()->get('quicksearch_custom_fields');
      $customFields[$objectId] = $objectRef->label;
      civicrm_api3('setting', 'create', array(
        'quicksearch_custom_fields' => $customFields,
      ));
    }
  }
}

/**
 * Implements hook_civicrm_coreResourceList().
 */
function quicksearch_civicrm_coreResourceList(&$items, $region) {
  if ($region == 'html-header') {
    $basicFieldsEnabled = CRM_Utils_Array::explodePadded(Civi::settings()->get('quicksearch_basic_fields'));
    $customFieldsEnabled = CRM_Utils_Array::explodePadded(Civi::settings()->get('quicksearch_custom_fields'));

    CRM_Core_Resources::singleton()->addVars('quicksearch', array('basicFieldsEnabled' => $basicFieldsEnabled));
    CRM_Core_Resources::singleton()->addVars('quicksearch', array('customFieldsEnabled' => $customFieldsEnabled));
    CRM_Core_Resources::singleton()->addScriptFile('com.ixiam.modules.quicksearch', 'js/quicksearch.js');
  }
}

/**
 * Implements hook_civicrm_apiWrappers
 */
function quicksearch_civicrm_apiWrappers(&$wrappers, $apiRequest) {
  if ($apiRequest['entity'] == 'Contact' && $apiRequest['action'] == 'getquick') {
    $basicFields = array_values(CRM_Quicksearch_BAO_Setting::getBasicFields());
    $fieldName = $apiRequest['params']['field_name'];

    // if quicksearch is not by basic fields, or empty (name/email), use own api function
    if (!empty($fieldName) && !in_array($fieldName, $basicFields)) {
      $wrappers[] = new CRM_Quicksearch_APIWrapper();
    }
  }
}

// Reference took from SE question: https://civicrm.stackexchange.com/questions/4011/is-there-a-recommended-way-to-customise-the-quicksearch
// we recreate civicrm_api3_contact_getlist, because getquick has been deprecated but still in use
function quicksearch_civicrm_api3_contact_getList($params) {
  // not loaded by default
  include_once "api/v3/Generic/Getlist.php";
  include_once "api/v3/utils.php";

  $apiRequest = array(
    'entity' => 'Contact',
    'action' => 'getlist',
    'params' => $params,
  );
  $res = civicrm_api3_generic_getList($apiRequest);

  // reformat the output to look like getquick
  $field_name = $apiRequest['params']['search_field'];
  foreach ($res['values'] as $idx => $value) {
    $res['values'][$idx]['data'] = $value['extra']['sort_name'];
    if (!preg_match('/(first|last|sort)_name$/', $field_name)) {
      if ($params['html_type'] == 'Select')
        $res['values'][$idx]['data'] .= " :: " . $value['api.OptionValue.getvalue'];
      else
        $res['values'][$idx]['data'] .= " :: " . $value['extra'][$field_name];
    }
  }

  return $res;
}

function quicksearch_civicrm_navigationMenu(&$menu) {
  $path = "Administer/Customize Data and Screens";
  _quicksearch_civix_insert_navigation_menu($menu, $path, array(
    'label' => ts('Quicksearch Settings', array('com.ixiam.modules.quicksearch')),
    'name' => 'Quicksearch Settings',
    'url' => 'civicrm/admin/quicksearch',
    'permission' => 'administer CiviCRM',
    'operator' => '',
    'separator' => '0'
  ));
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function quicksearch_civicrm_config(&$config) {
  _quicksearch_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function quicksearch_civicrm_xmlMenu(&$files) {
  _quicksearch_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function quicksearch_civicrm_install() {
  _quicksearch_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function quicksearch_civicrm_postInstall() {
  _quicksearch_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function quicksearch_civicrm_uninstall() {
  _quicksearch_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function quicksearch_civicrm_enable() {
  _quicksearch_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function quicksearch_civicrm_disable() {
  _quicksearch_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function quicksearch_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _quicksearch_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function quicksearch_civicrm_managed(&$entities) {
  _quicksearch_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function quicksearch_civicrm_caseTypes(&$caseTypes) {
  _quicksearch_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function quicksearch_civicrm_angularModules(&$angularModules) {
  _quicksearch_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function quicksearch_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _quicksearch_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function quicksearch_civicrm_entityTypes(&$entityTypes) {
  _quicksearch_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function quicksearch_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function quicksearch_civicrm_navigationMenu(&$menu) {
  _quicksearch_civix_insert_navigation_menu($menu, NULL, array(
    'label' => E::ts('The Page'),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _quicksearch_civix_navigationMenu($menu);
} // */
