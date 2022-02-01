<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM System</title>
    <link rel="stylesheet" href="css/bootstrap5.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!--<script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
</head>
<body>
    <?php
        include("authentication.php");
        include("includes/authHeader.php");
        include("Controllers/appointmentController.php");
        include("Controllers/userController.php");
        $doctorName=$date="";
        $user = $auth->getUser($_SESSION['uid']);
        $name=$user->displayName;
        if($_SESSION['role'] == "medical administrator") $isPatient = false;
        else $isPatient = true;
        if(isset($_SESSION['patientName'])) $name = $_SESSION['patientName'];
        $doctorName = $_GET['doctorName'];
        $date = $_GET['date'];
        $patients = new userController();
        $appointment = new appointmentController();
        $appointment->setAttributeArray();
        $patients->setPatientRecords($name);
        $patients->setDoctorRecords($doctorName);
        $patientId = $patients->getPatientId();
        $doctorId = $patients->getDoctorId();
        $count = $database->getReference("appointments/")->getSnapshot()->numChildren();
        $increment = $count + 1;
        $email = $patients->getEmail();
        //echo $email;
        $aid=$pid=$did=$pname=$dname=$title=$sdate=$stime=$etime=$bdate=$department=$venue=$notes="";
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Book Appointment
                          <?php
                          if($_SESSION['role'] == "medical administrator") echo "<a href='appointmentOverview.php' class='btn btn-danger float-end'>Back</a>";
                          else echo "<a href='viewMyAppointment.php' class='btn btn-danger float-end'>Back</a>";
                          ?>
                        </h4>
                    </div>
                    <div class="card-body">
                    <form action="" method="post" name="bookAppointmentForm">
                    <?php
                        class createAppointmentUI{
                            public function checkAppointment($appointment, $email,  $increment, $patientId, $doctorId, $pname, $dname, $title, $sdate, $stime, $etime, $bdate, $department, $venue, $notes, $isPatient){

                                if(isset($_POST['submit'])){
                                    $aid = $increment;
                                    $pid = $patientId;
                                    $did = $doctorId;
                                    $pname = $_POST['pname'];
                                    $dname = $_POST['dname'];
                                    $title = $_POST['title'];
                                    $sdate = $_POST['sdate'];
                                    $stime = $_POST['stime'];
                                    //$etime = $_POST['etime'];
                                    $bdate = $_POST['bdate'];
                                    $department = $_POST['department'];
                                    $venue = $_POST['venue'];
                                    $notes = $_POST['notes'];

                                    $appointment->validateAppointment($email, $aid, $pid, $did, $pname, $dname, $title, $sdate, $stime, $etime, $bdate, $department, $venue, $notes, $isPatient);
                                }
                            }
                        }

                        $main = new createAppointmentUI();
                        $main->checkAppointment($appointment, $email,  $increment, $patientId, $doctorId, $pname, $dname, $title, $sdate, $stime, $etime, $bdate, $department, $venue, $notes, $isPatient);
                ?>
            <input type="hidden" class="form-control" id="pid" name="pid" value="<?php echo $patientId; ?>">
						<div class="form-group mb-3">
							<label>Patient Name: </label>
							<input type="text" readonly class="form-control" name="pname" id="pname" value="<?php echo $name; ?>" >
						</div>
            <div class="form-group mb-3">
							<label>Doctor Name: </label>
							<input type="text" readonly class="form-control" name="dname" id="dname" value="<?php echo $doctorName; ?>">
						</div>
						<div class="form-group mb-3">
              <label>Purpose of Visit: </label>
							<input type="text" class="form-control" name="title" id="title">
            </div>
            <div class="form-group mb-3">
              <label>Start Date: </label>
              <input type="text" readonly class="form-control" name="sdate" id="sdate" value="<?php echo $date; ?>">
            </div>
            <div class="form-group mb-3">
              <label>Start Time: </label>
              <div class="row g-3 mt-1">
                <?php
                $timeslots = $appointment->getTimeslot($date, $doctorId);
                if(!empty($timeslots)) {
                  foreach($timeslots as $k => $v) {
                    echo "<div class='col-2'>
                      <input type='radio' class='btn-check' name='stime' id='stime" . ($k+1) . "' value='$v' autocomplete='off'>
                      <label class='btn btn-outline-primary timeslot' for='stime" . ($k+1) . "' style='width:100px;'>" . $v . "</label>
                    </div>";
                  }
                }
                else {
                  echo "<div class='d-flex justify-content-center my-5'>
                    <h5>No timeslot available</h5>
                  </div>";
                }
                ?>
              </div>
            </div>
            <div class="form-group mb-3">
							<label>Booked Date: </label>
							<input type="text" readonly class="form-control" name="bdate" id="bdate" value="<?php echo date("Y-m-d"); ?>">
            </div>
            <div class="form-group mb-3">
              <div class="row">
                <div class="col">
                  <label>Department: </label>
                  <input type="text" readonly class="form-control" name="department" id="department" value="<?php echo $_GET['department']; ?>">
                </div>
                <div class="col">
                  <label>Venue: </label>
                  <input type="text" readonly class="form-control" name="venue" id="venue" value="<?php echo $_GET['venue']; ?>">
                </div>
              </div>
            </div>
            <div class="form-group mb-3">
                <label>Notes: </label>
                <textarea name="notes" id="notes" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group mb-3">
                <button type="submit" name="submit" class="btn btn-primary">Book Appointment</button>
            </div>
          </form>
        </div>
    </div>
</div>
</div>
</div>

    <script type="text/javascript">
      $(function() {
        $('input[name="stime"]').click(function() {
            var rBtn = $(this);

            if (rBtn.data('waschecked') == true) {
                rBtn.prop('checked', false);
                rBtn.data('waschecked', false);
            }
            else {
              rBtn.data('waschecked', true);
            }
        });
      });


    </script>

    <script src="js/fontawesome.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap5.js"></script>
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
	<!-- The core Firebase JS SDK is always required and must be listed first -->
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
