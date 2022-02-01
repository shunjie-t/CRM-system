<?php
    require("dbcon.php");
    $json = array();
    $doctorName=$_GET["doctorName"];
    $date = date("Y-m-d");
    //$apptValue = $database->getReference("appointments")->getValue();
    $apptValue = $database->getReference("appointments")->orderByChild("doctorName")->equalTo($doctorName)->getValue();
    $data=array();

    foreach($apptValue as $key => $appt){
        $startDate = $appt["startDate"];
        if($startDate >= $date && $appt["appointmentStatus"]=="Ongoing"){
            $patientName = $appt["patientName"];
            //$startTime = date("H:i", $appt["startTime"]);
            $title =  $appt["startTime"]."-".$appt["endTime"];
            $start = $appt["startDate"];
            // $start->format("Y-m-d h:ia");
            $end = $appt["startDate"];
            $data[] = array(
                'id' => $patientName,
                'title' => $title,
                'start' => $start,
                'end' => $end
            );    
        }
    } 
    
    echo json_encode($data);
    exit;
?>