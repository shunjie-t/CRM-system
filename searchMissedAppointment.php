<?php
  include('Controllers/appointmentController.php');
  $con = new appointmentController();
  $con->setAttributeArray();
  $term = $_POST['term'];
  $patientName = $_POST['patientName'];
  $mode = substr($term, 0, strpos($term, ","));
  $term = substr($term, strpos($term, ",") + 1);
  $result = $con->searchMissedAppointment($term, $mode, $patientName);
  echo json_encode($result);
?>