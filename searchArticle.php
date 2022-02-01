<?php
  include('Controllers/articleController.php');
  $con = new articleController();
  $term = $_POST['term'];
  echo $con->search($term);
?>
