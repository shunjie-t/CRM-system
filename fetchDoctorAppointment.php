<?php
    session_start();
    require("dbcon.php");
    $json = array();
    $doctorName = $_GET["name"];
    $date = date("Y-m-d");
    $apptValue = $database->getReference("appointments")
                            ->orderByChild('doctorName')
                            ->equalTo($doctorName)
                            ->getValue();
								
								
								
    
    //$apptValue = $database->getReference("appointments")->getValue();
    //$apptValue = $database->getReference("appointments")->orderByChild("doctorName")->equalTo($doctorName)->getValue();
    $data=array();

    //if($apptSnap->hasChildren()){
        foreach($apptValue as $key => $appt){
            $_SESSION['time'] = $appt["startTime"]  . "-" . $appt["endTime"];
            $_SESSION['title'] =  $appt["title"];
            $_SESSION['patientName'] =  $appt["patientName"];
            $_SESSION['startDate'] =  $appt["startDate"];
            $startDate = $_SESSION['startDate'];
            if($startDate >= $date && $appt["appointmentStatus"]=="Ongoing"){
                $id = $appt["patientId"];
                $title = $_SESSION['time'];
                $start = $appt["startDate"];
                $end = $appt["startDate"];
                $data[] = array(                   
                    'id' => $id,
                    'title' => $title,
                    'start' => $start,
                    'end' => $end
                );    
            }
        } 
    //}
    
    echo json_encode($data);
    exit;
?>