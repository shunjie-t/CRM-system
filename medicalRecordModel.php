<?php
class MedicalRecordModel {
  private $medicalRecord;
  private $medicalRecordMistake;

  public function __construct() {
    chdir(__DIR__);
  }

  public function getMedicalRecord() {
    require 'dbcon.php';
    $reference = $database->getReference('medicalRecords')->getValue();

    return $reference;
  }

  public function getMedicalRecordsModel($id){
    require 'dbcon.php';
    $medicalRecordValue = $database->getReference('medicalRecords')->getValue();
    $medicalRecordSnap = $database->getReference('medicalRecords')->getSnapshot();

    $rid = $medicalRecordSnap->numChildren() + 1;

    if($medicalRecordSnap->hasChildren()) {
      foreach($medicalRecordValue as $key => $medicalRecord){
        if($key == $id){
          return $medicalRecord;
        }
      }
    }
  }

  public function setPatientIdRecordsModel($patientId){
    require 'dbcon.php';
    $medicalRecordValue = $database->getReference('medicalRecords')->getValue();
    $medicalRecordSnap = $database->getReference('medicalRecords')->getSnapshot();

    $rid = $medicalRecordSnap->numChildren() + 1;

    if($medicalRecordSnap->hasChildren()) {
      foreach($medicalRecordValue as $key => $medicalRecord){
        if($medicalRecord["patientId"] == $patientId){
          return $medicalRecord;
        }
      }
    }
  }

  public function getMyMedicalRecordsModel($patientId){
    require 'dbcon.php';
    $medicalRecordValue = $database->getReference('medicalRecords')->getValue();
    $medicalRecordSnap = $database->getReference('medicalRecords')->getSnapshot();

    if($medicalRecordSnap->hasChildren()) {
      foreach($medicalRecordValue as $key => $medicalRecord){
        if($medicalRecord["patientId"] == $patientId){
          return $medicalRecord;
        }
      }
    }
  }

  public function postMedicalRecord($rid,$key,$val) {
    require('dbcon.php');;
    $reference = $database->getReference('medicalRecords');
    $exist = false;
    date_default_timezone_set('Asia/Singapore');

    if($key == "patientId") {
      $data = [
        'medicalRecordId' => $rid,
        'patientId' => $val,

        'weight' => ['value' => '-',
        'dateCreated' => date('j F Y'),
        'timeCreated' => date('h:i:s A')],

        'height' => ['value' => '-',
        'dateCreated' => date('j F Y'),
        'timeCreated' => date('h:i:s A')],

        'bmi' => ['value' => '-',
        'dateCreated' => date('j F Y'),
        'timeCreated' => date('h:i:s A')],

        'allergy' => ['value' => '-',
        'dateCreated' => date('j F Y'),
        'timeCreated' => date('h:i:s A')],

        'bloodPressure' => ['value' => '-',
        'dateCreated' => date('j F Y'),
        'timeCreated' => date('h:i:s A')],

        'bloodGlucose' => ['value' => '-',
        'dateCreated' => date('j F Y'),
        'timeCreated' => date('h:i:s A')],

        'cholesterol' => ['value' => '-',
        'dateCreated' => date('j F Y'),
        'timeCreated' => date('h:i:s A')],

        'immunization' => ['value' => '-',
        'dateCreated' => date('j F Y'),
        'timeCreated' => date('h:i:s A')],

        'medication' => ['value' => '-',
        'dateCreated' => date('j F Y'),
        'timeCreated' => date('h:i:s A')],

        'medicalHistory' => ['value' => '-',
        'dateCreated' => date('j F Y'),
        'timeCreated' => date('h:i:s A')],

        'medicalCondition' => [
        'value' => '-',
        'dateCreated' => date('j F Y'),
        'timeCreated' => date('h:i:s A')]
        ];
    }
    else {
      $data = [$key => ['value' => $val,
        'dateCreated' => date('j F Y'),
        'timeCreated' => date('h:i:s A')
        ]];
    }

    foreach($reference->getValue() as $k => $v) {
      if($v['medicalRecordId'] == $rid) {
        $reference->getChild($k)->update($data);
        $exist = true;
      }
    }

    if(!$exist) {
      $reference->push($data);
    }
  }

  public function postMedicalRecordMistake($rid,$fl,$vl,$mid,$mnm,$rm) {
    require 'dbcon.php';
    $reference = $database->getReference('medicalRecordMistakes');

    $id = $reference->getSnapshot()->numChildren() + 1;
    date_default_timezone_set('Asia/Singapore');
    $data = [
      'mistakeId' => $id,
      'medicalRecordId' => $rid,
      'field' => $fl,
      'value' => $vl,
      'date' => date('j F Y'),
      'time' => date('h:i:s A'),
      'medicalAdminId' => $mid,
      'medicalAdminName' => $mnm,
      'remark' => $rm
    ];

    $reference->push($data);
  }

  public function getPatientName($patientId)
  {
      require("dbcon.php");
      $reference = "patients/";

      $userValue = $database->getReference($reference)->getValue();
      $userSnap = $database->getReference($reference)->getSnapshot();

      $userId = $userSnap->numChildren() + 1;
      if($userSnap->hasChildren()){
        foreach($userValue as $key => $user){
          if($user["patientId"] == $patientId){
            return $user;
          }
        }
      }
  }
}
?>
