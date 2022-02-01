<?php
class externalReferralModel {
  public function __construct() {
    chdir(__DIR__);
  }

  public function getReferral() {
    require('dbcon.php');
    $reference = $database->getReference('externalReferrals');

    if($reference->getSnapshot()->hasChildren()) {
      return $reference->getValue();
    }
    else {
      return array();
    }
  }

  public function postReferral($rid,$value = array()) {
    require('dbcon.php');
    $reference = $database->getReference('externalReferrals');
    $exist = false;
    date_default_timezone_set("Asia/Singapore");

    $data = [
        'referralId' => $rid,
        'dateCreated' => date("Y-m-d"),
        'timeCreated' => date("h:i:s A"),
        'referralDate' => $value['referralDate'],
        'doctorId' => $value['doctorId'],
        'doctorName' => $value['doctorName'],
        'reason' => $value['reason'],

        'patientId' => $value['patientId'],
        'patientName' => $value['patientName'],
        'patientIdentityNumber' => $value['patientIdentityNumber'],
        'patientDateOfBirth' => $value['patientDateOfBirth'],
        'patientSex' => $value['patientSex'],
        'patientPhoneNumber' => $value['patientPhoneNumber'],
        'patientEmailAddress' => $value['patientEmailAddress'],
        'patientAddress' => $value['patientAddress'],

        'referrerName' => $value['referrerName'],
        'referrerPhoneNumber' => $value['referrerPhoneNumber'],
        'referrerEmailAddress' => $value['referrerEmailAddress'],
        'referrerOrganization' => $value['referrerOrganization'],
        'referrerAddress' => $value['referrerAddress'],
      ];

      $reference->push($data);
  }

  /*public function postReferralMistake($pid) {
    require_once 'dbcon.php';
    $reference = $database->getReference('referralMistake');
  }*/
}

?>
