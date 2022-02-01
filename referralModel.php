<?php

class referralModel {
  public function __construct() {
    chdir(__DIR__);
  }
  
  public function getReferral() {
    require('dbcon.php');
    $reference = $database->getReference('referral')->getValue();

    return $reference;
  }


  public function postReferral() {
    date_default_timezone_set("Asia/Singapore");
    $data = [
        'medicalRecordId' => $rid,
        'patientId' => $pid,
        ['weight' => $wt,
        'medicalAdminId' => $mid,
        'medicalAdminName' => $mnm,
        'dateCreated' => date("j F Y"),
        'timeCreated' => date("h:i:s A")],
        ['height' => $ht,
        'medicalAdminId' => $mid,
        'medicalAdminName' => $mnm,
        'dateCreated' => date("j F Y"),
        'timeCreated' => date("h:i:s A")],
        ['bmi' => $bi,
        'medicalAdminId' => $mid,
        'medicalAdminName' => $mnm,
        'dateCreated' => date("j F Y"),
        'timeCreated' => date("h:i:s A")],
        ['allergy' => $al,
        'medicalAdminId' => $mid,
        'medicalAdminName' => $mnm,
        'dateCreated' => date("j F Y"),
        'timeCreated' => date("h:i:s A")],
        ['bloodPressure' => $bp,
        'medicalAdminId' => $mid,
        'medicalAdminName' => $mnm,
        'dateCreated' => date("j F Y"),
        'timeCreated' => date("h:i:s A")],
        ['bloodGlucose' => $bg,
        'medicalAdminId' => $mid,
        'medicalAdminName' => $mnm,
        'dateCreated' => date("j F Y"),
        'timeCreated' => date("h:i:s A")],
        ['cholesterol' => $cl,
        'medicalAdminId' => $mid,
        'medicalAdminName' => $mnm,
        'dateCreated' => date("j F Y"),
        'timeCreated' => date("h:i:s A")],
        ['immunization' => $im,
        'medicalAdminId' => $mid,
        'medicalAdminName' => $mnm,
        'dateCreated' => date("j F Y"),
        'timeCreated' => date("h:i:s A")],
        ['medication' => $md,
        'medicalAdminId' => $mid,
        'medicalAdminName' => $mnm,
        'dateCreated' => date("j F Y"),
        'timeCreated' => date("h:i:s A")],
        ['medicalHistory' => $mh,
        'medicalAdminId' => $mid,
        'medicalAdminName' => $mnm,
        'dateCreated' => date("j F Y"),
        'timeCreated' => date("h:i:s A")],
        ['medicalCondition' => $mc,
        'medicalAdminId' => $mid,
        'medicalAdminName' => $mnm,
        'dateCreated' => date("j F Y"),
        'timeCreated' => date("h:i:s A")]
      ];
  }

  public function postReferralMistake($pid) {
    require_once 'dbcon.php';
    $reference = $database->getReference('referralMistake');
  }

  public function getReferralRecords($byID)
    {
        require('dbcon.php');
        $reference = "referral";
        $referralValue = $database->getReference($reference)
                                ->orderByChild("byID")
                                ->equalTo($byID)->getValue();

        $i = 1;
        foreach($referralValue as $key => $row){
            ?>
            <tr>
                <td><?=$i++;?></td>
                <td><?=$row["referralBy"]?></td>
                <td><?=$row["date"]?></td>
                <td><?=$row["fromDepartment"]?></td>
                <td><?=$row["toDepartment"]?></td>
                <td><?=$row["referralType"]?></td>
                <td><?=$row["urgency"]?></td>
                <td><?=$row["patientName"]?></td>
            </tr>
            <?php
        }
     }

     public function newReferral($rid, $byID, $idofReferral, $referralBy, $referralTo, $date, $fromDepartment, $toDepartment, $referralType, $urgency, $patientName)
     {
         require 'dbcon.php';
         $patientKey = $database->getReference("patients")->orderByChild("Name")->equalTo($patientName)->getValue();
         foreach($patientKey as $key => $user){
 
         $patientData = [
            'doctorId' => $idofReferral
         ];
 
         $data = 
         [
             'byID'=> $byID,
             'fromDepartment'=> $fromDepartment,
             'patientName'=>  $patientName,
             'referralBy' => $referralBy,
             'referralId' => $rid,
             'date'  => $date,   
             'toDepartment'=>  $toDepartment,   
             'referralType'=>  $referralType,
             'referralTo'=>  $referralTo,
             'urgency'=>  $urgency
         
         ];
         
         $ref_table = "referral";
         $ref_table1 = "patients/".$key;
         
         $postRef = $database->getReference($ref_table)->push($data);
         $reference1 = $database->getReference($ref_table1)->update($patientData);
         
        }
         /*if($postRef){
              require_once 'includes/vendor/autoload.php';
              require_once 'includes/credential.php';
              //$emailc=filter_var($email,FILTER_SANITIZE_EMAIL);
              $htmlContent = "<html>";
              $htmlContent .= "<head>";
              $htmlContent .= "<title> Referral Of Patient</title>";
              $htmlContent .= "</head>";
              $htmlContent .= "<body>";
              $htmlContent .= "<h2>You have been referred to Dr" . $referralTo . "!</h2>";
              $htmlContent .= "<h5>Below are the following doctor details</h5>";
              $htmlContent .= "<table cellspacing='0' style='border: 2px dashed #FB4314; width: 100%;'>";
              $htmlContent .= "<tr><th>Doctor Name:</th><td> Dr ". $referralTo ." </td></tr>";
              $htmlContent .= "<tr><th>Department:</th><td>". $toDepartment ."</td></tr>";
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
              ->setTo(["hospitalcrmsim@gmail.com" => $pname])
              ->setBody($htmlContent, "text/html")
              ;

              $result = $mailer->send($message);*/
              if($postRef && $reference1){
              
                $_SESSION['status'] = "Referral was Created";
                header("location: viewReferrals.php");
                exit();
                 
       
                 } else{
                    $_SESSION['status'] = "Referral Not Created";
                    header("location: viewReferrals.php");
                    exit();
                }
        }
     

     public function getDoctorNameModel($toDepartment)
		{
			require("dbcon.php");
			$reference = "doctors/";
			$ref = $database->getReference($reference)
							->orderByChild('department')
							->equalTo($toDepartment)
							->getValue();
			$i = 1;
			foreach($ref as $key => $row)
			{
		 	?>
			   <?php echo $row['name']?>
			<?php
      
			}
		}

  public function getReferredToPatientsModel($doctorName)
  {
    require("dbcon.php");
    $reference = "referral/";
    $ref = $database->getReference($reference)
                    ->orderByChild('referralTo')
                    ->equalTo($doctorName)
                    ->getValue();
    $i = 1;
    foreach($ref as $key => $row){
    ?>
      <tr>
        <td><?=$i++;?></td>
        <td><?=$row["referralBy"]?></td>
        <td><?=$row["patientName"]?></td>
        <td><?=$row["referralType"]?></td>
        <td><?=$row["fromDepartment"]?></td>
        <td><?=$row["urgency"]?></td>
      </tr>
    <?php
    }
  }
}

?>
