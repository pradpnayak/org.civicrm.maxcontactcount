<?php

class CRM_MaxContactCount_Utils {

  /**
   * Holds contact ticket count.
   *
   */
  public static $_contactCount = [];

  /**
   * Holds Max count custom field id.
   *
   */
  public static $_maxCountCustomFieldId = NULL;

  /**
   * Get number of paticipant registered for contact in a event.
   *
   * @param int $contactId
   * @param int $eventId
   *
   * @return int
   */
  public static function getContactTicketCount($contactId, $eventId) {
    if (empty($contactId) || empty($eventId)) {
      return 0;
    }
    $cache = "{$contactId}_{$eventId}";
    if (empty(self::$_contactCount[$cache])) {
      // FIXME: Status check
      $query = "
        SELECT sum(contact_count) as contact_count
        FROM (
          SELECT 1 AS dontcare, COUNT(contact_id) AS contact_count
            FROM civicrm_participant cp
            WHERE cp.contact_id = %1 AND cp.event_id = %2
          UNION
          SELECT 2, COUNT(cp.id)
            FROM civicrm_participant cp
              INNER JOIN civicrm_participant cp1
                ON cp1.id = cp.registered_by_id
              INNER JOIN civicrm_contact cc
                ON cc.id = cp1.contact_id
            WHERE cc.id = %1 AND cp.event_id = %2
        ) AS temp
      ";
      $queryParams = [
        1 => [$contactId, 'Int'],
        2 => [$eventId, 'Int'],
      ];
      self::$_contactCount[$cache] = CRM_Core_DAO::singleValueQuery(
        $query,
        $queryParams
      );
    }
    return self::$_contactCount[$cache];
  }

  /**
   * Get Max count custom field id.
   *
   * @return int
   */
  public static function getCustomFieldId() {
    if (empty(self::$_maxCountCustomFieldId)) {
      self::$_maxCountCustomFieldId = civicrm_api3('CustomField', 'getvalue', [
        'return' => 'id',
        'custom_group_id' => 'maxcontactcount_cg_event',
        'name' => 'maxcontactcount_cf_event',
      ]);
    }
    return self::$_maxCountCustomFieldId;
  }

  /**
   * Check if contact has exceeded max count for event.
   *
   * @param array $params
   * @param int $additionalParticipantCount
   *
   * @return int|bool
   */
  public static function isContactExceededMaxCount($params, $additionalParticipantCount = 0) {
    if (empty($params['event_id']) || empty($params['contact_id'])) {
      return 0;
    }
    $maxCountCustomFieldId = self::getCustomFieldId();
    try {
      $maxCount = civicrm_api3('Event', 'getvalue', [
        'return' => "custom_{$maxCountCustomFieldId}",
        'id' => $params['event_id'],
      ]);
      $registeredCount = self::getContactTicketCount(
        $params['contact_id'],
        $params['event_id']
      ) + $additionalParticipantCount;
      if ($registeredCount >= $maxCount) {
        return TRUE;
      }
    }
    catch (Exception $e) {
    }
    return 0;
  }

}
