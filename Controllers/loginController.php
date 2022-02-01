<?php
    include("Users.php");
    class loginController {
		protected $uid;
		protected $pid;
		protected $rid;
		protected $fname;
		protected $nric;
		protected $gender;
		protected $email;
		protected $password;
		protected $confirmPassword;
		protected $dob;
		protected $phone;
		protected $country;
		protected $emergencyContact;
		protected $emergencyName;
		protected $relationship;
		protected $role;
	
		function getUID() {
			return $this->uid;
		}
		function getPID() {
			return $this->pid;
		}
		function getRID() {
			return $this->rid;
		}
		function getName() {
			return $this->fname;
		}
		function getNRIC() {
			return $this->nric;
		}
		function getGender() {
			return $this->gender;
		}
		function getEmail() {
			return $this->email;
		}
		function getPassword() {
			return $this->password;
		}
		function getConfirmPassword() {
			return $this->confirmPassword;
		}
		function getDOB() {
			return $this->dob;
		}
		function getPhone() {
			return $this->phone;
		}
		function getCountry() {
			return $this->country;
		}
		function getEmergencyContact() {
			return $this->emergencyContact;
		}
		function getEmergencyName() {
			return $this->emergencyName;
		}
		function getRelationship() {
			return $this->relationship;
		}
		function getRole() {
			return $this->role;
		}

		function setUID($uid) {
			$this->uid =$uid;
		}
		function setPID($pid) {
			$this->pid =$pid;
		}
		function setRID($rid) {
			$this->rid =$rid;
		}
		function setName($fname) {
			$this->fname =$fname;
		}
		function setNRIC($nric) {
			$this->nric =$nric;
		}
		function setGender($gender) {
			$this->gender =$gender;
		}
		function setEmail($email) {
			$this->email =$email;
		}
		function setPassword($password) {
			$this->password =$password;
		}
		function setConfirmPassword($confirmPassword) {
			$this->confirmPassword =$confirmPassword;
		}
		function setDOB($dob) {
			$this->dob =$dob;
		}
		function setPhone($phone) {
			$this->phone =$phone;
		}
		function setCountry($country) {
			$this->country =$country;
		}
		function setEmergencyContact($emergencyContact) {
			$this->emergencyContact =$emergencyContact;
		}
		function setEmergencyName($emergencyName) {
			$this->emergencyName =$emergencyName;
		}
		function setRelationship($relationship) {
			$this->relationship =$relationship;
		}
		function setRole($role) {
			$this->role =$role;
		}

        //validation for login screen
		public function validateUser($email, $password) {
			$errors = array();
			$item = new Users();
			
			if (empty($email)) {
				array_push($errors, "Email is required");
			} 
			
			if (empty($password)) {
				array_push($errors, "Password is required");
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
				$result=$item->selectUser($email,$password);
			} 
		}

		//validation for register screen
		public function validateRegister($uid, $pid, $rid, $fname,$nric,$gender,$email,$password,$confirmPassword,$dob,$phone,$country,$emergencyContact,$emergencyName,$relationship,$role) {
			$errors = array();
			$item = new Patients();
			
			$passRegex = "/^(?=.*\d)(?=.*[@#\-_$%^&+=ยง!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=ยง!\?]{8,12}$/";
			$phoneRegex="/^(^[689]{1})(\d{7})$/";

			if (empty($fname)) {
				array_push($errors, "Name is required");
			} 
			if (empty($nric)) {
				array_push($errors, "NRIC is required");
			} 
			if (empty($email)) {
				array_push($errors, "Email is required");
			} 
			if (empty($phone)) {
				array_push($errors, "Phone Number is required");
			} elseif(!preg_match($phoneRegex, $phone)) {
				array_push($errors, "Wrong Format for Phone Number");
			}
			if(empty($password)){
				array_push($errors, "Password is required");
			}elseif(!preg_match($passRegex, $password)) {
				array_push($errors, "Password must have at least 1 upper and lower case, 1 special character and a digit.");
			}
			if($password != $confirmPassword){
				array_push($errors, "Password not matched");
			}elseif (empty($password)) {
				array_push($errors, "Password is required");
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
				$result=$item->addPatient($uid, $pid, $rid, $fname,$nric,$gender,$email,$password,$confirmPassword,$dob,$phone,$country,$emergencyContact,$emergencyName,$relationship,$role);
			} 
		}

		//validate for email forget Password
		public function validateEmail($email){
			$errors = array();
			$item = new Users();

			if (empty($email)) {
				array_push($errors, "Email is required");
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
				$item->forgetPassword($email);
			} 
		}
	}
?>