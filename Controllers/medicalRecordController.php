<?php
include('./Users.php');
include('./medicalRecordModel.php');
//include('Users.php');
//include('medicalRecordModel.php');

class medicalRecordController {
  // from medicalRecordModel
  private $id;
  private $medicalRecordId = array();
  private $patientId = array();
  private $weight = array();
  private $height = array();
  private $bmi = array();
  private $allergy = array();
  private $bloodPressure = array();
  private $bloodGlucose = array();
  private $cholesterol = array();
  private $immunization = array();
  private $medication = array();
  private $medicalHistory = array();
  private $medicalCondition = array();
  private $patientName;
		protected $sex;
		protected $dob;
		protected $country;
		protected $emergencyContact;
		protected $relationship;
		protected $nric;

    protected $field = [
      'medicalRecordId','patientId','weight','height','bmi','allergy','bloodPressure','bloodGlucose',
      'cholesterol','immunization','medication','medicalHistory','medicalCondition'
    ];
  public function __construct() {
    $MRModel = new MedicalRecordModel();
    $data = $MRModel->getMedicalRecord();

    foreach($data as $a) {
      array_push($this->medicalRecordId, $a['medicalRecordId']);
      $this->patientId[$a['medicalRecordId']] = $a['patientId'];
      $this->weight[$a['medicalRecordId']] = $a['weight']['value'];
      $this->height[$a['medicalRecordId']] = $a['height']['value'];
      $this->bmi[$a['medicalRecordId']] = $a['bmi']['value'];
      $this->allergy[$a['medicalRecordId']] = $a['allergy']['value'];
      $this->bloodPressure[$a['medicalRecordId']] = $a['bloodPressure']['value'];
      $this->bloodGlucose[$a['medicalRecordId']] = $a['bloodGlucose']['value'];
      $this->cholesterol[$a['medicalRecordId']] = $a['cholesterol']['value'];
      $this->immunization[$a['medicalRecordId']] = $a['immunization']['value'];
      $this->medication[$a['medicalRecordId']] = $a['medication']['value'];
      $this->medicalHistory[$a['medicalRecordId']] = $a['medicalHistory']['value'];
      $this->medicalCondition[$a['medicalRecordId']] = $a['medicalCondition']['value'];
    }
  }

  public function getId() {
    return $this->id;
  }

  public function getMedicalRecordId() {
    return $this->medicalRecordId;
  }

  public function getPatientId($mid = null) {
    if(!is_null($mid)) {
      return $this->patientId[$mid];
    }

    return $this->patientId;
  }

  public function getWeight($mid = null) {
    if(!is_null($mid)) {
      return $this->weight[$mid];
    }

    return $this->weight;
  }

  public function getHeight($mid = null) {
    if(!is_null($mid)) {
      return $this->height[$mid];
    }

    return $this->height;
  }

  public function getBmi($mid = null) {
    if(!is_null($mid)) {
      return $this->bmi[$mid];
    }

    return $this->bmi;
  }

  public function getAllergy($mid = null) {
    if(!is_null($mid)) {
      return $this->allergy[$mid];
    }

    return $this->allergy;
  }

  public function getBloodPressure($mid = null) {
    if(!is_null($mid)) {
      return $this->bloodPressure[$mid];
    }

    return $this->bloodPressure;
  }

  public function getBloodGlucose($mid = null) {
    if(!is_null($mid)) {
      return $this->bloodGlucose[$mid];
    }

    return $this->bloodGlucose;
  }

  public function getCholesterol($mid = null) {
    if(!is_null($mid)) {
      return $this->cholesterol[$mid];
    }

    return $this->cholesterol;
  }

  public function getImmunization($mid = null) {
    if(!is_null($mid)) {
      return $this->immunization[$mid];
    }

    return $this->immunization;
  }

  public function getMedication($mid = null) {
    if(!is_null($mid)) {
      return $this->medication[$mid];
    }

    return $this->medication;
  }

  public function getMedicalHistory($mid = null) {
    if(!is_null($mid)) {
      return $this->medicalHistory[$mid];
    }

    return $this->medicalHistory;
  }

  public function getMedicalCondition($mid = null) {
    if(!is_null($mid)) {
      return $this->medicalCondition[$mid];
    }

    return $this->medicalCondition;
  }

  public function getPatientName() {
    return $this->patientName;
  }

  public function getField($forUI = true) {
    if($forUI) {
      $result = array();
      $p1 = "/(\w+)([A-Z])(\w+)([A-Z])(\w+)/";
      $p2 = "/(\w+)([A-Z])(\w+)/";

      foreach($this->field as $key => $val) {
        if(preg_match($p1, $val, $arr)) {
        	array_push($result, ucfirst($arr[1]) . " " . strtolower($arr[2]) . $arr[3] . " " . strtolower($arr[4]) . $arr[5]);
        }
        else if(preg_match($p2, $val, $arr)) {
        	array_push($result, ucfirst($arr[1]) . " " . strtolower($arr[2]) . $arr[3]);
        }
        else {
        	array_push($result, ucfirst($val));
        }
      }
      return $result;
    }

    else {
      return $this->field;
    }
  }

  public function getRecord($mrid) {
    return [
      $this->field[0] => $mrid,
      $this->field[1] => $this->getPatientId($mrid),
      $this->field[2] => $this->getWeight($mrid),
      $this->field[3] => $this->getHeight($mrid),
      $this->field[4] => $this->getBmi($mrid),
      $this->field[5] => $this->getAllergy($mrid),
      $this->field[6] => $this->getBloodPressure($mrid),
      $this->field[7] => $this->getBloodGlucose($mrid),
      $this->field[8] => $this->getCholesterol($mrid),
      $this->field[9] => $this->getImmunization($mrid),
      $this->field[10] => $this->getMedication($mrid),
      $this->field[11] => $this->getMedicalHistory($mrid),
      $this->field[12] => $this->getMedicalCondition($mrid)
    ];
  }

  private function resetAttribute($mrid, $key, $val) {
    // this method updates weight and height attributes of this class in order to caluclate bmi.
    switch($key) {
      case "weight":
        $this->weight[$mrid] = $val;
        break;
      case "height":
        $this->height[$mrid] = $val;
        break;
    }
  }

  public function createMedicalRecord($pid) {
    $MRModel = new MedicalRecordModel();
    $mrid = count($this->medicalRecordId) + 1;
    $pid = (int)$pid;
    $MRModel->postMedicalRecord($mrid,'patientId',$pid);
  }

  public function updateMedicalRecord($mrid,$mid,$oldVal = array(),$newVal = array(),$remark = array()) {
    $MRModel = new MedicalRecordModel();
    $mrid = intval($mrid);
    $mid = intval($mid);

    foreach ($newVal as $k => $v) {
      if($k == "weight") {
        $v = floatval($v);
        $this->resetAttribute($mrid, $k, $v);
        if($this->height[$mrid] != "-") {
          $bmi = $v / (($this->getHeight($mrid) / 100) * ($this->getHeight($mrid) / 100));
          $MRModel->postMedicalRecord($mrid,"bmi",round($bmi,1));
        }
      }
      else if($k == "height") {
        $v = floatval($v);
        $this->resetAttribute($mrid, $k, $v);
        if($this->weight[$mrid] != "-") {
          $bmi = $this->getWeight($mrid) / (($v / 100) * ($v / 100));
          $MRModel->postMedicalRecord($mrid,"bmi",round($bmi,1));
        }
      }
      else if(is_numeric($v)) {
        $v = intval($v);
      }

      $MRModel->postMedicalRecord($mrid,$k,$v);
    }

    foreach ($oldVal as $k => $v) {
      if($v != '-') {
        $MRModel->postMedicalRecordMistake($mrid,$k,$v,$mid,'medical_administrator',$remark[$k]);
      }
    }
  }


  public function setMyRecords($patientId){
    $MRModel = new MedicalRecordModel();
    $data[] = $MRModel->getMyMedicalRecordsModel($patientId);

   foreach($data as $a) {
      /* $this->weight[$a['medicalRecordId']] = $a['weight']['value'];
      $this->height[$a['medicalRecordId']] = $a['height']['value'];
      $this->bmi[$a['medicalRecordId']] = $a['bmi']['value'];
      $this->allergy[$a['medicalRecordId']] = $a['allergy']['value'];
      $this->bloodPressure[$a['medicalRecordId']] = $a['bloodPressure']['value'];
      $this->bloodGlucose[$a['medicalRecordId']] = $a['bloodGlucose']['value'];
      $this->cholesterol[$a['medicalRecordId']] = $a['cholesterol']['value'];
      $this->immunization[$a['medicalRecordId']] = $a['immunization']['value'];
      $this->medication[$a['medicalRecordId']] = $a['medication']['value'];
      $this->medicalHistory[$a['medicalRecordId']] = $a['medicalHistory']['value'];
      $this->medicalCondition[$a['medicalRecordId']] = $a['medicalCondition']['value'];*/
    }
  }
  public function setPatientRecords($fname){
    $patientModel = new Patients();

    $patientArray = $patientModel->getPatientRecords($fname);
    $this->patientId = $patientArray["patientId"];
    $this->fname = $patientArray["Name"];
    $this->nric = $patientArray["NRIC"];
    $this->sex = $patientArray["Sex"];
    $this->dob = $patientArray["DOB"];
    $this->country = $patientArray["Country"];
    $this->email = $patientArray["Email"];
    $this->emergencyContact = $patientArray["Emergency Contact"];
    $this->relationship = $patientArray["Relationship"];
  }

  public function getSex(){
    return $this->sex;
  }
  public function getDOB(){
    return $this->dob;
  }
  public function getCountry(){
    return $this->country;
  }
  public function getEmergencyContact(){
    return $this->emergencyContact;
  }
  public function getRelationship(){
    return $this->relationship;
  }
  public function getNRIC(){
    return $this->nric;
  }

  public function setRecords($id){
    $MRModel = new MedicalRecordModel();
    $data = $MRModel->getMedicalRecordsModel($id); 
  }

  public function setPatientIdRecords($patientId){
    $MRModel = new MedicalRecordModel();
    $data = $MRModel->setPatientIdRecordsModel($patientId); 
  }

  public function setPatientName($patientId)
  {
    $MRModel = new MedicalRecordModel();
    $patientArray = $MRModel->getPatientName($patientId);
    $this->patientName = $patientArray['Name'];
  
  }
}
?>
