<?php
use CRM_Quicksearch_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */
class CRM_Quicksearch_Form_Setting extends CRM_Admin_Form_Setting {

  protected $_settings = array(
    'quicksearch_basic_fields' => CRM_Quicksearch_BAO_Setting::QUICKSEARCH_PREFERENCES_NAME,
    'quicksearch_custom_fields' => CRM_Quicksearch_BAO_Setting::QUICKSEARCH_PREFERENCES_NAME,
  );

  /**
   * Build the form object.
   */
  public function buildQuickForm() {
    parent::buildQuickForm();

    $element = $this->getElement('quicksearch_basic_fields');
    $element->_elements[0]->_flagFrozen = TRUE;
  }

  public function setDefaultValues() {
    parent::setDefaultValues();

    $this->_defaults['quicksearch_basic_fields'] = CRM_Quicksearch_BAO_Setting::getBasicFieldsEnabled();
    //$this->_defaults['enableComponents'] = Civi::settings()->get('enable_components');
    return $this->_defaults;
  }

  /**
   * @return array
   */
  public static function getBasicFields() {
    return CRM_Quicksearch_BAO_Setting::getBasicFields();
  }

  /**
   * Process the form submission.
   */
  public function postProcess() {
    $params = $this->controller->exportValues($this->_name);

    // save quicksearch_basic_fields options
    if (!empty($params['quicksearch_basic_fields'])) {
      Civi::settings()->set('quicksearch_basic_fields', CRM_Utils_Array::implodePadded(array_keys($params['quicksearch_basic_fields'])));
      unset($params['quicksearch_basic_fields']);
    }
    parent::commonProcess($params);
  }
}
