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
