<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRM System</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<!--<script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
	<link rel="stylesheet" href="css/bootstrap5.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/jquery-ui.css">
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
</head>
<body>
    <?php 
    include("authentication.php");
    include("includes/authHeader.php");
    include("Controllers/appointmentController.php");
    $con = new appointmentController();
    $user = $auth->getUser($_SESSION['uid']);
	$name=$user->displayName;
    $id=$_GET["id"];
    $con->setAttribute($id);
    $aid = $con->getappointmentId();
    
    if(isset($_POST['next'])) {
        $_SESSION['sdate'] = $_POST['sdate'];
        header('Location: rescheduleAppointment2.php?id='.$id.'');
        //$con->rescheduleAppointment($aid,$ndate,$ntime,$ntime,false);
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3> Reschedule Appointment
                            <a href="viewMyAppointment.php" class="btn btn-danger float-end">Back</a>                
                        </h3>
                    </div>   
                    <div class="card-body">
                        <form action="" method="post" name="rescheduleAppointment">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label><strong>Title:</strong></label>
                                        <input type="text" readonly class="form-control" value="<?php echo $con->getTitle();?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label><strong>Patient Name:</strong></label>
                                        <input type="text" readonly class="form-control" value="<?php echo $con->getPatientName();?>">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label><strong>Doctor Name:</strong></label>
                                        <input type="text" readonly class="form-control" value="<?php echo $con->getDoctorName();?>"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label><strong>Original Date of Appointment:</strong></label>
                                        <input type="text" readonly class="form-control" value="<?php echo $con->getStartDate();?>"> 
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label><strong>Appointment Time:</strong></label>
                                        <input type="text" readonly class="form-control" value="<?php echo $con->getStartTime();?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
  							    <label>New Appointment Date: </label>
                                <div class="input-group mb-3">
                                <button class="btn btn-outline-secondary" type="button" id="clearDate">Clear</button>
                                <input type="text" class="form-control" name="sdate" id="datepicker" onkeydown="return false;" autocomplete="off" required>
                                </div>
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
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
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
    <script src="js/fontawesome.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap5.js"></script>
    <!-- The core Firebase JS SDK is always required and must be listed first -->
	<script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-app.js"></script>

	<!-- TODO: Add SDKs for Firebase products that you want to use
		 https://firebase.google.com/docs/web/setup#available-libraries -->
	<script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-analytics.js"></script>

	<script>
	  // Your web app's Firebase configuration
	  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
	  var firebaseConfig = {
		apiKey: "AIzaSyDF4WEa7F1_ZXWkqurIZElfE0-nqENMmUo",
		authDomain: "testcrm-1c228.firebaseapp.com",
		projectId: "testcrm-1c228",
		storageBucket: "testcrm-1c228.appspot.com",
		messagingSenderId: "85194436662",
		appId: "1:85194436662:web:829beb7b9bf90d68d0e897",
		measurementId: "G-GR5MN5F1CF"
	  };
	  // Initialize Firebase
	  firebase.initializeApp(firebaseConfig);
	  firebase.analytics();
	</script>
</body>
</html>