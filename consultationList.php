<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CRM System</title>
    <link rel="stylesheet" href="css/bootstrap5.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <style media="screen">
    table {
      table-layout:fixed
    }

    td {
      word-wrap: break-word;
    }
    </style>
  </head>
  <body>
    <?php
    include("authentication.php");
    include("includes/authHeader.php");
    include("Controllers/consultationController.php");

    $con = new consultationController();
    $con->getConsultationDetails($_SESSION['patientName']);
    $idNum = $con->getNRIC();
    ?>
    <div class="container mb-5">
      <h1>Consultation detail</h1>
      <div class="d-flex justify-content-end mb-1">
        <a class="btn btn-danger mx-2" href="detailMenu.php" role="button">Back</a>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Consultation number</th>
            <th>NRIC/Passport number</th>
            <th>Doctor Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Reason</th>
            <th>Diagnosis</th>
            <th>prescription</th>
            <th>notes</th>
          </tr>
        </thead>
        <tbody>
          <?php $con->setConsultation($idNum); ?>
        </tbody>
      </table>
    </div>
    <script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>
