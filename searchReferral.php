<?php
  include("Controllers/externalReferralController.php");
  $con = new externalReferralController();
  $term = $_POST['term'];
  $result = $con->search($term);
  echo json_encode($result);
?>
