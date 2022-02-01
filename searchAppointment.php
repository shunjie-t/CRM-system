<?php
  include('Controllers/appointmentController.php');
  $con = new appointmentController();
  $con->setAttributeArray();
  $term = $_POST['term'];
  $mode = substr($term, 0, strpos($term, ","));
  $term = substr($term, strpos($term, ",") + 1);
  $result = $con->search($term, $mode);
  echo json_encode($result);
?>