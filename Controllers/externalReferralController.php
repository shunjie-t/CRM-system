<?php
include('externalReferralModel.php');
include('Users.php');

class externalReferralController {
  private $referralId = array(); // auto fill
  private $dateCreated = array(); // auto fill
  private $timeCreated = array(); // auto fill
  private $referralDate = array();
  private $doctorId = array(); // auto fill
  private $doctorName = array();
  private $reason = array();

  private $patientId = array(); // auto fill
  private $patientName = array();
  private $patientIdentityNumber = array();
  private $patientDateOfBirth = array();
  private $patientSex = array();
  private $patientPhoneNumber = array();
  private $patientEmailAddress = array();
  private $patientAddress = array();

  private $referrerName = array();
  private $referrerPhoneNumber = array();
  private $referrerEmailAddress = array();
  private $referrerOrganization = array();
  private $referrerAddress = array();

  private $allPatientName = array();
  private $allDoctorName = array();

  private $field = [
    'referralId','dateCreated','timeCreated','referralDate','doctorId','doctorName',
    'reason','patientId','patientName','patientIdentityNumber','patientSex','patientDateOfBirth',
    'patientPhoneNumber','patientEmailAddress','patientAddress','referrerName','referrerPhoneNumber',
    'referrerEmailAddress','referrerOrganization','referrerAddress'
  ];

  public function __construct() {
    $RModel = new externalReferralModel();
    $data = $RModel->getReferral();

    if(!empty($data)) {
      foreach($data as $a) {
        array_push($this->referralId, $a['referralId']);
        $this->dateCreated[$a['referralId']] = $a['dateCreated'];
        $this->timeCreated[$a['referralId']] = $a['timeCreated'];
        $this->referralDate[$a['referralId']] = $a['referralDate'];
        $this->doctorId[$a['referralId']] = $a['doctorId'];
        $this->doctorName[$a['referralId']] = $a['doctorName'];
        $this->reason[$a['referralId']] = $a['reason'];

        $this->patientId[$a['referralId']] = $a['patientId'];
        $this->patientName[$a['referralId']] = $a['patientName'];
        $this->patientIdentityNumber[$a['referralId']] = $a['patientIdentityNumber'];
        $this->patientDateOfBirth[$a['referralId']] = $a['patientDateOfBirth'];
        $this->patientSex[$a['referralId']] = $a['patientSex'];
        $this->patientPhoneNumber[$a['referralId']] = $a['patientPhoneNumber'];
        $this->patientEmailAddress[$a['referralId']] = $a['patientEmailAddress'];
        $this->patientAddress[$a['referralId']] = $a['patientAddress'];

        $this->referrerName[$a['referralId']] = $a['referrerName'];
        $this->referrerPhoneNumber[$a['referralId']] = $a['referrerPhoneNumber'];
        $this->referrerEmailAddress[$a['referralId']] = $a['referrerEmailAddress'];
        $this->referrerOrganization[$a['referralId']] = $a['referrerOrganization'];
        $this->referrerAddress[$a['referralId']] = $a['referrerAddress'];
      }
    }

    $UModel = new Users();
    $data2 = $UModel->getUserByRole('patient');
    foreach($data2 as $key => $val) {
      $this->allPatientName[$val['userId']] = $val['name'];
    }

    $data3 = $UModel->getUserByRole('doctor');
    foreach($data3 as $key => $val) {
      $this->allDoctorName[$val['userId']] = $val['name'];
    }
  }

  public function getReferralId() {
    return $this->referralId;
  }

  public function getReferralDate($rid = null) {
    if(!is_null($rid)) {
      return $this->referralDate[$rid];
    }

    return $this->referralDate;
  }

  public function getDoctorId($rid = null) {
    if(!is_null($rid)) {
      return $this->doctorId[$rid];
    }

    return $this->doctorId;
  }

  public function getDoctorName($rid = null) {
    if(!is_null($rid)) {
      return $this->doctorName[$rid];
    }

    return $this->doctorName;
  }

  public function getReason($rid = null) {
    if(!is_null($rid)) {
      return $this->reason[$rid];
    }

    return $this->reason;
  }

  public function getPatientId($rid = null) {
    if(!is_null($rid)) {
      return $this->patientId[$rid];
    }

    return $this->patientId;
  }

  public function getPatientName($rid = null) {
    if(!is_null($rid)) {
      return $this->patientName[$rid];
    }

    return $this->patientName;
  }

  public function getPatientIdentityNumber($rid = null, $redact = true) {
    if($redact) {
      if(!is_null($rid)) {
        $redactId = substr($this->patientIdentityNumber[$rid],0,1).str_repeat('*',4).substr($this->patientIdentityNumber[$rid],5,4);
        // $temp = substr($this->patientIdentityNumber[$rid],5);
        // $redactId = substr_replace($this->patientIdentityNumber[$rid],"****",1);
        // $redactId = $redactId . $temp;
        return $redactId;
      }
      else {
        $result = array();
        foreach ($this->patientIdentityNumber as $key => $val) {
          $redactId = substr($val,0,1).str_repeat('*',4).substr($val,5,4);
          // $temp = substr($val,5);
          // $redactId = substr_replace($val,"****",1);
          // $redactId = $redactId . $temp;
          $result[$key] = $redactId;
        }
        return $result;
      }
    }
    else {
      if(!is_null($rid)) {
        return $this->patientIdentityNumber[$rid];
      }
      return $this->patientIdentityNumber;
    }
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

  public function getAllPatientName() {
    return $this->allPatientName;
  }

  public function getAllDoctorName() {
    return $this->allDoctorName;
  }

  public function getField() {
    return $this->field;
  }

  public function createReferral($value = array()) {
    $RModel = new externalReferralModel();
    $rid = count($this->referralId) + 1;

    // both doctorId and patientId are the userId from user table.
    $value['doctorId'] = array_search($value['doctorName'], $this->getAllDoctorName());
    $value['patientId'] = array_search($value['patientName'], $this->getAllPatientName());

    $value['referralDate'] = date("Y-m-d", strtotime($value['referralDate']));
    $value['patientDateOfBirth'] = date("Y-m-d", strtotime($value['patientDateOfBirth']));

    $RModel->postReferral($rid,$value);
  }

    public function search($term) {
        $filter = substr($term, (strpos($term,",") + 1));
        $term = substr($term, 0, strpos($term,","));
        $match = array();
        $result = "";
        $field = ["HealthCare organization","Referrer name","Doctor name","Patient name","NRIC/Passport number","External referral date"];
        $value = [$this->getReferrerOrganization(),$this->getReferrerName(),$this->getDoctorName(),$this->getPatientName(),$this->getPatientIdentityNumber(),$this->getReferralDate()];
        foreach($field as $key1 => $val1) {
          if($filter == $val1 || $filter == "All") {
            foreach($value[$key1] as $key2 => $val2) {
              if(strpos(strtolower($val2), strtolower($term)) !== false && !in_array($key2, $match)) {
                array_push($match, $key2);
              }
            }
          }
        }

        if(!empty($match)) {
          foreach($match as $val) {
            $result .= "<tr class='resultItem'>
              <td>" . $val . "</td>
              <td>" . $this->getReferrerOrganization($val) . "</td>
              <td>" . $this->getReferrerName($val) . "</td>
              <td>" . $this->getDoctorName($val) . "</td>
              <td>" . $this->getPatientName($val) . "</td>
              <td>" . $this->getPatientIdentityNumber($val) . "</td>
              <td>" . $this->getReferralDate($val) . "</td>
              <td><a href='?link=" . $val . "' class='btn btn-primary'>view</a></td>
            </tr>";
          }
        }
        else {
          $result .= "<tr>
            <td align='center' colspan='8'>No record found</td>
          </tr>";
        }
    return $result;
  }
}
?>