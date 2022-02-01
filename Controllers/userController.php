<?php
	include_once("./Users.php");
		
	class userController{
		//user table
		protected $key;
		protected $token;
		protected $id;
		protected $uid;
		protected $doctorId;
		protected $fname;
		protected $email;
		protected $identityNumber;
		protected $password;
		protected $phone;
		protected $officeNo;
		protected $role;
		protected $accountStatus;
		protected $listDoctorVariable;
		protected $listMedAdminVariable;
		protected $newPassword;
		protected $confirmNewPassword;
		protected $profilePicture;
		//doctor table
		protected $doctorName;
		protected $department;
		protected $venue;
		protected $gender;
		//patient table
		protected $patientId;
		protected $sex;
		protected $emergency;
		protected $relationship;
		protected $dob;
		protected $country;
		protected $emergencyContact;
		protected $nric;
		protected $doctorID;
		protected $referralTo;
		protected $idofReferral;
		protected $searchBy;
		
		protected $allUserId;
		protected $allDoctorId;
		protected $allDoctorName;
		protected $allDepartment;
		protected $allVenue;

		protected $medicalAdminId;

        public function setAttributeArray(){
			$userModel = new Users();
			$data1=$userModel->getUserDetails();

			$this->email = array();
			$this->identityNumber = array();
			$this->fname = array();
			$this->officeNo = array();
			$this->password= array();
			$this->phone = array();
			$this->role = array();
			$this->uid = array();
			$this->accountStatus = array();

			foreach($data1 as $a) {
				array_push($this->uid, $a['userId']);
				$this->email[$a['userId']] = $a['emailAddress'];
				$this->identityNumber[$a['userId']] = $a['identityNumber'];
				$this->fname[$a['userId']] = $a['name'];
				$this->officeNo[$a['userId']] = $a['officeNumber'];
				$this->password[$a['userId']] = $a['password'];
				$this->phone[$a['userId']] = $a['phoneNumber'];
				$this->role[$a['userId']] = $a['role'];
				$this->accountStatus[$a['userId']] = $a['accountStatus'];
			}
			
			$doctorModel = new Doctors();
			$data2 = $doctorModel->getDoctors();
			$this->allUserId = array();
			$this->allDoctorId = array();
			$this->allDoctorName = array();
			$this->allDepartment = array();
			$this->allVenue = array();
  
			foreach($data2 as $a) {
			  array_push($this->allUserId, $a['userId']);
			  $this->allDoctorId[$a['userId']] = $a['doctorId'];
			  $this->allDoctorName[$a['userId']] = $a['name'];
			  $this->allDepartment[$a['userId']] = $a['department'];
			  $this->allVenue[$a['userId']] = $a['venue'];
			}
		}
        
		public function setAttribute($uid){
			$userModel = new Users();

			$userArray = $userModel->getUser($uid);
			$this->uid = $userArray['userId'];
			$this->fname = $userArray['name'];
			$this->email = $userArray['emailAddress'];
			$this->identityNumber=$userArray['identityNumber'];
			$this->password = $userArray['password'];
			$this->phone = $userArray['phoneNumber'];
			$this->officeNo = $userArray['officeNumber'];
			$this->gender = $userArray['gender'];
			$this->role = $userArray['role'];
			$this->department = $userArray['department'];
			$this->venue = $userArray['venue'];
			$this->accountStatus = $userArray['accountStatus'];
			//$identityNumber = substr($identityNumber,0,1).str_repeat('*',4).substr($identityNumber,5,4);
		}

		public function getUserByEmail($email){
			$userModel = new Users();
			$userArray = $userModel->getUserByEmail($email);
			$this->phone = $userArray['phoneNumber'];
		}

		public function setPassword($uid){
			$userModel = new Users();
			$userArray = $userModel->getPasswordModel($uid);
			$this->password = $userArray['password'];
		}

		public function searchDoctorList($listDoctorVariable){
            $userModel = new Users();
			$userArray = $userModel->searchDoctorListModel($listDoctorVariable);
        }

		public function searchMedAdminList($listMedAdminVariable){
            $userModel = new Users();
			$userArray = $userModel->searchMedAdminListModel($listMedAdminVariable);
        }

		public function searchDoctorSpecialty($department){
            $userModel = new Users();
            $userArray =  $userModel->searchDoctorSpecialtyModel($department);
        }

		public function searchDoctorGender($gender){
            $userModel = new Users();
            $userArray =  $userModel->searchDoctorGenderModel($gender);
        }
		public function searchDoctor($listVariable){
            $userModel = new Users();
            $userArray =  $userModel->searchDoctorModel($listVariable);
        }

		public function searchAllDoctor(){
            $userModel = new Users();
            $userArray =  $userModel->searchAllDoctorModel();
        }

		public function searchPatient($listVariable, $searchBy)
		{
			$userModel = new Patients();
            $userArray =  $userModel->searchPatientModel($listVariable, $searchBy);
		}

		public function displaymyPatient($doctorID)
		{
			$userModel = new Patients();
            $userArray =  $userModel->displaymyPatientModel($doctorID);
		}

		public function displayDoctorList()
		{
			$userModel = new Doctors();
			$userArray = $userModel->displayDoctorListModel();
		}

		public function displayDoctorTable(){
            $userModel = new Users();

			$userArray = $userModel->displayDoctorTableModel();
        }

		public function displayMedAdminTable(){
            $userModel = new Users();

			$userArray = $userModel->displayMedAdminTableModel();
        }

		public function getDoctorProfileDetails($fname, $doctorName){
			$userModel = new Users();
			$doctorModel = new Doctors();
			$userArray = $userModel->getProfileDetailsModel($fname);
			$doctorArray = $doctorModel->setDoctorRecordsModel($doctorName);
			$this->uid = $userArray['userId'];
			$this->fname = $userArray['name'];
			$this->identityNumber = $userArray['identityNumber'];
			$this->email = $userArray['emailAddress'];
			$this->phone = $userArray['phoneNumber'];
			$this->officeNo = $userArray['officeNumber'];
			$this->gender = $doctorArray['gender'];
			$this->role = $userArray['role'];
			$this->department = $doctorArray['department'];
			$this->venue = $doctorArray['venue'];
		}
	    public function getProfileDetails($fname){
			$role= $_SESSION["role"];
			$userModel = new Users();
			$userArray = $userModel->getProfileDetailsModel($fname);
			$this->uid = $userArray['userId'];
			$this->fname = $userArray['name'];
			$this->identityNumber = $userArray['identityNumber'];
			$this->email = $userArray['emailAddress'];
			$this->phone = $userArray['phoneNumber'];
			$this->role = $userArray['role'];
			if($role != "patient"){
				$this->officeNo = $userArray['officeNumber'];
			}
		}

		public function getKey()
		{
			return $this->key;
		}
		public function getToken()
		{
			return $this->token;
		}
		public function getPatientID()
		{
			return $this->patientId;
		}
		public function getID()
		{
			return $this->id;
		}
        public function getUserId()
		{
			return $this->uid;
		}
		public function getDoctorId()
		{
			return $this->doctorId;
		}
        public function getFname()
		{
			return $this->fname;
		}
        public function getEmail()
		{
			return $this->email;
		}
		public function getIdentityNumber()
		{
			//$identityNumber = substr($identityNumber,0,1).str_repeat('*',4).substr($identityNumber,5,4);
			return $this->identityNumber;
		}
        public function getPassword()
		{
			return $this->password;
		}
		public function getPhone()
		{
			return $this->phone;
		}
		
		public function getOfficeNo()
		{
			return $this->officeNo;
		}
		public function getGender()
		{
			return $this->gender;
		}
        public function getRole()
		{
			return $this->role;
		}
		public function getAccountStatus()
		{
			return $this->accountStatus;
		}
		public function getNewPassword()
		{
			return $this->newPassword;
		}
		public function getConfirmNewPassword()
		{
			return $this->confrimNewPassword;
		}
		public function getProfilePicture()
		{
			return $this->profilePicture;
		}
		public function getDepartment()
		{
			return $this->department;
		}
		public function getVenue()
		{
			return $this->venue;
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
			return $this->emergency;
		}
		public function getRelationship(){
			return $this->relationship;
		}
		public function setToken($token){
			$this->token = $token;
		}
		public function setUserId($uid){
			$this->uid = $uid;
		}
		public function getDoctorName(){
			return $this->doctorName;
		}
		public function getNRIC(){
			return $this->nric;
		}
		public function getReferralTo()
		{
			return $this->referralTo;	
		}

		public function getIdOfReferral()
		{
  			return $this->idofReferral;
		}
		public function getSearchBy()
		{
  			return $this->searchBy;
		}
		public function getAllUserId() {
            return $this->allUserId;
          }
          public function getAllDoctorId($uid = null) {
            if(!is_null($uid)) {
              return $this->allDoctorId[$uid];
            }
            return $this->allDoctorId;
          }
          public function getAllDoctorName($uid = null) {
            if(!is_null($uid)) {
              return $this->allDoctorName[$uid];
            }
            return $this->allDoctorName;
          }
          public function getAllDepartment($uid = null) {
            if(!is_null($uid)) {
              return $this->allDepartment[$uid];
            }
            return $this->allDepartment;
          }
          public function getAllVenue($uid = null) {
            if(!is_null($uid)) {
              return $this->allVenue[$uid];
            }
            return $this->allVenue;
          }
		

        public function validateUser($uid, $doctorId, $fname, $email, $identityNumber, $phone, $officeNo, $gender, $role, $department, $venue, $password){
            $errors = array();
			
			
			$passRegex = "/^(?=.*\d)(?=.*[@#\-_$%^&+=ยง!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=ยง!\?]{8,12}$/";
			$phoneRegex="/^(^[689]{1})(\d{7})$/";
			$emailRegex="/^[^0-9][_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/";
            
            if (empty($fname)) {
				array_push($errors, "Name is required");
			} 
			if (empty($phone)) {
				array_push($errors, "Phone Number is required");
			} elseif(!preg_match($phoneRegex, $phone)) {
				array_push($errors, "Wrong Format for Phone Number");
			}
			if (empty($email)) {
				array_push($errors, "Email Address is required");
			} elseif(!preg_match($emailRegex, $email)) {
				array_push($errors, "Wrong Format for Email Address.");
			}
			if (empty($identityNumber)) {
				array_push($errors, "Identity Number is required");
			}

            if (count($errors) > 0) {
				echo "<div style='color: red; font-weight: bold;'>";
				foreach ($errors as $error) {
					echo "<label>$error</label><br>";
				}
				echo "</div>";
			}
			
			if(count($errors) == 0)
			{
				if($role == "doctor"){
					$doctor = new Doctors();
					$doctor ->addDoctor($uid, $doctorId, $fname, $email, $identityNumber, $phone, $officeNo, $gender, $role, $department, $venue, $password);		
				} elseif($role == "medical administrator"){
					$medadmin = new MedicalAdministrator();
					$medadmin ->addMedAdmin($uid, $fname, $email, $identityNumber, $phone, $officeNo, $role, $department, $venue, $password);		
				}
                
            }
        }

		//validation for edit profile
		public function validateProfile($role, $id, $uid, $fname, $email, $phone, $officeNo){
			$errors = array();
			$item = new Users();
			
			if (empty($fname)) {
				array_push($errors, "Name is required");
			} 
			if (empty($email)) {
				array_push($errors, "Email is required");
			} 
			if (empty($phone)) {
				array_push($errors, "Contact Number is required");
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
				$item->updateProfile($role, $id, $uid, $fname, $email, $phone, $officeNo);
			} 
		}


		//display patient details using patient id
		public function getPatientDetails($id)
		{
            $userModel = new Patients();
            $userArray = $userModel->getPatientDetailsModel($id);
            $this->patientId = $userArray['patientId'];
            $this->fname = $userArray['Name'];
            $this->email = $userArray['Email'];
            $this->phone = $userArray['Phone'];
            $this->identityNumber = $userArray['NRIC'];
			$this->sex = $userArray['Sex'];
			$this->emergency = $userArray['Emergency Contact'];
			$this->relationship = $userArray['Relationship'];
        }

		//get details from appointments
		public function getAppointmentDetails($id)
		{
            $userModel = new Patients();
            $userArray = $userModel->getAppointmentDetailsModel($id);
            $this->fname = $userArray['patientName'];
        }

		//display patient details using patient name
		public function displaymyPatientName($doctorID)
		{
			$userModel = new Patients();
            $userArray =  $userModel->displayPatientNameModel($doctorID);
		}


		//redirect to deactivate user
		public function deactivateUser($id, $uid, $isMedicalAdmin = false){
			$userModel = new MedicalAdministrator();
			$userArray = $userModel->deactivateUserModel($id, $uid, $isMedicalAdmin);
		}

		public function changePassword($id, $uid, $newPassword, $confirmNewPassword){
			$errors = array();
			$userModel = new Users();
			$passRegex = "/^(?=.*\d)(?=.*[@#\-_$%^&+=ยง!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=ยง!\?]{8,12}$/";
			if (empty($newPassword)) {
				array_push($errors, "Password is required");
			}elseif(!preg_match($passRegex, $newPassword)){
				array_push($errors, "Password must have 1 upper and lowercase, digit and a special characters");
			}

			if(empty($confirmNewPassword)){
				array_push($errors, "Password confirmation is required");
			}elseif($confirmNewPassword != $newPassword){
				array_push($errors, "Password not matched");
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
				$userArray = $userModel->changePasswordModel($id, $uid, $newPassword);
			} 
		}
		//set patient detials from patients
		public function setPatientRecords($fname){
			$patientModel = new Patients();

			$patientArray = $patientModel->getPatientRecords($fname);
		//	$this->key = $patientArray["key"];
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

		//set details from doctor table
		public function setDoctorRecords($doctorName){
			$doctorModel = new Doctors();

			$doctorArray = $doctorModel->setDoctorRecordsModel($doctorName);
			$this->doctorId = $doctorArray["doctorId"];
			$this->department = $doctorArray["department"];
			$this->venue = $doctorArray["venue"];
			$this->officeNo = $doctorArray["officeNumber"];
		}

	//display doctor patient
	public function displayDoctorID($fname)
    {
    	$userModel = new Doctors();
        $userArray =  $userModel->displayDoctorIDModel($fname);
      	$this->doctorId = $userArray['doctorId'];
    }

	public function getReferredDoctorID($fname, $toDepartment)
	{
		$userModel = new Doctors();
        $userArray =  $userModel->getReferredDoctorIDModel($fname,  $toDepartment);
		$this->doctorID = $userArray['doctorId'];
		error_reporting(E_ERROR | E_PARSE);
	}

	public function setAttribute2Array(){
		$DModel = new Doctors();
          $data2 = $DModel->getDoctors();

          $this->allUserId = array();
          $this->allDoctorId = array();
          $this->allDoctorName = array();
          $this->allDepartment = array();
          $this->allVenue = array();

          foreach($data2 as $a) {
            array_push($this->allUserId, $a['userId']);
            $this->allDoctorId[$a['userId']] = $a['doctorId'];
            $this->allDoctorName[$a['userId']] = $a['name'];
            $this->allDepartment[$a['userId']] = $a['department'];
            $this->allVenue[$a['userId']] = $a['venue'];
          }
	}

	public function getDoctorDepartment($doctorID)
	{
		$userModel = new Doctors();
		$userArray = $userModel->getDoctorDepartmentModel($doctorID);
		$this->department = $userArray['department'];
	}

	public function getToDepartmentID($referralTo)
	{
		$userModel = new Doctors();	
		$userArray = $userModel->getToDepartmentModel($referralTo);
		$this->doctorId = $userArray['doctorId'];
	}

	public function getToDoctorNames($department)
	{
		$userModel = new Doctors();	
		$userArray = $userModel->getToDoctorNamesModel($department);
	}

	public function searchUser($term){
		$filter = substr($term, (strpos($term,",") + 1));
		$term = substr($term, 0, strpos($term,","));
		$match = array();
		$field = ["Name", "Email address", "Department", "Venue"];
		$value = [$this->getFname(),$this->getEmail(), $this->getDepartment(),$this->getVenue()];
		
		foreach($field as $key => $val) {
			if($filter == $val || $filter == "All") {
			  foreach($value[$key] as $key => $val) {
				if(strpos(strtolower($val), strtolower($term)) !== false && !in_array($key, $match)) {
				  array_push($match, $key);
				}
			  }
			}
		  }
	  
		  $result = array();
		  foreach($match as $val) {
			$temp = array();
			array_push($temp, $val);
			array_push($temp, $this->getFname($val));
			array_push($temp, $this->getEmail($val));
			array_push($temp, $this->getDepartment($val));
			array_push($temp, $this->getVenue($val));
			array_push($result, $temp);
		  }
	  
		  return $result;
	}
}
?>