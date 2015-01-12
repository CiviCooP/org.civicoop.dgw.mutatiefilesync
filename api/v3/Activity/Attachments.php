<?php

/**
 * Activity.Attachments API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRM/API+Architecture+Standards
 */
function _civicrm_api3_activity_attachments_spec(&$spec) {
  $spec['activity_id']['api.required'] = 1;
}

/**
 * Activity.Attachments API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_activity_attachments($params) {
  if (array_key_exists('activity_id', $params)) {
    $files = CRM_Core_BAO_File::getEntityFile('civicrm_activity', $params['activity_id']);
    foreach($files as $k => $f) {
      $files[$k]['url'] = CRM_Utils_System::url('civicrm/file', "reset=1&id={$f['fileID']}&eid={$f['entityID']}", true);
      $files[$k]['base64_content'] = base64_encode(file_get_contents($f['fullPath']));
      
    }
    return civicrm_api3_create_success($files, $params, 'Activity', 'Attachments');
  } else {
    throw new API_Exception('Activity ID is required');
  }
}

