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
    $listEnabled = CRM_Utils_Array::explodePadded(Civi::settings()->get('quicksearch_basic_fields'));
    if(!empty($listEnabled))
      foreach($list as $key => $value){
        $autoSearchFields[$value] = in_array($value, $listEnabled) ? 1 : 0;
      }
    else
      $autoSearchFields['name'] = 1;

    return $autoSearchFields;
  }

}
