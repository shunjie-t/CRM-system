<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CRM System</title>
    <link rel="stylesheet" href="css/bootstrap5.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
  <body>
    <?php
      include("authentication.php");
      include("includes/authHeader.php");

      $pname = $_SESSION['patientName'];
    ?>
    <div class="container">
      <h1><?php echo $pname; ?></h1>
      <div class="d-flex justify-content-end mb-1">
        <a class="btn btn-danger mx-2" href="patientProfile.php" role="button">Back</a>
      </div>
      <div class="row g-3">
        <div class="col-xl-3 col-lg-6 col-md-12 ">
          <div class="card p-2">
            <img src="images/records.jpg" width="400" height="400" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Medical record</h5>
              <p class="card-text" style="height:100px;">
                See patient's medical records.<br>
                Update patient's medical records.
              </p>
              <a href="medicalRecord.php" class="btn btn-outline-primary">View</a>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-12">
          <div class="card p-2">
            <img src="images/appointment.jpg" width="400" height="400" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Appointment</h5>
              <p class="card-text" style="height:100px;">
                See patient's upcoming, past and missed appointments.<br>
                Book, reschedule or cancel appointment for patient.
              </p>
              <a href="appointmentOverview.php" class="btn btn-outline-primary">View</a>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-12">
          <div class="card p-2">
            <img src="images/records.jpg" width="400" height="400" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Consultation record</h5>
              <p class="card-text" style="height:100px;">See records of patient's past consultation.</p>
              <a href="consultationList.php" class="btn btn-outline-primary">View</a>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-12">
          <div class="card p-2">
            <img src="images/patientProfile.png" width="400" height="400" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Patient's account</h5>
              <p class="card-text" style="height:100px;">
                See patient's account details.<br>
                Disable patient's account.
              </p>
              <a href="deactivateAccount.php" class="btn btn-outline-primary">View</a>
            </div>
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

    <script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-app.js"></script>
  	<!-- TODO: Add SDKs for Firebase products that you want to use
  		https://firebase.google.com/docs/web/setup#available-libraries -->

  	<script>
  	// Your web app's Firebase configuration
  	var firebaseConfig = {
  		apiKey: "AIzaSyAjY7a0yDFGzLXv4gZlVp98J-I8XQUpEew",
  		authDomain: "fyp-project-9d41b.firebaseapp.com",
  		databaseURL: "https://fyp-project-9d41b-default-rtdb.firebaseio.com",
  		projectId: "fyp-project-9d41b",
  		storageBucket: "fyp-project-9d41b.appspot.com",
  		messagingSenderId: "88531315655",
  		appId: "1:88531315655:web:f124a1bd92c9d4fa6847e2"
  	};
  	// Initialize Firebase
  	firebase.initializeApp(firebaseConfig);
  	</script>
  </body>
</html>
