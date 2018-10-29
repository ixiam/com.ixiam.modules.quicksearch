<?php

class CRM_Quicksearch_APIWrapper implements API_Wrapper {

  public function fromApiInput($apiRequest) {
    $apiRequest['entity'] = 'Contact';
    $apiRequest['action'] = 'getlist';
    $apiRequest['function'] = 'quicksearch_civicrm_api3_contact_getList';

    if (!empty($apiRequest['params']['field_name'])) {
      $fieldName = $apiRequest['params']['field_name'];
    }
    else {
      $fieldName = 'sort_name';
    }
    $operator = 'LIKE';

    // add wildcards
    if (in_array($fieldName, array('contact_id', 'external_identifier'))) {
      $input = $apiRequest['params']['name'];
    }
    else {
      if (CRM_Core_Config::singleton()->includeWildCardInName) {
        $input = '%' . $apiRequest['params']['name'] . '%';
      }
      else {
        $input = $apiRequest['params']['name'];
      }
    }

    // if custom field typeof select, we need to search on option_value label and not in value
    if ($apiRequest['params']['table_name'] == 'custom_table') {
      $customFieldID = CRM_Core_BAO_CustomField::getKeyID($fieldName);
      $customFieldInfo = civicrm_api3('CustomField', 'getsingle', array(
        'return' => array("html_type", "option_group_id"),
        'id' => $customFieldID,
      ));

      if ($customFieldInfo['html_type'] == 'Select') {
        $operator = 'IN';
        $result = civicrm_api3('OptionValue', 'get', array(
          'sequential' => 1,
          'option_group_id' => $customFieldInfo['option_group_id'],
          'label' => array('LIKE' => $input),
        ));

        // hack to get option_value's label in getlist api to display it in results
        $apiRequest['params']['params']['api.OptionValue.getvalue'] = array(
          'option_group_id' => $customFieldInfo['option_group_id'],
          'value' => "\$value.{$fieldName}",
          'return' => "label"
        );
        $apiRequest['params']['html_type'] = 'Select';

        $input = array_column($result['values'], 'value');
      }
    }

    $apiRequest['params']['search_field'] = $fieldName;
    if ($operator === 'LIKE') {
      $apiRequest['params']['input'] = $input;
    }
    else {
      $apiRequest['params']['input'] = array($operator => $input);
    }

    $apiRequest['params']['extra'] = array('sort_name', $fieldName);

    unset($apiRequest['params']['table_name']);
    unset($apiRequest['params']['name']);
    unset($apiRequest['params']['field_name']);

    return $apiRequest;
  }

  /**
   * alter the result before returning it to the caller.
   */
  public function toApiOutput($apiRequest, $result) {
    return $result;
  }

}
