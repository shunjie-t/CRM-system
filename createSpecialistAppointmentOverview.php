<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
        $patients->setPatientRecords($name);
        $patientId = $patients->getPatientId();
        $email = $patients->getEmail();
        $aid=$pid=$did=$pname=$dname=$title=$sdate=$stime=$etime=$bdate=$venue=$notes="";

        if(isset($_POST['next'])) {
            $sdate = date("Y-m-d", strtotime($_POST['sdate']));
            $_SESSION['doctorName'] = $_POST['dname'];
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['sdate'] = $sdate;
            header('Location: createAppointmentBySpecialist.php?department='.$department.'');
            //$con->rescheduleAppointment($aid,$ndate,$ntime,$ntime,false);
        }
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
                        <form action="" method="post" name="bookAppointmentBySpecialistOverview">
                        <div class="form-group mb-3">
                          <label>Patient Name: </label>
                          <input type="text" readonly class="form-control" name="pname" id="pname" value="<?php echo $name; ?>" >
                        </div>
                        <div class="form-group mb-3">
                          <label>Doctor Name: </label>
                          <select class="form-control" id="dname" name="dname">
                                <?php
                                    $doctorName = $database->getReference("doctors")->orderByChild("department")->equalTo($department)->getValue();
                                    foreach($doctorName as $doctor){
                                        if($doctor["department"]==$department){
                                            ?>
                                                <option value="<?=$doctor['name'];?>">Dr <?=$doctor['name'];?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
						</div>
                        <div class="form-group mb-3">
                            <label>Department: </label>
						    <input type="text" readonly class="form-control" name="department" id="department" value="<?php echo $department; ?>"> 
                        </div>
						<div class="form-group mb-3">
							<label>Purpose of Visit: </label>
							<input type="text" class="form-control" name="title" id="title">
                        </div>
                        <div class="form-group">
  							<label>Appointment Date: </label>
                            <div class="input-group mb-3">
                            <button class="btn btn-outline-secondary" type="button" id="clearDate">Clear</button>
                            <input type="text" class="form-control" name="sdate" id="datepicker" onkeydown="return false;" autocomplete="off" required>
                        </div>
                        <div class="form-group my-2 d-flex">
                            <input type="submit" name="next" class="btn btn-primary" value="Next">
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
      var dt = (new Date().getFullYear()).toString() + ":" + (new Date().getFullYear() + 10).toString();
      var formHidden = true;

      $(function() {
        $( "#datepicker" ).datepicker({
          yearRange: dt,
          changeYear: true,
          numberOfMonths: 2,
          minDate: new Date()
        });

        $("#clearDate").click(function() {
          $("#datepicker").val("");
        });

        $("#reschedule").click(function() {
          if(formHidden) {
            $("#sep").show();
            $("#form").show();
            formHidden = false;
          }
          else {
            $("#sep").hide();
            $("#form").hide();
            formHidden = true;
          }
        });

        $("#cnlReschedule").click(function() {
          $('#sep').hide();
          $('#form').hide();
        });
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
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