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
    $cFields = CRM_Quicksearch_BAO_Setting::getCustomFields();
    $include = &$this->addElement('advmultiselect', 'quicksearch_custom_fields', ts('Custom Fields') . ' ', $cFields, array(
        'size' => 5,
        'style' => 'width:250px',
        'class' => 'advmultiselect',
        )
    );

    $include->setButtonAttributes('add', array('value' => ts('Enable >>')));
    $include->setButtonAttributes('remove', array('value' => ts('<< Disable')));

    //$this->addFormRule(array('CRM_Admin_Form_Setting_Component', 'formRule'), $this);
    parent::buildQuickForm();

    $element = $this->getElement('quicksearch_basic_fields');
    $element->_elements[0]->_flagFrozen = TRUE;
  }

  public function setDefaultValues() {
    parent::setDefaultValues();

    $this->_defaults['quicksearch_basic_fields'] = CRM_Quicksearch_BAO_Setting::getBasicFieldsEnabled();
    $this->_defaults['quicksearch_custom_fields'] = CRM_Quicksearch_BAO_Setting::getCustomFieldsEnabled();
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
    // save quicksearch_custom_fields options, if any one of them is selected
    if (array_key_exists('quicksearch_custom_fields', $params) && count($params['quicksearch_custom_fields']) > 0) {
      civicrm_api3('setting', 'create', array(
        'quicksearch_custom_fields' => CRM_Quicksearch_BAO_Setting::formatCustomFields($params['quicksearch_custom_fields']),
      ));
      unset($params['quicksearch_custom_fields']);
    }
    parent::commonProcess($params);
  }

}
