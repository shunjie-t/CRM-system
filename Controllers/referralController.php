<?php
include('./referralModel.php');

class referralController {
  private $referralId = array(); // auto fill
  private $dateCreated = array(); // auto fill
  private $timeCreated = array(); // auto fill
  private $referralDate = array();
  private $doctorRequested = array();
  private $serviceRequested = array();
  private $reason = array();
  private $remark = array();

  private $referrerName = array();
  private $referrerPhoneNumber = array();
  private $referrerSpeciality = array();
  private $referrerEmailAddress = array();
  private $referrerOrganization = array();
  private $referrerAddress = array();
  private $referrerPostalCode = array();

  private $patientId = array();
  private $patientName = array();
  private $patientIdentityNumber = array();
  private $patientDateOfBirth = array();
  private $patientSex = array();
  private $patientNationality = array();
  private $patientPhoneNumber = array();
  private $patientEmailAddress = array();
  private $patientAddress = array();
  private $patientPostalCode = array();
  protected $referralBy;
  protected $date;
  protected $timeseen;
  protected $fromDepartment;
  protected $toDepartment;
  protected $referralType;
  protected $urgency;
  protected $referralTo;
  protected $byID;
  protected $idofReferral;
  protected $doctorName;

  public function __construct() {
   /* $RModel = new referralModel();
    $data = $RModel->getAllReferral();

    array_push($this->referralId, $data['referralId']);
    array_push($this->patientId, $data['patientId']);

    foreach($data as $a) {
      $this->referralDate[$a['referralId']] = $data['referralDate'];
      $this->dateCreated[$a['referralId']] = $data['dateCreated'];
      $this->timeCreated[$a['referralId']] = $data['timeCreated'];
      $this->doctorRequested[$a['referralId']] = $data['doctorRequested'];
      $this->serviceRequested[$a['referralId']] = $data['serviceRequested'];
      $this->reason[$a['referralId']] = $data['reason'];
      $this->remark[$a['referralId']] = $data['remark'];

      $this->referrerName[$a['referralId']] = $data['referrerName'];
      $this->referrerPhoneNumber[$a['referralId']] = $data['referrerPhoneNumber'];
      $this->referrerSpeciality[$a['referralId']] = $data['referrerSpeciality'];
      $this->referrerEmailAddress[$a['referralId']] = $data['referrerEmailAddress'];
      $this->referrerOrganization[$a['referralId']] = $data['referrerOrganization'];
      $this->referrerAddress[$a['referralId']] = $data['referrerAddress'];
      $this->referrerPostalCode[$a['referralId']] = $data['referrerPostalCode'];

      $this->patientName[$a['referralId']] = $data['patientName'];
      $this->patientIdentityNumber[$a['referralId']] = $data['patientIdentityNumber'];
      $this->patientDateOfBirth[$a['referralId']] = $data['patientDateOfBirth'];
      $this->patientSex[$a['referralId']] = $data['patientSex'];
      $this->patientNationality[$a['referralId']] = $data['patientNationality'];
      $this->patientPhoneNumber[$a['referralId']] = $data['patientPhoneNumber'];
      $this->patientEmailAddress[$a['referralId']] = $data['patientEmailAddress'];
      $this->patientAddress[$a['referralId']] = $data['patientAddress'];
      $this->patientPostalCode[$a['referralId']] = $data['patientPostalCode'];
    }*/
  }

  public function getReferralId() {
    return $this->referralId;
  }
  public function getPatientId($rid = null) {
    if(!is_null($rid)) {
      return $this->patientId[$rid];
    }

    return $this->patientId;
  }
  public function getDate($rid = null) {
    if(!is_null($rid)) {
      return $this->date[$rid];
    }

    return $this->date;
  }
  public function getReason($rid = null) {
    if(!is_null($rid)) {
      return $this->reason[$rid];
    }

    return $this->reason;
  }
  public function getServiceRequested($rid = null) {
    if(!is_null($rid)) {
      return $this->serviceRequested[$rid];
    }

    return $this->serviceRequested;
  }
  public function getRemark($rid = null) {
    if(!is_null($rid)) {
      return $this->remark[$rid];
    }

    return $this->remark;
  }


  public function getReferrerName($rid = null) {
    if(!is_null($rid)) {
      return $this->referrerName[$rid];
    }

    return $this->referrerName;
  }
  public function getReferrerPhoneNumber($rid = null) {
    if(!is_null($rid)) {
      return $this->referrerPhoneNumber[$rid];
    }

    return $this->referrerPhoneNumber;
  }
  public function getReferrerSpeciality($rid = null) {
    if(!is_null($rid)) {
      return $this->referrerSpeciality[$rid];
    }

    return $this->referrerSpeciality;
  }
  public function getReferrerEmailAddress($rid = null) {
    if(!is_null($rid)) {
      return $this->referrerEmailAddress[$rid];
    }

    return $this->referrerEmailAddress;
  }
  public function getReferrerOrganization($rid = null) {
    if(!is_null($rid)) {
      return $this->referrerOrganization[$rid];
    }

    return $this->referrerOrganization;
  }
  public function getReferrerAddress($rid = null) {
    if(!is_null($rid)) {
      return $this->referrerAddress[$rid];
    }

    return $this->referrerAddress;
  }
  public function getReferrerPostalCode ($rid = null) {
    if(!is_null($rid)) {
      return $this->referrerPostalCode[$rid];
    }

    return $this->referrerPostalCode;
  }


  public function getPatientName($rid = null) {
    if(!is_null($rid)) {
      return $this->patientName[$rid];
    }

    return $this->patientName;
  }
  public function getPatientIdentityNumber($rid = null) {
    if(!is_null($rid)) {
      return $this->patientIdentityNumber[$rid];
    }

    return $this->patientIdentityNumber;
  }
  public function getPatientDateOfBirth($rid = null) {
    if(!is_null($rid)) {
      return $this->patientDateOfBirth[$rid];
    }

    return $this->patientDateOfBirth;
  }
  public function getPatientSex($rid = null) {
    if(!is_null($rid)) {
      return $this->patientSex[$rid];
    }

    return $this->patientSex;
  }
  public function getPatientNationality($rid = null) {
    if(!is_null($rid)) {
      return $this->patientNationality[$rid];
    }

    return $this->patientNationality;
  }
  public function getPatientPhoneNumber($rid = null) {
    if(!is_null($rid)) {
      return $this->patientPhoneNumber[$rid];
    }

    return $this->patientPhoneNumber;
  }
  public function getPatientEmailAddress($rid = null) {
    if(!is_null($rid)) {
      return $this->patientEmailAddress[$rid];
    }

    return $this->patientEmailAddress;
  }
  public function getPatientAddress($rid = null) {
    if(!is_null($rid)) {
      return $this->patientAddress[$rid];
    }

    return $this->patientAddress;
  }
  public function getPatientPostalCode($rid = null) {
    if(!is_null($rid)) {
      return $this->patientPostalCode[$rid];
    }

    return $this->patientPostalCode;
  }
 public function setReferral($referralBy){
    $referralModel= new referralModel();
    $referralArray = $referralModel->getReferralRecords($referralBy);
  }
  
  public function validateReferral($rid, $byID, $idofReferral, $referralBy, $referralTo, $date, $fromDepartment, $toDepartment, $referralType, $urgency, $patientName)
  {
    $errors = array();
    $referralModel = new referralModel();
  
    if (empty($referralBy)) {
        array_push($errors, "Doctor Name is required");
    } 
    if (empty($date)) {
        array_push($errors, "Date is required");
    } 
    if (empty($fromDepartment)) {
        array_push($errors, "From which department is required");
    } 
    if (empty($toDepartment)) {
        array_push($errors, "To which department is required");
    } 
    if (empty($referralType)) {
        array_push($errors, "Type of Referral is required");
    } 
    if (empty($patientName)) {
        array_push($errors, "Patient Name is required");
    } 

    if (empty($referralTo)) {
      array_push($errors, "Doctor Name is required");
   } 
   
    if (count($errors) > 0) {
        echo "<div style=': red; font-weight: bold;'>";
        foreach ($errors as $error) {
            echo "<label>$error</label><br>";
        }
        echo "</div>";
    }
  
    if(count($errors) == 0)
    {
        $result=$referralModel->newReferral($rid, $byID, $idofReferral, $referralBy, $referralTo,  $date, $fromDepartment, $toDepartment, $referralType, $urgency, $patientName);
    } 
  }

  public function getDoctorName($toDepartment){
            
    $referralModel= new referralModel();
    $referralArray = $referralModel->getDoctorNameModel($toDepartment); 
    
  }
  
  public function getReferredToPatients($doctorName)
  {
    $referredtoPatients = new referralModel();
    $referralArray = $referredtoPatients->getReferredToPatientsModel($doctorName); 
  }

  public function getReferraBy(){
    return $this->referralBy;
  }
  public function getTimeSeen(){
    return $this->timeseen;
  }
  public function getFromDepartment(){
    return $this->fromDepartment;
  }
  public function getToDepartment(){
    return $this->toDepartment;
  }
  public function getReferralType(){
    return $this->referralType;
  }
  public function getUrgency(){
    return $this->urgency;
  }
  public function getReferralTo(){
    return $this->referralTo;
  }
  public function getByID(){
    return $this->byID;
  }
  public function getreferredDoctorName(){
    return $this->doctorName;
  }
}
?>
