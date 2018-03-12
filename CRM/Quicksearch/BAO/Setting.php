<?php

/**
 * BAO object for quicksearch
 */
class CRM_Quicksearch_BAO_Setting {
  const QUICKSEARCH_PREFERENCES_NAME = 'Quicksearch Preferences';

  /**
   * @return array
   */
  public static function getBasicFields() {
    // options are hardcoded in navigation.js.tpl
    return array(
      ts("Name") => "name",
      ts("Contact ID") => "contact_id",
      ts("External ID") => "external_identifier",
      ts("First Name") => "first_name",
      ts("Last Name") => "last_name",
      ts("Email") => "email",
      ts("Phone") => "phone_numeric",
      ts("Street Address") => "street_address",
      ts("City") => "city",
      ts("Postal Code") => "postal_code",
      ts("Job Title") => "job_title",
    );
  }

  public static function getBasicFieldsEnabled() {
    $list = self::getBasicFields();
    $autoSearchFields = array();

    // by default  all enabled, as hardocoded in navigation.js.tpl
    foreach($list as $key => $value){
      $autoSearchFields[$value] = 1;
    }

    $listEnabled = CRM_Utils_Array::explodePadded(Civi::settings()->get('quicksearch_basic_fields'));
    if(!empty($listEnabled))
      foreach($list as $key => $value){
        $autoSearchFields[$value] = in_array($value, $listEnabled) ? 1 : 0;
      }
    else
      $autoSearchFields['name'] = 1;

    return $autoSearchFields;
  }

  public static function getCustomFields() {
    // List of Custom Fields
    $results = civicrm_api3('CustomField', 'get', array(
      'sequential' => 1,
      'return' => array("id", "label", "name", "custom_group_id.name", "custom_group_id.table_name", "custom_group_id.title"),
      'custom_group_id.extends' => array('IN' => array("Contact", "Individual", "Organization", "Household")),
      'is_searchable' => 1,
      'options' => array('sort' => "custom_group_id.title, label"),
    ));
    foreach($results["values"] as $key => $value){
      $cfields[$value['id']] = $value['custom_group_id.title'] . ' :: ' . $value['label'];
    }

    return $cfields;
  }

}
