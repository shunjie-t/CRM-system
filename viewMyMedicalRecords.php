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
    ?>
    <div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h3>
							My Medical Record
							<a href="home.php" class="btn btn-danger float-end">Back</a>
                    	</h3>
					</div>
                    <div class="card-body">
                        <h4 class="inlineStyle">Medical Records</h4>
                            <form action="" method="post" name="viewMedicalRecords">
                            <?php
                                include("Controllers/medicalRecordController.php");
                                $user = $auth->getUser($_SESSION['uid']);
		                        $name=$user->displayName;
                                $medicalRecord = new  medicalRecordController();
                                $medicalRecord->setPatientRecords($name);
                                $patientId = $medicalRecord->getPatientId();
                                $medicalRecord->setMyRecords($patientId);
                            ?>
                                <div class="row">
                                    <div class="col">
                                        <label><strong>Height:</strong></label>
                                        <input type="text" readonly class="form-control-plaintext" id="height" name="height" value="<?php print_r($medicalRecord->getHeight()[$patientId]);?>">
                                    </div>
                                    <div class="col">
                                        <label><strong>Weight:</strong></label>
                                        <input type="text" readonly class="form-control-plaintext" id="weight" name="weight" value="<?php print_r($medicalRecord->getWeight()[$patientId]);?>">
                                    </div>
                                    <div class="col">
                                        <label><strong>Body Mass Index(BMI):</strong></label>
                                        <input type="text" readonly class="form-control-plaintext" id="bmi" name="bmi" value="<?php print_r($medicalRecord->getBmi()[$patientId]);?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label><strong>Allergies:</strong></label>
                                        <textarea name="allergies" id="allergies" cols="30" rows="5" class="form-control-plaintext" readonly><?php print_r($medicalRecord->getAllergy()[$patientId]);?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label><strong>Blood Pressure:</strong></label>
                                        <input type="text" readonly class="form-control-plaintext" id="bp" name="bp" value="<?php print_r($medicalRecord->getBloodPressure()[$patientId]);?>">
                                    </div>
                                    <div class="col">
                                        <label><strong>Blood Glucose:</strong></label>
                                        <input type="text" readonly class="form-control-plaintext" id="bg" name="bg" value="<?php print_r($medicalRecord->getBloodGlucose()[$patientId]);?>">
                                    </div>
                                    <div class="col">
                                        <label><strong>Cholesterol:</strong></label>
                                        <input type="text" readonly class="form-control-plaintext" id="cholesterol" name="cholesterol" value="<?php print_r($medicalRecord->getCholesterol()[$patientId]);?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label><strong>Immunisations:</strong></label>
                                        <input type="text" readonly class="form-control-plaintext" id="immunisation" name="immunisation" value="<?php print_r($medicalRecord->getImmunization()[$patientId]);?>">
                                    </div>
                                    <div class="col">
                                        <label><strong>Medications:</strong></label>
                                        <textarea name="medication" id="medication" cols="30" rows="3" class="form-control-plaintext" readonly><?php print_r($medicalRecord->getMedication()[$patientId]);?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label><strong>Medical History:</strong></label>
                                        <textarea name="medicalHistory" id="medicalHistory" cols="30" rows="5" class="form-control-plaintext" readonly><?php print_r($medicalRecord->getMedicalHistory()[$patientId]);?></textarea>
                                    </div>
                                    <div class="col">
                                        <label><strong>Medical Condition:</strong></label>
                                        <textarea name="medicalCondition" id="medicalCondition" cols="30" rows="5" class="form-control-plaintext" readonly><?php print_r($medicalRecord->getMedicalCondition()[$patientId]);?></textarea>
                                    </div>
                                </div>
                            </form>
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