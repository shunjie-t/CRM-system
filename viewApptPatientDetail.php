<?php 
$id = $_GET['id'];
$startdatetime = $_GET['startDate'];

include("authentication.php");
include("includes/authHeader.php");
include("Controllers/userController.php");
?>
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
    <div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h3>
							View Patient Detail
							<a href="home.php" class="btn btn-danger float-end">Back</a> 
                    	</h3>
                    </div>
					<div class="card-body">
                        <div class="form-group">
                            <?php
                                $data = new userController();
                                $data->getPatientDetails($id);
                            ?>
                            <form action="" method="post" name="viewForm">
                                <input type="hidden" class="form-control" id="patientId" name="patientId" value="<?php echo $data->getPatientID();?>">
                                <div class="mb-3">
                                    <span class="formspan">
                                        <label><strong>Full Name: </strong></label>
                                        <input type="text" readonly class="form-control-plaintext" id="fname" value="<?php echo $data->getFname();?>">
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <span class="formspan">
                                        <?php
                                            $nric = $data->getIdentityNumber();
                                            $maskedNRIC = substr($nric,0,1).str_repeat('*',4).substr($nric,5,4);
                                        ?>
                                       <label><strong>Patient's NRIC:</strong></label>
                                       <input type="text" readonly class="form-control-plaintext" id="nric" value="<?php echo $maskedNRIC;?>">
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <span class="formspan">
                                        <label><strong>Email Address:</strong></label>
                                        <input type="text" readonly class="form-control-plaintext" id="email" value="<?php echo $data->getEmail();?>">
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <span class="formspan">
                                        <label><strong>Contact Number: </strong></label>
                                        <input type="text" readonly class="form-control-plaintext" id="phone" value="<?php echo $data->getPhone();?>">
                                    </span>
                                </div>      
                                <div class="mb-3">
                                    <span class="formspan">
                                        <label><strong>Sex:</strong></label>
                                        <input type="text" readonly class="form-control-plaintext" id="sex" value="<?php echo $data->getSex();?>">
                                    </span>
                                </div>
                                <hr></hr>
                                <b>Emergency Contact Details</b>
                                <hr></hr>
                                <div class="mb-3">
                                    <span class="formspan">
                                            <label><strong>Emergency Contact: </strong></label>
                                            <input type="text" readonly class="form-control-plaintext" id="emergencyNo" value="<?php echo $data->getEmergencyContact();?>">
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <span class="formspan">
                                        <label><strong>Relationship to Patient:</strong></label>
                                        <input type="text" readonly class="form-control-plaintext" id="relationship" value="<?php echo $data->getRelationship();?>">
                                    </span>
                                </div>
                            </form>

                                <a href="viewConsultation.php?id=<?=$nric?>&&startDate=<?=$startdatetime?>" class="btn btn-primary">Consultation</a>
	                        
                                <form action="viewMedicalRecords.php">
	                           	<button name="id" class="btn btn-primary" value=<?php echo $data->getPatientID();?>>View Medical Record</button> 
	                       	</form>  
                        </div>
                    </div>
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