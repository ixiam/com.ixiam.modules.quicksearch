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
    return TRUE;
  }

}
