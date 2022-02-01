<!DOCTYPE html>
<html lang="en" dir="ltr">
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
        $department="";
        $department=$_GET["department"];
        $user = $auth->getUser($_SESSION['uid']);
		    $name=$user->displayName;
        $appointment = new appointmentController();
        $count = $database->getReference("appointments/")->getSnapshot()->numChildren();
        $increment = $count + 1;
        $patients = new userController();
        $dname = $_SESSION['doctorName'];
        $patients->setPatientRecords($name);
        $patients->setDoctorRecords($dname);
        $doctorId = $patients->getDoctorId();
        $patientId = $patients->getPatientId();
        $email = $patients->getEmail();
        $aid=$pid=$did=$pname=$dname=$title=$sdate=$stime=$etime=$bdate=$venue=$notes="";
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Book Appointment
                        <a href="viewMyBills.php" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" name="bookAppointmentBySpecialist">
                        <?php
                            if(isset($_POST['submit'])){
                              date_default_timezone_set('Asia/Singapore');
                                $aid = $increment;
                                $pid = $patientId;
                                $did = $doctorId;
                                $pname = $_POST['pname'];
                                $dname = $_POST['dname'];
                                $title = $_POST['title'];
                                $sdate = $_POST['sdate'];
                                $stime = $_POST['stime'];
                                $bdate = $_POST['bdate'];
                                $department = $_POST['department'];
                                $venue = $_POST['venue'];
                                $notes = $_POST['notes'];

                                $appointment->validateAppointment($email, $aid, $pid, $did, $pname, $dname, $title, $sdate, $stime, $etime, $bdate, $department, $venue, $notes);
                            }
                        ?>
                        <div class="form-group mb-3">
                          <label>Patient Name: </label>
                          <input type="text" readonly class="form-control" name="pname" id="pname" value="<?php echo $name; ?>" >
                        </div>
                        <div class="form-group mb-3">
                          <label>Doctor Name: </label>
                          <?php echo "<input type='text' class='form-control' name='dname' id='dname' autocomplete='off' readonly required value='" . $_SESSION['doctorName'] . "'>" ?>
                        </div>
                        <div class="form-group mb-3">
                          <label>Purpose of Visit: </label>
                          <?php echo "<input type='text' class='form-control' name='title' id='title' autocomplete='off' readonly required value='" . $_SESSION['title'] . "'>" ?>
                        </div>
                        <div class="form-group my-4">
							            <label>Start Date: </label>
                          <?php echo "<input type='text' class='form-control' name='sdate' id='sdate' autocomplete='off' readonly required value='" . $_SESSION['sdate'] . "'>" ?>
                        </div>
                        <div class="form-group mb-5" id="startTime">
                                <label>Appointment Time: </label>
                                <div class="btn-group d-block my-2" role="group">
                                <div class="row g-3">
                                    <?php
                                    $appointment->setAttributeArray();
                                    $timeslot = $appointment->getTimeslot($_SESSION['sdate'] , $doctorId);
                                    if(!empty($timeslot)) {
                                        foreach($timeslot as $k => $v) {
                                            echo "<div class='col-2'>
                                            <input type='radio' class='btn-check' name='stime' id='stime" . ($k+1) . "' value='" . $v . "' autocomplete='off'>
                                            <label class='btn btn-outline-primary timeslot' for='stime" . ($k+1) . "' style='width:100px;'>" . $v . "</label>
                                            </div>";
                                        }
                                    }
                                    else {
                                    echo "<div class='d-flex justify-content-center'>
                                        <h5 id='notimeslot'>No timeslot available</h5>
                                    </div>";
                                    }
                                    ?>
                                </div>
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
							        <input type="text" readonly class="form-control" name="department" id="department" value="<?php echo $department; ?>"> 
                                </div>
                                <div class="col">
                                    <label>Venue: </label>
							        <input type="text" readonly class="form-control" name="venue" id="venue" value="<?php echo $patients->getVenue(); ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Notes: </label>
                            <textarea name="notes" id="notes" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group my-2 d-flex">
                                <a type="button" name="cancel" href="javascript:window.history.back();" class="btn btn-secondary me-2" role="button">Previous</a>
                                <input type="submit" name="submit" class="btn btn-primary" value="Book Appointment">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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