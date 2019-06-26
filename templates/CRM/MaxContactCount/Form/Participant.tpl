{literal}
<script type="text/javascript">
  CRM.$(function($) {

    getParticipantMaxCountDetails();
    $('#event_id').change(getParticipantMaxCountDetails);
    $('#contact_id').change(getParticipantMaxCountDetails);

    function checkIfMaxCountExceeded($eventId, $contactId) {
      CRM.api3('MaxContactCount', 'maxcountexceeded', {
        "contact_id": $contactId,
        "event_id": $eventId,
      }).then(function($result) {
        if ($result.result) {
          CRM.alert(
            ts('This contact has already reached the Max Count limit for this event.')
          );
        }
      }, function(error) {
        // ignore
      });
    }

    function getParticipantMaxCountDetails() {
      let $eventId = $('#event_id').val();
      {/literal}
        {if $maxContactId}
          let $contactId = {$maxContactId};
        {else}
          let $contactId = $('#contact_id').val();
        {/if}
      {literal}

      if ($eventId && $contactId) {
        checkIfMaxCountExceeded($eventId, $contactId);
      }
    }
  });
</script>
{/literal}
