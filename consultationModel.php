<?php
class consultationModel{
    protected $consultation;

    public function __construct() {
        chdir(__DIR__);
      }
      
      public function getConsultation() {
        require 'dbcon.php';
        $reference = $database->getReference('consultations')->getValue();
    
        return $reference;
      }

    public function getConsultationRecords($nric){
        require 'dbcon.php';
        $consultationValue = $database->getReference('consultation')->orderByChild("nric")->equalTo($nric)->getValue();

        $i = 1;
        if($consultationValue > 0){
            foreach($consultationValue as $key => $row){
                $nric = $row["nric"];
                $maskedNRIC = substr($nric,0,1).str_repeat('*',4).substr($nric,5,4);
                ?>
                <tr>
                    <td><?=$i++;?></td>
                    <td><?=$maskedNRIC;?></td>
                    <td><?=$row["doctorName"];?></td>
                    <td><?=$row["date"];?></td>
                    <td><?=$row["time"];?></td>
                    <td style= word-wrap:break-word;word-break:break-all;><?=$row["reason"];?></td>
                    <td style= word-wrap:break-word;word-break:break-all;><?=$row["diagnosis"];?></td>
                    <td style= word-wrap:break-word;word-break:break-all;><?=$row["prescription"];?></td>
                    <td style= word-wrap:break-word;word-break:break-all;><?=$row["notes"];?></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <?php echo "No Result Found!";?>
            </tr>
            <?php
        }
        
    }

    public function getConsultationDetailsModel($patientName){
        require('dbcon.php');
        $patientValue = $database->getReference("patients")->getValue();
        $patientSnap = $database->getReference("patients")->getSnapshot();

        $cid = $patientSnap->numChildren() + 1;
        if($patientSnap->hasChildren()){
            foreach($patientValue as $key => $patient){
                if($patient["Name"]== $patientName){
                    return $patient;
                }
            }
        }
    }

    public function newConsultation($consultationId, $nric, $patientName,  $date, $time, $doctorName, $reason, $diagnosis, $prescription, $notes)
    {
        require 'dbcon.php';
        $data= [
            
            'consultationId' => $consultationId,
            'patientName' => $patientName,
            'nric' => $nric,
            'date' =>  $date,
            'time' => $time,
            'doctorName' => $doctorName,
            'nric' => $nric,
            'reason' => $reason,
            'diagnosis' => $diagnosis,
            'prescription' => $prescription,
            'notes' => $notes
        ];

        $ref_table = "consultation";
        $postRef = $database->getReference($ref_table)->push($data);


        if($postRef){
            $_SESSION['status'] = "Consultation Created Successfully";
            header("location: myPatient.php");
            exit();
        } else{
            $_SESSION['status'] = "Consultation Not Created";
            header("location: myPatient.php");
            exit();
        }
    }

    public function getPatientDetails($nric)
    {
        require("dbcon.php");
        $reference = "patients/";

        $userValue = $database->getReference($reference)->getValue();
        $userSnap = $database->getReference($reference)->getSnapshot();

        $userId = $userSnap->numChildren() + 1;
        if($userSnap->hasChildren()){
            foreach($userValue as $key => $user){
                if($user["NRIC"] == $nric){
                    return $user;
    
                }
            }
        }
    }
}
?>