<?php
    include("./appointmentModel.php");
    include_once("./Users.php");

    class appointmentController {
      protected $appointmentId;
      protected $patientId;
      protected $doctorId;
      protected $pname;
      protected $dname;
      protected $title;
      protected $sdate;
      protected $stime;
      protected $etime;
      protected $bdate;
      protected $department;
      protected $wing;
      protected $venue;
      protected $notes;
      protected $appointmentStatus;
      protected $listVariable;
      protected $email;
      protected $search;
      protected $field = ['appointmentId','patientId','doctorId','patientName','doctorName','title','startDate',
      'startTime','endTime','bookedDate','department','venue','notes','appointmentStatus'];

      protected $allUserId;
      protected $allDoctorId;
      protected $allDoctorName;
      protected $allDepartment;
      protected $allVenue;

        public function getappointmentId($pid = null, $did = null) {
            if(!is_null($pid) && !is_null($did)) {
              $pArr = array_keys($this->patientId, $pid);
              $dArr = array_keys($this->doctorId, $did);
              return array_intersect($pArr, $dArr);
            }
            else if(!is_null($pid)) {
              return array_keys($this->patientId, $pid);
            }
            else if(!is_null($did)) {
              return array_keys($this->doctorId, $did);
            }

            return $this->appointmentId;
          }

          public function getPatientId($aid = null){
            if(!is_null($aid)) {
              return $this->patientId[$aid];
            }
              return $this->patientId;
          }
          public function getDoctorId($aid = null){
            if(!is_null($aid)) {
              return $this->doctorId[$aid];
            }
              return $this->doctorId;
          }
          public function getPatientName($aid = null){
            if(!is_null($aid)) {
              return $this->pname[$aid];
            }
              return $this->pname;
          }
          public function getDoctorName($aid = null){
            if(!is_null($aid)) {
              return $this->dname[$aid];
            }
              return $this->dname;
          }
          public function getTitle($aid = null){
            if(!is_null($aid)) {
              return $this->title[$aid];
            }
              return $this->title;
          }
          public function getStartDate($aid = null){
            if(!is_null($aid)) {
              return $this->sdate[$aid];
            }
              return $this->sdate;
          }
          public function getStartTime($aid = null){
            if(!is_null($aid)) {
              return $this->stime[$aid];
            }
              return $this->stime;
          }
          public function getEndTime($aid = null){
            if(!is_null($aid)) {
              return $this->etime[$aid];
            }
              return $this->etime;
          }
          public function getBookedDate($aid = null){
            if(!is_null($aid)) {
              return $this->bdate[$aid];
            }
              return $this->bdate;
          }
          public function getDepartment($aid = null){
            if(!is_null($aid)) {
              return $this->department[$aid];
            }
              return $this->department;
          }
          public function getWing($aid = null){
            if(!is_null($aid)) {
              return $this->wing[$aid];
            }
              return $this->wing;
          }
          public function getVenue($aid = null){
            if(!is_null($aid)) {
              return $this->venue[$aid];
            }
              return $this->venue;
          }
          public function getNotes($aid = null){
            if(!is_null($aid)) {
              return $this->notes[$aid];
            }
              return $this->notes;
          }

          public function getAppointmentStatus($aid = null){
            if(!is_null($aid)) {
              return $this->appointmentStatus[$aid];
            }
              return $this->appointmentStatus;
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

          public function getListVariable(){
            return $this->listVariable;
        }

          public function setID($id){
              $this->id = $id;
          }
          public function setPatientName($pname){
              $this->pname = $pname;
          }
          public function setDoctorName($dname){
              $this->dname = $dname;
          }
          public function setTitle($title){
              $this->title = $title;
          }
          public function setStartDate($sdate){
              $this->sdate = $sdate;
          }
          public function setStartTime($stime){
              $this->stime = $stime;
          }
          public function setEndTime($etime){
              $this->etime = $etime;
          }
          public function setBookedDate($bdate){
              $this->bdate = $bdate;
          }
          public function setDepartment($department){
              $this->department = $department;
          }
          public function setWing($wing){
              $this->wing = $wing;
          }
          public function setVenue($venue){
              $this->venue = $venue;
          }
          public function setNotes($notes){
              $this->notes = $notes;
          }
          public function setAppointmentStatus($appointmentStatus){
            $this->appointmentStatus = $appointmentStatus;
        }
        public function setListVariable($listVariable){
            $this->listVariable = $listVariable;
        }

        public function getTimeslot($date = null, $did = null) {
          $timeslot = array("08:00 am","08:30 am","09:00 am","09:30 am","10:00 am","10:30 am","11:00 am","11:30 am","01:00 pm",
          "01:30 pm","02:00 pm","02:30 pm","03:00 pm","03:30 pm","04:00 pm","04:30 pm","05:00 pm","05:30 pm");

          if(!is_null($date) && !is_null($did)) {
            $date = strtotime($date);
            $date = date('Y-m-d',$date);
            // get appointmentId that match with this date
            $dateArr = array_keys($this->getStartDate(), $date);

            // get appointmentId that match with this doctorId
            $docArr = array_keys($this->getDoctorId(), $did);

            // get appointmentId present in both arrays
            $aidArr = array_intersect($dateArr,$docArr);

            foreach($aidArr as $val) {
              $temp = date('h:i a', strtotime($this->getStartTime($val)));
              $ky = array_search($temp,$timeslot);
              unset($timeslot[$ky]);
            }
          }

          return $timeslot;
        }

        public function setAttributeArray() {
          $AModel = new appointmentModel();
          $data1 = $AModel->getAppointmentDetails();

          $this->appointmentId = array();
          $this->patientId = array();
          $this->doctorId = array();
          $this->pname = array();
          $this->dname = array();
          $this->title = array();
          $this->sdate = array();
          $this->stime = array();
          $this->etime = array();
          $this->bdate = array();
          $this->department = array();
          $this->venue = array();
          $this->notes = array();
          $this->appointmentStatus = array();

          foreach($data1 as $a) {
            array_push($this->appointmentId, $a['appointmentId']);
            $this->patientId[$a['appointmentId']] = $a['patientId'];
            $this->doctorId[$a['appointmentId']] = $a['doctorId'];
            $this->pname[$a['appointmentId']] = $a['patientName'];
            $this->dname[$a['appointmentId']] = $a['doctorName'];
            $this->title[$a['appointmentId']] = $a['title'];
            $this->sdate[$a['appointmentId']] = $a['startDate'];
            $this->stime[$a['appointmentId']] = $a['startTime'];
            $this->etime[$a['appointmentId']] = $a['endTime'];
            $this->bdate[$a['appointmentId']] = $a['bookedDate'];
            $this->department[$a['appointmentId']] = $a['department'];
            $this->venue[$a['appointmentId']] = $a['venue'];
            $this->notes[$a['appointmentId']] = $a['notes'];
            $this->appointmentStatus[$a['appointmentId']] = $a['appointmentStatus'];
          }

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


        public function setAttribute($appointmentId){
            $appointmentModel = new appointmentModel();

            $appointmentArray =  $appointmentModel->getAppointment($appointmentId);
            $this->aid=$appointmentArray['appointmentId'];
            $this->pname=$appointmentArray['patientName'];
            $this->dname=$appointmentArray['doctorName'];
            $this->title=$appointmentArray['title'];
            $this->sdate=$appointmentArray['startDate'];
            $this->stime=$appointmentArray['startTime'];
            $this->etime=$appointmentArray['endTime'];
            $this->bdate=$appointmentArray['bookedDate'];
            $this->department=$appointmentArray['department'];
            $this->venue=$appointmentArray['venue'];
            $this->notes=$appointmentArray['notes'];
            $this->appointmentStatus=$appointmentArray['appointmentStatus'];
        }

        public function displayCurrentAppointment($pname){
            $appointmentModel = new appointmentModel();

            $appointmentArray =  $appointmentModel->displayCurrentAppointmentModel($pname);
        }

        public function displayMissedAppointment($pname){
            $appointmentModel = new appointmentModel();

            $appointmentArray =  $appointmentModel->displayMissedAppointmentModel($pname);
        }

        public function displayPastAppointment($pname){
            $appointmentModel = new appointmentModel();

            $appointmentArray =  $appointmentModel->displayPastAppointmentModel($pname);
        }




        public function validateAppointment($email, $aid, $pid, $did, $pname, $dname, $title, $sdate, $stime, $etime, $bdate, $department, $venue, $notes, $isPatient = true){
            $errors=Array();
            $appointment = new appointmentModel();

            if(empty($title)){
                array_push($errors, "Title is required");
            }
            if(empty($sdate)){
                array_push($errors, "Start Date is required");
            } elseif($sdate < $bdate){
                array_push($errors, "Invalid Date Given");
            }
            if(empty($stime)){
                array_push($errors, "Start Time is required");
            }
            $stime = date("h:ia", strtotime($stime));
            $etime = date("h:ia", strtotime($stime) + (60*30));

            if (count($errors) > 0) {
              echo "<div style='color: red; font-weight: bold;'>";
              foreach ($errors as $error) {
                echo "<label>$error</label><br>";
              }
              echo "</div>";
            }

            if(count($errors) == 0){
              $appointment->addAppointment($email, $aid, $pid, $did, $pname, $dname, $title, $sdate, $stime, $etime, $bdate, $department, $venue, $notes, $isPatient);
            }
        }

        public function cancelAppointment($appointmentId, $isPatient = true){
          $appointmentModel = new appointmentModel();
          $appointmentArray = $appointmentModel->cancelAppointmentModel($appointmentId, $isPatient);
      }
        public function markAppointment($appointmentId, $isPatient = true) {
          $appointmentModel = new appointmentModel();
          $appointmentArray = $appointmentModel->markAppointmentModel($appointmentId, $isPatient);
        }

        public function rescheduleAppointment($appointmentId, $newAppointment, $newApppointmentTime, $etime, $isPatient = true){
          $errors = array();
          $apptModel = new appointmentModel();
          if(empty($newAppointment)){
            array_push($errors, "Required New Appointment Date");
          }
          if(empty($newApppointmentTime)){
            array_push($errors, "Required New Appointment Time");
          }
          if (count($errors) > 0) {
            echo "<div style=': red; font-weight: bold;'>";
            foreach ($errors as $error) {
              echo "<label>$error</label><br>";
            }
            echo "</div>";
          }
          $sdate = date("Y-m-d", strtotime($newAppointment));
          $stime = date("h:ia", strtotime($newApppointmentTime));
          $etime = date("h:ia", strtotime($newApppointmentTime) + (60*30));
          if(count($errors) == 0)
          {
           $apptArray = $apptModel->rescheduleAppointmentModel($appointmentId, $sdate, $stime, $etime, $isPatient);
          }
        }

        public function checkTimeSlot($dname, $sdate){
          $apptModel = new appointmentModel();
          $apptArray = $apptModel->checkTimeSlot($dname, $sdate);
          $this->stime=$apptArray["startTime"];
        }

        public function getBillingRecords($search){
          $errors = array();
          $apptModel = new appointmentModel();

          if(empty($search)){
            array_push($errors, "Require at least one search record");
          }
          if (count($errors) > 0) {
            echo "<div style=': red; font-weight: bold;'>";
            foreach ($errors as $error) {
              echo "<label>$error</label><br>";
            }
            echo "</div>";
          }
          if(count($errors) == 0){
            $apptArray = $apptModel->getBillingRecordsModel($search);
          }
        }

        public function searchPastAppointment($term, $pname){
          $filter = substr($term, (strpos($term,",") + 1));
          $term = substr($term, 0, strpos($term,","));
          $match = array();
          $this->setAttributeArray();
          $field = ["DoctorName", "Title", "AppointmentDate", "AppointmentStartTime", "AppointmentEndTime", "BookedDate"];
          $value = [$this->getDoctorName(), $this->getTitle(), $this->getStartDate(), $this->getStartTime(), $this->getEndTime(), $this->getBookedDate()];

          foreach($field as $key => $val) {
            if($filter == $val || $filter == "All") {
              foreach($value[$key] as $key => $val) {
                if(strpos(strtolower($val), strtolower($term)) !== false && !in_array($key, $match)) {
                  array_push($match, $key);
                }
              }
            }
          }
          $i=1;
          $result = array();
         // if($this->getAppointmentStatus() == "Completed"){
            foreach($match as $val) {
              if($this->getAppointmentStatus($val) == "Completed" && $this->getPatientName($val) == $pname) {
              $temp = array();
              array_push($temp, $i++);
              array_push($temp, $this->getPatientName($val));
              array_push($temp, $this->getDoctorName($val));
              array_push($temp, $this->getTitle($val));
              array_push($temp, $this->getStartDate($val));
              array_push($temp, $this->getStartTime($val));
              array_push($temp, $this->getEndTime($val));
              array_push($temp, $this->getBookedDate($val));
              array_push($result, $temp);
              }
            }
          //}

          return $result;
        }

        public function searchMissedAppointment($term, $mode, $pname){
          $filter = substr($term, (strpos($term,",") + 1));
          $term = substr($term, 0, strpos($term,","));
          $match = array();
          $result = "";
          $field = ["Doctor name","Title","Start date","Start time","End time","Booked date"];
          $value = [$this->getDoctorName(),$this->getTitle(),$this->getStartDate(),$this->getStartTime(),$this->getEndTime(),$this->getBookedDate()];
          foreach($field as $key1 => $val1) {
            if($filter == $val1 || $filter == "All") {
              foreach($value[$key1] as $key2 => $val2) {
                if(strpos(strtolower($val2), strtolower($term)) !== false && !in_array($key2, $match) && $this->getAppointmentStatus($key2) == $mode) {
                  array_push($match, $key2);
                }
              }
            }
          }
          $currentDate= date("Y-m-d");
          $i=1;
          if(!empty($match)){
            foreach($match as $val){
              if($this->getStartDate() < $currentDate && $this->getPatientName() == $pname){
                $result .= "<tr class='missResItem'>
                <td>" . $val . "</td>
                <td>" . $this->getDoctorName($val) . "</td>
                <td>" . $this->getTitle($val) . "</td>
                <td>" . $this->getStartDate($val) . "</td>
                <td>" . $this->getStartTime($val) . "</td>
                <td>" . $this->getEndTime($val) . "</td>
                <td>" . $this->getBookedDate($val) . "</td>
                <td><a href='?link=" . $val . "' class='btn btn-primary'>view</a></td>
              </tr>";
              }
            }
          }
          else {
            $result .= "<tr>
              <td align='center' colspan='9'>No record found</td>
            </tr>";
          }

          return $result;
        }

        public function search($term, $mode) {
          $filter = substr($term, (strpos($term,",") + 1));
          $term = substr($term, 0, strpos($term,","));
          $match = array();
          $result = "";
          $field = ["Patient name","Doctor name","Title","Start date","Start time","End time","Booked date"];
          $value = [$this->getPatientName(),$this->getDoctorName(),$this->getTitle(),$this->getStartDate(),$this->getStartTime(),$this->getEndTime(),$this->getBookedDate()];
          foreach($field as $key1 => $val1) {
            if($filter == $val1 || $filter == "All") {
              foreach($value[$key1] as $key2 => $val2) {
                if(strpos(strtolower($val2), strtolower($term)) !== false && !in_array($key2, $match) && $this->getAppointmentStatus($key2) == $mode) {
                  array_push($match, $key2);
                }
              }
            }
          }

          if(!empty($match)) {
            foreach($match as $val) {
              if($mode == "Completed") {
                $result .= "<tr class='pastResItem'>
                    <td>" . $val . "</td>
                    <td>" . $this->getPatientName($val) . "</td>
                    <td>" . $this->getDoctorName($val) . "</td>
                    <td>" . $this->getTitle($val) . "</td>
                    <td>" . $this->getStartDate($val) . "</td>
                    <td>" . $this->getStartTime($val) . "</td>
                    <td>" . $this->getEndTime($val) . "</td>
                    <td>" . $this->getBookedDate($val) . "</td>
                    <td><a href='?link=" . $val . "' class='btn btn-primary'>view</a></td>
                  </tr>";
              }
              else if($mode == "Missed") {
                $result .= "<tr class='missResItem'>
                    <td>" . $val . "</td>
                    <td>" . $this->getPatientName($val) . "</td>
                    <td>" . $this->getDoctorName($val) . "</td>
                    <td>" . $this->getTitle($val) . "</td>
                    <td>" . $this->getStartDate($val) . "</td>
                    <td>" . $this->getStartTime($val) . "</td>
                    <td>" . $this->getEndTime($val) . "</td>
                    <td>" . $this->getBookedDate($val) . "</td>
                    <td><a href='?link=" . $val . "' class='btn btn-primary'>view</a></td>
                  </tr>";
              }
            }
          }
          else {
            $result .= "<tr>
              <td align='center' colspan='9'>No record found</td>
            </tr>";
          }

          return $result;
        }
    }
?>