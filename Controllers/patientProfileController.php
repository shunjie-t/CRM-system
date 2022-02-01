<?php
include_once('./Users.php');

class patientProfileController {
    //user table
  private $userId = array();
  private $emailAddress = array();
  private $identityNumber = array();
  private $name = array();
  private $phoneNumber = array();
  private $role = array();
  private $accountStatus = array();

  // patient table
  private $patientId = array();
  private $country = array();
  private $sex = array();
  private $dateOfBirth = array();
  private $emergencyContact = array();
  private $relationship = array();

   public function __construct() {
    $UModel = new Users();
    $data1 = $UModel->getUserByRole('patient');

    foreach($data1 as $a) {
      array_push($this->userId, $a['userId']);
      $this->emailAddress[$a['userId']] = $a['emailAddress'];
      $this->identityNumber[$a['userId']] = $a['identityNumber'];
      $this->name[$a['userId']] = $a['name'];
      $this->phoneNumber[$a['userId']] = $a['phoneNumber'];
      $this->role[$a['userId']] = $a['role'];
      $this->accountStatus[$a['userId']] = $a['accountStatus'];
    }

    $PModel = new Patients();
    $data2 = $PModel->getPatients();

    foreach ($data2 as $a) {
      $this->patientId[$a['userId']] = $a['patientId'];
      $this->country[$a['userId']] = $a['Country'];
      $this->sex[$a['userId']] = $a['Sex'];
      $this->dateOfBirth[$a['userId']] = $a['DOB'];
      $this->emergencyContact[$a['userId']] = $a['Emergency Contact'];
      $this->relationship[$a['userId']] = $a['Relationship'];
    }
  }

  public function getUserId() {
    return $this->userId;
  }

  public function getEmailAddress($uid = null) {
    if(!is_null($uid)) {
      return $this->emailAddress[$uid];
    }

    return $this->emailAddress;
  }

  public function getIdentityNumber($uid = null, $redact = true) {
    if($redact) {
      if(!is_null($uid)) {
        $redactId = substr($this->identityNumber[$uid],0,1).str_repeat('*',4).substr($this->identityNumber[$uid],5,4);
        return $redactId;
      }
      else {
        $result = array();
        foreach ($this->identityNumber as $key => $val) {
          $redactId = substr($val,0,1).str_repeat('*',4).substr($val,5,4);
          $result[$key] = $redactId;
        }
        return $result;
      }
    }
    else {
      if(!is_null($uid)) {
        return $this->identityNumber[$uid];
      }
      return $this->identityNumber;
    }
  }

  public function getName($uid = null) {
    if(!is_null($uid)) {
      return $this->name[$uid];
    }

    return $this->name;
  }

  public function getPhoneNumber($uid = null) {
    if(!is_null($uid)) {
      return $this->phoneNumber[$uid];
    }

    return $this->phoneNumber;
  }
  public function getRole($uid = null) {
    if(!is_null($uid)) {
      return $this->role[$uid];
    }

    return $this->role;
  }

  public function getAccountStatus($uid = null) {
    if(!is_null($uid)) {
      return $this->accountStatus[$uid];
    }

    return $this->accountStatus;
  }

  public function getPatientId($uid = null) {
    if(!is_null($uid)) {
      return $this->patientId[$uid];
    }

    return $this->patientId;
  }

  public function getCountry($uid = null) {
    if(!is_null($uid)) {
      return $this->country[$uid];
    }

    return $this->country;
  }

  public function getSex($uid = null) {
    if(!is_null($uid)) {
      return $this->sex[$uid];
    }

    return $this->sex;
  }

  public function getDateOfBirth($uid = null) {
    if(!is_null($uid)) {
      return $this->dateOfBirth[$uid];
    }

    return $this->dateOfBirth;
  }

  public function getEmergencyContact($uid = null) {
    if(!is_null($uid)) {
      return $this->emergencyContact[$uid];
    }

    return $this->emergencyContact;
  }

  public function getRelationship($uid = null) {
    if(!is_null($uid)) {
      return $this->relationship[$uid];
    }

    return $this->relationship;
  }

  public function search($term) {
    $filter = substr($term, (strpos($term,",") + 1));
    $term = substr($term, 0, strpos($term,","));
    $match = array();
    $result = "";
    $field = ["NRIC/Passport number","Name","Date of birth","Phone number","Email address"];
    $value = [$this->getIdentityNumber(),$this->getName(),$this->getDateOfBirth(),$this->getPhoneNumber(),$this->getEmailAddress()];
    foreach($field as $key1 => $val1) {
      if($filter == $val1 || $filter == "All") {
        foreach($value[$key1] as $key2 => $val2) {
          if(strpos(strtolower($val2), strtolower($term)) !== false && !in_array($key2, $match) && $this->getAccountStatus($key2) == "Activated") {
            array_push($match, $key2);
          }
        }
      }
    }

    if(!empty($match)) {
      foreach($match as $val) {
        $result .= "<tr class='resultItem'>
          <td>" . $val . "</td>
          <td>" . $this->getIdentityNumber($val) . "</td>
          <td>" . $this->getName($val) . "</td>
          <td>" . $this->getDateOfBirth($val) . "</td>
          <td>" . $this->getSex($val) . "</td>
          <td>" . $this->getPhoneNumber($val) . "</td>
          <td>" . $this->getEmailAddress($val) . "</td>
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
