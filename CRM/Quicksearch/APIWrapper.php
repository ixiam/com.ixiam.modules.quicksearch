<?php

class CRM_Quicksearch_APIWrapper implements API_Wrapper {

  public function fromApiInput($apiRequest) {
    $apiRequest['entity'] = 'Contact';
    $apiRequest['action'] = 'getlist';
    $apiRequest['function'] = 'quicksearch_civicrm_api3_contact_getList';

    if (CRM_Core_Config::singleton()->includeWildCardInName) {
      $input = '%' . $apiRequest['params']['name'] . '%';
    }
    else {
      $input = $apiRequest['params']['name'];
    }

    $apiRequest['params']['search_field'] = $apiRequest['params']['field_name'];
    $apiRequest['params']['input'] = array('LIKE' => $input);
    $apiRequest['params']['extra'] = array('sort_name', $apiRequest['params']['field_name']);

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