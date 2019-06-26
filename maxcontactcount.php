<?php

require_once 'maxcontactcount.civix.php';
use CRM_Maxcontactcount_ExtensionUtil as E;

define(
  'MAX_COUNT_ERROR_MESSAGE_OFFLINE',
  'This contact has already reached the Max Count limit for this event.'
);
define(
  'MAX_COUNT_ERROR_MESSAGE_ONLINE',
  'You have already reached the Max Count limit for this event.'
);

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function maxcontactcount_civicrm_config(&$config) {
  _maxcontactcount_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function maxcontactcount_civicrm_xmlMenu(&$files) {
  _maxcontactcount_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function maxcontactcount_civicrm_install() {
  _maxcontactcount_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function maxcontactcount_civicrm_postInstall() {
  _maxcontactcount_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function maxcontactcount_civicrm_uninstall() {
  _maxcontactcount_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function maxcontactcount_civicrm_enable() {
  _maxcontactcount_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function maxcontactcount_civicrm_disable() {
  _maxcontactcount_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function maxcontactcount_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _maxcontactcount_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function maxcontactcount_civicrm_managed(&$entities) {
  _maxcontactcount_civix_civicrm_managed($entities);
  $entities[] = [
    'module' => 'org.civicrm.maxcontactcount',
    'name' => 'maxcontactcount_cg_event',
    'entity' => 'CustomGroup',
    'update' => 'never',
    'params' => [
      'version' => 3,
      'name' => 'maxcontactcount_cg_event',
      'title' => ts('Other Details'),
      'extends' => 'Event',
      'style' => 'Inline',
      'is_active' => TRUE,
      'is_reserved' => TRUE,
      'is_public' => FALSE,
      'table_name' => 'civicrm_value_maxcontactcount_cg_event',
    ],
  ];
  $entities[] = [
    'module' => 'org.civicrm.maxcontactcount',
    'name' => 'maxcontactcount_cf_event',
    'entity' => 'CustomField',
    'params' => [
      'version' => 3,
      'name' => 'maxcontactcount_cf_event',
      'label' => ts('Max Contact Count'),
      'data_type' => 'Int',
      'html_type' => 'Text',
      'is_active' => TRUE,
      'text_length' => 255,
      'is_searchable' => 0,
      'weight' => 1,
      'option_type' => 0,
      'custom_group_id' => 'maxcontactcount_cg_event',
    ],
  ];
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
function maxcontactcount_civicrm_caseTypes(&$caseTypes) {
  _maxcontactcount_civix_civicrm_caseTypes($caseTypes);
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
function maxcontactcount_civicrm_angularModules(&$angularModules) {
  _maxcontactcount_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function maxcontactcount_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _maxcontactcount_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function maxcontactcount_civicrm_entityTypes(&$entityTypes) {
  _maxcontactcount_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_validateForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_validateForm
 */
function maxcontactcount_civicrm_validateForm(
  $formName,
  &$fields,
  &$files,
  &$form,
  &$errors
) {
  if ('CRM_Event_Form_Participant' == $formName && !$form->getVar('_id')) {
    if (!empty($fields['event_id'])) {
      $contactId = CRM_Utils_Array::value('contact_id', $fields);
      if (empty($contactId)) {
        $contactId = $form->getVar('_contactId');
      }
      if (empty($contactId)) {
        return;
      }
      $params = [
        'event_id' => $fields['event_id'],
        'contact_id' => $contactId,
      ];
      if (CRM_Maxcontactcount_Utils::isContactExceededMaxCount($params)) {
        $errors['_qf_default'] = ts(MAX_COUNT_ERROR_MESSAGE_OFFLINE);
      }
    }
  }
}

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 */
function maxcontactcount_civicrm_preProcess($formName, &$form) {
  if (in_array($formName, [
    'CRM_Event_Form_Registration_Register',
    'CRM_Event_Form_Registration_AdditionalParticipant',
    'CRM_Event_Form_Registration_Confirm'
  ])) {
    $contactId = CRM_Core_Session::getLoggedInContactID();
    if (empty($contactId)) {
      return;
    }
    $params = [
      'event_id' => $form->getVar('_eventId'),
      'contact_id' => $contactId,
    ];
    if (CRM_Maxcontactcount_Utils::isContactExceededMaxCount($params)) {
      CRM_Core_Error::statusBounce(
        ts(MAX_COUNT_ERROR_MESSAGE_ONLINE),
        CRM_Utils_System::url('civicrm/event/info', "reset=1&id={$params['event_id']}",
          FALSE, NULL, FALSE, TRUE
        )
      );
    }
  }
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function maxcontactcount_civicrm_buildForm($formName, &$form) {
  if ('CRM_Event_Form_Participant' == $formName && !$form->getVar('_id')) {
    CRM_Core_Region::instance('page-body')->add([
      'template' => 'CRM/MaxContactCount/Form/Participant.tpl',
    ]);
    if ($form->getVar('_context') == 'standalone') {
      $contactId = NULL;
    }
    else {
      $contactId = $form->getVar('_contactId');
    }
    $form->assign('maxContactId', $contactId);
    $form->assign('errorMessage', ts(MAX_COUNT_ERROR_MESSAGE_OFFLINE));
  }
}
