<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CRM System</title>
    <link rel="stylesheet" href="css/bootstrap5.css">
		<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
  </head>
  <body>
    <?php
    include("authentication.php");
    include("includes/authHeader.php");
    include("Controllers/externalReferralController.php");

    $con = new externalReferralController();
    $rid = $_SESSION['referralId'];
    ?>
    <div class="container mb-5">
      <h1>External referral detail</h1>
      <div class="d-flex justify-content-end mb-1">
        <a class="btn btn-danger mx-2" href="referralList.php" role="button">Back</a>
      </div>
      <hr>
      <div>
        <h2>Referral information</h2>
        <div class="row gy-3 mt-4">
          <div class="items col-6">
            <h6>Referral ID</h6>
            <h5><?php echo $rid; ?></h5>
          </div>
          <div class="items col-6">
            <h6>Referral date</h6>
            <h5><?php echo $con->getReferralDate($rid); ?></h5>
          </div>
          <div class="items col-6">
            <h6>Doctor's name</h6>
            <h5><?php echo $con->getDoctorName($rid); ?></h5>
          </div>
          <div class="items col-6">
            <h6>Referral reason</h6>
            <h5><?php echo $con->getReason($rid); ?></h5>
          </div>
        </div>
      </div>
      <hr>
      <div>
        <h2>Patient information</h2>
        <div class="row gy-3 mt-4">
          <div class="items col-6">
            <h6>NRIC/Passport number</h6>
            <h5><?php echo $con->getPatientIdentityNumber($rid); ?></h5>
          </div>
          <div class="items col-6">
            <h6>Patient's name</h6>
            <h5><?php echo $con->getPatientName($rid); ?></h5>
          </div>
          <div class="items col-6">
            <h6>Date of birth</h6>
            <h5><?php echo $con->getPatientDateOfBirth($rid); ?></h5>
          </div>
          <div class="items col-6">
            <h6>Sex</h6>
            <h5><?php echo $con->getPatientSex($rid); ?></h5>
          </div>
          <div class="items col-6">
            <h6>Patient's Contact number</h6>
            <h5><?php echo $con->getPatientPhoneNumber($rid); ?></h5>
          </div>
          <div class="items col-6">
            <h6>Patient's email address</h6>
            <h5><?php echo $con->getPatientEmailAddress($rid); ?></h5>
          </div>
          <div class="items col-6">
            <h6>Patient's Address</h6>
            <h5><?php echo $con->getPatientAddress($rid); ?></h5>
          </div>
        </div>
      </div>
    <hr>
    <div id="referrer-info">
      <h2>Referrer information</h2>
      <div class="row gy-3 mt-4">
        <div class="items col-6">
          <h6>Referrer name</h6>
          <h5><?php echo $con->getReferrerName($rid); ?></h5>
        </div>
        <div class="items col-6">
          <h6>Referrer's Contact number</h6>
          <h5><?php echo $con->getReferrerPhoneNumber($rid); ?></h5>
        </div>
        <div class="items col-6">
          <h6>Referrer's Email address</h6>
          <h5><?php echo $con->getReferrerEmailAddress($rid); ?></h5>
        </div>
        <div class="items col-6">
          <h6>Healthcare organization name</h6>
          <h5><?php echo $con->getReferrerOrganization($rid); ?></h5>
        </div>
        <div class="items col-6">
          <h6>Referrer's address</h6>
          <h5><?php echo $con->getReferrerAddress($rid); ?></h5>
        </div>
      </div>
    </div>
  </div>
  <script src="js/fontawesome.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap5.js"></script>
  <!-- <script src="https://use.fontawesome.com/5def5740b2.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  </body>
</html>
