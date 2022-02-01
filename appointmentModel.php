<?php
    class appointmentModel{
        public function __construct() {
            chdir(__DIR__);
        }

        public function getAppointmentDetails() {
            require 'dbcon.php';
            $ref_table = "appointments/";
            $reference = $database->getReference($ref_table)->getValue();
    
            return $reference;
        }

        public function getAppointment($appointmentId){
            require 'dbcon.php';
            $ref_table = "appointments/";
            $apptValue = $database->getReference($ref_table)->getValue();
            $apptSnap = $database->getReference($ref_table)->getSnapshot();

            if($apptSnap->hasChildren()){
                foreach ($apptValue as $key =>$appt) {
                    if($key == $appointmentId){
                        return $appt;
                    }
                }
            }
        }

        public function displayCurrentAppointmentModel($pname){
            require 'dbcon.php';
            $ref_table = "appointments/";
            $currentDate = date('Y-m-d');
            //$today = strtotime($currentDate);
            //echo $today;
            $apptValue = $database->getReference($ref_table)->orderByChild("patientName")
                                                            ->equalTo($pname)
                                                            ->getValue();
            /*$apptValue = $database->getReference($ref_table)->orderByChild("patientName")
                                                            ->equalTo($pname)
                                                            ->getValue();*/
            $i=1;
            foreach($apptValue as $key => $row){
                if($row["appointmentStatus"] == "Ongoing"){
                    if($row["startDate"] >= $currentDate){
                    ?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td>Dr <?=$row["doctorName"];?></td>
                            <td><?=$row["title"];?></td>
                            <td><?=$row["startDate"];?></td>
                            <td><?=$row["startTime"];?></td>
                            <td><?=$row["bookedDate"];?></td>
                            <td><a href="viewAppointment.php?id=<?=$key;?>" class="btn btn-primary">View</a></td>
                        </tr>
                    <?php
                    }
               }
            }
        }

        public function displayMissedAppointmentModel($pname){
            require 'dbcon.php';
            $ref_table = "appointments/";
            $currentDate = date('Y-m-d');
            //$today = strtotime($currentDate);
            $apptValue = $database->getReference($ref_table)->orderByChild("patientName")
                                                            ->equalTo($pname)
                                                            ->getValue();
            //$apptValue = $database->getReference($ref_table)->orderByChild("appointmentStatus")
                                                            //->equalTo("Missed")
                                                            //->getValue();
            $i=1;
            foreach($apptValue as $key => $row){
                if($row["startDate"] < $currentDate){
                ?>
                    <tr>
                        <td><?=$i++;?></td>
                        <td>Dr <?=$row["doctorName"];?></td>
                        <td><?=$row["title"];?></td>
                        <td><?=$row["startDate"];?></td>
                        <td><?=$row["startTime"];?></td>
                        <td><?=$row["bookedDate"];?></td>
                        <td><a href="viewAppointment.php?id=<?=$key;?>" class="btn btn-primary">View</a></td>
                    </tr>
                <?php
                }
            }
        }

        public function displayPastAppointmentModel($pname){
            require 'dbcon.php';
            $ref_table = "appointments/";
            $apptValue = $database->getReference($ref_table)->orderByChild("patientName")
                                            ->equalTo($pname)
                                            ->getValue();
                                    
            $i=1;
            foreach($apptValue as $key => $row){
                if($row["appointmentStatus"] == "Completed"){
                ?>
                 <input type="hidden" id="appointmentId" name="appointmentId" value="$row['appointmentId']">
                    <tr>
                        <td><?=$i++;?></td>
                        <td><?=$row["patientName"];?></td>
                        <td>Dr <?=$row["doctorName"];?></td>
                        <td><?=$row["title"];?></td>
                        <td><?=$row["startDate"];?></td>
                        <td><?=$row["startTime"];?></td>
                        <td><?=$row["endTime"];?></td>
                        <td><?=$row["bookedDate"];?></td>
                    </tr>
                <?php
                }
            }
        }

        public function addAppointment($email, $aid, $pid, $did, $pname, $dname, $title, $sdate, $stime, $etime, $bdate, $department, $venue, $notes, $isPatient){
            require('dbcon.php');
            $patientKey = $database->getReference("patients")->orderByChild("Name")->equalTo($pname)->getValue();
            foreach($patientKey as $key => $user){
            $patientData =[
                'doctorId' => $did
            ];

            $data = [
                'appointmentId' => $aid,
                'patientId' => $pid,
                'patientName' => $pname,
                'doctorId' => $did,
                'doctorName' => $dname,
                'title' => $title,
                'startDate' => $sdate,
                'startTime' => $stime,
                'endTime' => $etime,
                'bookedDate' => $bdate,
                'department' => $department,
                'venue' => $venue,
                'notes' => $notes,
                'appointmentStatus' => 'Ongoing'
            ];

            $ref_table = "appointments/";
            $ref_table1 = "patients/" .$key;
            $reference1 = $database->getReference($ref_table1)->update($patientData);
            $reference = $database->getReference($ref_table)->push($data);
            }
           /* if($reference){
                require_once 'includes/vendor/autoload.php';
                require_once 'includes/credential.php';
                //$emailc=filter_var($email,FILTER_SANITIZE_EMAIL);
                $htmlContent = "<html>";
                $htmlContent .= "<head>";
                $htmlContent .= "<title>Health Booking Appointment</title>";
                $htmlContent .= "</head>";
                $htmlContent .= "<body>";
                $htmlContent .= "<h2>Thanks for booking appointment with us!</h2>";
                $htmlContent .= "<h5>Below is your booking details:</h5>";
                $htmlContent .= "<table cellspacing='0' style='border: 2px dashed #FB4314; width: 100%;'>";
                $htmlContent .= "<tr><th>Doctor Name:</th><td> Dr ". $dname ." </td></tr>";
                $htmlContent .= "<tr><th>Appointment Date:</th><td> " . $sdate  ."(". $stime .")</td></tr>";
                $htmlContent .= "<tr><th>Department:</th><td>". $department ."</td></tr>";
                $htmlContent .= "<tr><th>Location:</th><td>". $venue ."</td></tr>";
                $htmlContent .= "</table>";
                $htmlContent .= "</body>";
                $htmlContent .= "</html>";
                $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                    ->setUsername(EMAIL)
                    ->setPassword(PASS);

                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $message = (new Swift_Message('Appointment Confirmation'))
                ->setFrom(['hospitalcrmsim@gmail.com' => 'Application Admin'])
                ->setTo($email)
                ->setBody($htmlContent, "text/html")
                ;

                $result = $mailer->send($message);
                if($result){
                    $_SESSION['status'] = "Appointment Created Successfully";
				    if($isPatient) header("location: viewMyAppointment.php");
                    else header("location: appointmentOverview.php");
				    exit();
                } else{
                    $_SESSION['status'] = "Email Not Sent";
				    if($isPatient) header("location: viewMyAppointment.php");
                    else header("location: appointmentOverview.php");
				    exit();
                }  */
           if($reference) {
              $_SESSION['status'] = "Appointment Created Successfully";
              if($isPatient) header("location: viewMyAppointment.php");
              else header("location: appointmentOverview.php");
              exit();
        } else {
              $_SESSION['status'] = "Something Went Wrong";
              if($isPatient) header("location: viewMyAppointment.php");
              else header("location: appointmentOverview.php");
              exit();
            }
        }

        public function cancelPatientAppointmentModel($appointmentId){
            require('dbcon.php');
            $updateData =[
                'appointmentStatus'  => 'Cancelled'
            ];
            $reference = "appointments/" . $appointmentId;
            $postRef = $database->getReference($reference)->update($updateData);
            if($postRef){
                $_SESSION['status'] = "Appointment updated Successfully";header("location: viewMyAppointment.php");
                exit();
            } else{
                $_SESSION['status'] = "Appointment fails to update";
                header("location: viewMyAppointment.php");
                exit();
            }
        }

        public function cancelAppointmentModel($appointmentId, $isPatient){
            require('dbcon.php');
            $updateData =[
                'appointmentStatus'  => 'Cancelled'
            ];
            if($isPatient) {
            $reference = "appointments/" . $appointmentId;
            $postRef = $database->getReference($reference)->update($updateData);
            }
            else {
                $reference = "appointments/";
                $ref = $database->getReference($reference);

                foreach($ref->getValue() as $k => $v) {
                    if($v['appointmentId'] == $appointmentId) {
                        $postRef = $ref->getChild($k)->update($updateData);
                    }
                }
            }
            if($postRef){
                $_SESSION['status'] = "Appointment updated Successfully";
                if($isPatient) header("location: viewMyAppointment.php");
                else header("location: appointmentOverview.php");
                exit();
            } else{
                $_SESSION['status'] = "Appointment fails to update";
                if($isPatient) header("location: viewMyAppointment.php");
                else header("location: appointmentOverview.php");
                exit();
            }
        }

        public function markAppointmentModel($appointmentId, $isPatient) {
            require('dbcon.php');
            $updateData = [
                'appointmentStatus'  => 'Completed'
            ];
            $reference = "appointments/";
            $ref = $database->getReference($reference);
  
            foreach($ref->getValue() as $k => $v) {
              if($v['appointmentId'] == $appointmentId) {
                $postRef = $ref->getChild($k)->update($updateData);
              }
            }
  
            if($postRef){
              $_SESSION['status'] = "Appointment updated Successfully";
              if($isPatient) header("location: home.php");
              else header("location: appointmentOverview.php");
              exit();
            } else{
              $_SESSION['status'] = "Appointment fails to update";
              if($isPatient) header("location: home.php");
              else header("location: appointmentOverview.php");
              exit();
            }
          }

          public function rescheduleAppointmentModel($appointmentId, $sdate, $stime, $etime, $isPatient){
            require('dbcon.php');
            $updateData =[
                'appointmentStatus' => "Ongoing",
                'startDate'  => $sdate,
                'startTime' => $stime,
                'endTime'  => $etime
            ];
            if($isPatient) {
                $reference = "appointments/" . $appointmentId;
                $postRef = $database->getReference($reference)->update($updateData);
              }
              else {
                $reference = "appointments/";
                $postRef = $database->getReference($reference);
  
                foreach($postRef->getValue() as $k => $v) {
                  if($v['appointmentId'] == $appointmentId) {
                    $postRef = $postRef->getChild($k)->update($updateData);
                  }
                }
              }

           /* if($postRef){
                require_once 'includes/vendor/autoload.php';
                require_once 'includes/credential.php';
                //$emailc=filter_var($email,FILTER_SANITIZE_EMAIL);
                $htmlContent = "<html>";
                $htmlContent .= "<head>";
                $htmlContent .= "<title>Reschedule Appointment Confirmation</title>";
                $htmlContent .= "</head>";
                $htmlContent .= "<body>";
                $htmlContent .= "<h2>Thanks for booking appointment with us!</h2>";
                $htmlContent .= "<h5>Below is your updated booking details:</h5>";
                $htmlContent .= "<table cellspacing='0' style='border: 2px dashed #FB4314; width: 100%;'>";
                $htmlContent .= "<tr><th>New Appointment Date:</th><td> " . $sdate  ."(". $stime .")</td></tr>";
                $htmlContent .= "</table>";
                $htmlContent .= "</body>";
                $htmlContent .= "</html>";
                //$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                  //  ->setUsername(EMAIL)
                    //->setPassword(PASS);
                $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                    ->setUsername(EMAIL)
                    ->setPassword(PASS);

                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $message = (new Swift_Message('Appointment Confirmation'))
                ->setFrom(['hospitalcrmsim@gmail.com' => 'Application Admin'])
                ->setTo([$email])
                ->setBody($htmlContent, "text/html")
                ;

                $result = $mailer->send($message);
                if($result){
                    $_SESSION['status'] = "Appointment Rescheduled Successfully";
				    if($isPatient) header("location: viewMyAppointment.php");
                    else header("location: appointmentOverview.php");
				    exit();
                } else{
                    $_SESSION['status'] = "Email Not Sent";
				    if($isPatient) header("location: viewMyAppointment.php");
                    else header("location: appointmentOverview.php");
				    exit();
                }
            }*/
            if($postRef){
				$_SESSION['status'] = "Appointment Rescheduled Successfully";
				if($isPatient) header("location: viewMyAppointment.php");
                else header("location: appointmentOverview.php");
				exit();
			} 
            else{
			    $_SESSION["status"] = "Failure to update appointment";
                if($isPatient) header("location: viewMyAppointment.php");
                else header("location: appointmentOverview.php");
      			exit();
			}
        }
          public function checkTimeSlot($dname, $sdate){
            require 'dbcon.php';
            $apptSnap = $database->getReference("appointments")->orderByChild("doctorName")
                                                                ->equalTo($dname)
                                                                ->getSnapshot();
            $apptValue = $database->getReference("appointments")->orderByChild("startDate")
                                                                ->equalTo($sdate)
                                                                ->getValue();
            if($apptSnap->hasChildren()){
                foreach ($apptValue as $appointment) {
                    if($appointment["startDate"]==$sdate){
                        return $appointment;
                    }
                }
            }
          }

        public function getBillingRecordsModel($search){
            require("dbcon.php");
            try{
                $recordValue = $database->getReference("billing")->orderByChild("title")->equalTo($search)->getValue();
            }catch (Exception $e) {
				echo $e->getMessage();
			}
            
            foreach($recordValue as $key => $record){
                ?>
                    <div class="card">
                        <div class="card-header">
                            <h4><u>Estimated Fees</u></h4>
                        </div>
                        <div class="card-body">
                            <h4><b>Total fees* for</b></h4><br>
                            <h4><b><?=$record["title"];?></b></h4><br><br>
                            <h6><?=$record["description"];?></h6><br><br>
                            <h3>$<?=$record["minAmount"];?>~$<?=$record["maxAmount"];?></h3>
                            <a href="createSpecialistAppointmentOverview.php?department=<?=$record["department"];?>" class="btn btn-primary">View Specialist</a>
                        </div>
                    </div>
                <?php
            }

        }
    }
?>