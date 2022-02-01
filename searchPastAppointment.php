<?php
  include('Controllers/appointmentController.php');
  $con = new appointmentController();
  $term = $_POST['term'];
  $patientName = $_POST['patientName'];
  $result = $con->searchPastAppointment($term, $patientName);
  echo json_encode($result);
?>
