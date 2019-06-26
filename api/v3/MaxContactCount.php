<?php

/**
 * Get a EventSessions.
 *
 * @param array $params
 *
 * @return array
 *   Array of retrieved EventSessions property values.
 */
function civicrm_api3_max_contact_count_maxcountexceeded($params) {
  return CRM_Maxcontactcount_Utils::isContactExceededMaxCount($params);
}
