<?php
  include('Controllers/patientProfileController.php');
  $con = new patientProfileController();
  $term = $_POST['term'];
  $result = $con->search($term);
  echo json_encode($result);
?>
