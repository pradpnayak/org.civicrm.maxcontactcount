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
   * @param int $eventId
   *
   * @return int
   */
  public static function getContactTicketCount($eventId) {
    if (empty($eventId)) {
      return 0;
    }
    if (empty(self::$_contactCount[$eventId])) {
      $cancelledStatusId =  CRM_Core_PseudoConstant::getKey(
        'CRM_Event_BAO_Participant',
        'status_id',
        'Cancelled'
      );
      $query = "
        SELECT COUNT(DISTINCT contact_id) AS contact_count
        FROM civicrm_participant cp
        WHERE cp.event_id = %1
          AND cp.status_id != %2
      ";
      $queryParams = [
        1 => [$eventId, 'Int'],
        2 => [$cancelledStatusId, 'Int'],
      ];
      self::$_contactCount[$eventId] = CRM_Core_DAO::singleValueQuery(
        $query,
        $queryParams
      );
    }
    return self::$_contactCount[$eventId];
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
   * @return void
   */
  public static function isContactExceededMaxCount($params, $additionalParticipantCount = 0) {
    if (empty($params['event_id']) || empty($params['contact_id'])) {
      return;
    }
    $maxCountCustomFieldId = self::getCustomFieldId();
    try {
      $maxCount = civicrm_api3('Event', 'getvalue', [
        'return' => "custom_{$maxCountCustomFieldId}",
        'id' => $params['event_id'],
      ]);
      if (empty($maxCount)) {
        return;
      }
      $pcount = civicrm_api3('Participant', 'getcount', [
        'event_id' => $params['event_id'],
        'contact_id' => $params['contact_id'],
        'status_id' => ['!=' => 'Cancelled'],
      ]);
      if ($pcount) {
        $maxCount += 1;
      }
      $registeredCount = self::getContactTicketCount(
        $params['event_id']
      ) + $additionalParticipantCount;
      return ($maxCount - $registeredCount);
    }
    catch (Exception $e) {
    }
    return;
  }

}
