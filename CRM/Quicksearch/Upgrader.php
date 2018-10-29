<?php

use CRM_Quicksearch_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Quicksearch_Upgrader extends CRM_Quicksearch_Upgrader_Base {

  /**
   * Install extension
   */
  public function install() {
    $domainId = CRM_Core_Config::domainID();
    $result = civicrm_api3('Navigation', 'get', [
      'sequential' => 1,
      'label' => "Quicksearch Settings",
      'options' => ['limit' => 1],
    ]);
    if ($result['count'] < 1) {
      civicrm_api3('Navigation', 'create', array(
        'sequential' => 1,
        'domain_id' => $domainId,
        'url' => "civicrm/admin/quicksearch",
        'permission' => "administer CiviCRM",
        'label' => "Quicksearch Settings",
        'permission_operator' => "OR",
        'has_separator' => 0,
        'is_active' => 1,
        'parent_id' => "Customize Data and Screens",
      ));
      CRM_Core_Invoke::rebuildMenuAndCaches(TRUE);
    }

    // Prepopulate the default values
    $defaults = array(
      'name' => 1,
      'contact_id' => 1,
      'external_identifier' => 1,
      'first_name' => 1,
      'last_name' => 1,
      'email' => 1,
      'phone_numeric' => 1,
      'street_address' => 1,
      'city' => 1,
      'postal_code' => 1,
      'job_title' => 1
    );
    Civi::settings()->set('quicksearch_basic_fields', CRM_Utils_Array::implodePadded(array_keys($defaults)));
    return TRUE;
  }

}
