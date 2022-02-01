<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRM System</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
</head>
<body>
    <?php 
    include("authentication.php");
    include("includes/authHeader.php");
    include("Controllers/appointmentController.php");
    $con = new appointmentController();
    $user = $auth->getUser($_SESSION['uid']);
	$name=$user->displayName;
    $id = $_GET['id'];
    $con->setAttribute($id);
    $currentDate = date('Y-m-d');
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3> View
                            <a href="viewMyAppointment.php" class="btn btn-danger float-end">Back</a>                
                            <a href="rescheduleAppointment.php?id=<?=$id;?>" class="btn btn-primary float-end">Reschedule Appointment</a>
                            <?php if($con->getAppointmentStatus() == "Ongoing" && !($con->getStartDate() < $currentDate)){?>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Cancel Appointment
                            <?php
                                if(isset($_POST['Yes'])){
                                    $control = $con->getAppointmentStatus();
                                    if($control=="Ongoing"){$con->cancelAppointment($id);}
                                }          
                                elseif(isset($_POST['No'])){
                                    header("location: viewMyAppointment.php");
                                }
                            ?>
                            </button>
                            <?php } ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <h4 class="inlineStyle">Appointment Details</h4>
                            <form action="" method="post" name="viewAppointment">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label><strong>Patient Name: </strong></label>
                                            <input type="text" readonly class="form-control-plaintext" id="pname" name="pname" value="<?php echo $name; ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label><strong>Doctor Name: </strong></label>
                                            <input type="text" readonly class="form-control-plaintext" id="dname" name="dname" value="<?php echo $con->getDoctorName(); ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label><strong>Title: </strong></label>
                                            <input type="text" readonly class="form-control-plaintext" id="title" name="title" value="<?php echo $con->getTitle(); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label><strong>Appointment Date: </strong></label>
                                            <input type="text" readonly class="form-control-plaintext" id="sdate" name="sdate" value="<?php echo $con->getStartDate(); ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label><strong>Appointment Start Time: </strong></label>
                                            <input type="text" readonly class="form-control-plaintext" id="stime" name="stime" value="<?php echo $con->getStartTime(); ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label><strong>Appointment End Time: </strong></label>
                                            <input type="text" readonly class="form-control-plaintext" id="etime" name="etime" value="<?php echo $con->getEndTime(); ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label><strong>Booked Date: </strong></label>
                                            <input type="text" readonly class="form-control-plaintext" id="bdate" name="bdate" value="<?php echo $con->getBookedDate(); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label><strong>Department: </strong></label>
                                            <input type="text" readonly class="form-control-plaintext" id="department" name="department" value="<?php echo $con->getDepartment(); ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label><strong>Venue: </strong></label>
                                            <input type="text" readonly class="form-control-plaintext" id="venue" name="venue" value="<?php echo $con->getVenue(); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label><strong>Additional Notes: </strong></label>
                                            <textarea name="notes" id="notes" cols="30" rows="10" class="form-control-plaintext" readonly><?php echo $con->getNotes();?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal -->
     <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Cancel Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="cancelAppointment" method="post" action=""> 
                        <label style="float:center;"><strong> Confirm to cancel this appointment? </strong></label>
                        <input type="submit" class="btn btn-success" id="Yes" name="Yes" value="Yes" style="float:center;">
                        <input type="submit" class="btn btn-danger" id="No" name="No" value="No" style="float:center;">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	
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