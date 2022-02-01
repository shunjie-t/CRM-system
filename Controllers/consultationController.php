<?php
    include("./consultationModel.php");
    //include("consultationModel.php");

    class consultationController{
        protected $referralId = array();
        protected $patientId = array();
        protected $doctorId = array();
        protected $patientName  = array();
        protected $doctorName  = array();
        protected $nric  = array();
        protected $date  = array();
        protected $time  = array();
        protected $diagnosis  = array();
        protected $reason  = array();
        protected $prescription  = array();
        protected $notes  = array();
        protected $serviceRequested = array();
        protected $remark = array();
        protected $consultationId;
		protected $email;
		protected $phone;
		protected $sex;
		protected $emergency;
		protected $relationship;

        public function __construct() {
            $CModel = new consultationModel();
            $data = $CModel->getConsultation();
        
           /* array_push($this->referralId, $data['referralId']);
            array_push($this->patientId, $data['patientId']);
            array_push($this->doctorId, $data['doctorId']);
            $this->patientName[] = $data['patientName'];
            $this->doctorName[] = $data['doctorName'];
            $this->nric[] = $data['nric'];
            $this->time[] = $data['time'];
            $this->diagnosis[] = $data['diagnosis'];
            $this->prescription[] = $data['prescription'];
            $this->notes[] = $data['notes'];
            $this->date[''] = $data['date'];
            $this->reason[] = $data['reason'];
            $this->serviceRequested[] = $data['serviceRequested'];
            $this->remark[] = $data['remark'];*/
          }

        public function setConsultation($nric){
            $consultationModel= new consultationModel();

            $consultationArray = $consultationModel->getConsultationRecords($nric); 
        }

        public function getPatientDetails($nric)
		{
            $userModel = new consultationModel();
            $userArray = $userModel->getPatientDetails($nric);
            $this->patientName = $userArray['Name'];
            $this->nric = $userArray['NRIC'];
           /* $this->patientId = $userArray['patientId'];
            $this->email = $userArray['Email'];
            $this->phone = $userArray['Phone'];
			$this->sex = $userArray['Sex'];
			$this->emergency = $userArray['Emergency Contact'];
			$this->relationship = $userArray['Relationship'];*/
        }

        public function getConsultationDetails($patientName){
            $consultationModel= new consultationModel();

            $patientArray = $consultationModel->getConsultationDetailsModel($patientName); 
            $this->patientId = $patientArray["patientId"];
            $this->patientName = $patientArray["Name"];
            $this->nric = $patientArray["NRIC"];
        }

        public function getPatientID(){
            return $this->patientId;
        }
        public function getPatientName(){
            return $this->patientName;
        }
        public function getDoctorName(){
            return $this->doctorName;
        }
        public function getNRIC(){
            return $this->nric;
        }
        public function getDate(){
            return $this->date;
        }
        public function getTime(){
            return $this->time;
        }
        public function getDiagnosis(){
            return $this->diagnosis;
        }
        public function getReason(){
            return $this->reason;
        }
        public function getPrescription(){
            return $this->prescription;
        }
        public function getNotes(){
            return $this->notes;
        }

        public function validateConsultation($consultationId,  $nric, $patientName, $date, $time, $doctorName, $reason, $diagnosis, $prescription, $notes)
        {
            $errors = array();
            $consultationModel= new consultationModel();


            if (empty($patientName)) {
				array_push($errors, "Patient Name is required");
			} 
			if (empty($date)) {
				array_push($errors, "Date is required");
			} 
			if (empty($time)) {
				array_push($errors, "Time is required");
			} 
            if (empty($nric)) {
				array_push($errors, "Nric of Patient is required");
			} 

            if (empty($doctorName)) {
				array_push($errors, "Doctor Name is required");
			} 
			if (empty($reason)) {
				array_push($errors, "Purpose of Visit is required");
			} 
			if (empty($diagnosis)) {
				array_push($errors, "Diagnosis is required");
			} 
            if (empty($prescription)) {
				array_push($errors, "Prescription is required");
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
				$result=$consultationModel->newConsultation($consultationId, $nric, $patientName, $date, $time, $doctorName, $reason, $diagnosis, $prescription, $notes);
			} 
        
        }
    }
?>