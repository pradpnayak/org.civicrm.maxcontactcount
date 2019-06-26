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
  $count = CRM_MaxContactCount_Utils::isContactExceededMaxCount($params);
  if (!is_null($count) && $count <= 0) {
    return 1;
  }
  else {
    return 0;
  }
}
