<?php
	include("authentication.php");
	include("includes/authHeader.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRM System</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3>
						Bill Estimator
						<a href="home.php" class="btn btn-danger float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <h2>What would you like to get a cost estimate for?</h2>
                    <div class="form-outline">
                        <form action="viewMyBills.php" method="post">
                            <select name="search" id="search">
                                <optgroup label="Cardiology" id="department" name="department">
                                    <option value="Ablation for Irregular Heart Rhythm">Ablation for Irregular Heart Rhythm</option>
                                    <option value="Angioplasty with stenting (1 vessel)">Angioplasty with stenting (1 vessel)</option>
                                    <option value="Angioplasty with stenting (more than 1 vessel)">Angioplasty with stenting (more than 1 vessel)</option>
                                    <option value="Coronary Artery Bypass">Coronary Artery Bypass</option>
                                    <option value="Coronary angiography">Coronary angiography</option>
                                </optgroup>
                                <optgroup label="Dermatology" id="department" name="department">
                                    <option value="Repair of Soft Tissue Injury for Shoulder">Repair of Soft Tissue Injury for Shoulder</option>
                                    <option value="Incision with Drainage">Incision with Drainage</option>
                                    <option value="Removal of unhealthy tissue">Removal of unhealthy tissue</option>
                                </optgroup>
                                <optgroup label="Neurology" id="department" name="department">
                                    <option value="Brain and spinal cord tumour">Brain and spinal cord tumour </option>
                                    <option value="Dementia">Dementia</option>
                                    <option value="Epilepsy">Epilepsy</option>
                                    <option value="Sleep disorder">Sleep disorder</option>
                                </optgroup>
                                <optgroup label="Paediatric" id="department" name="department">
                                    <option value="Neonatal surgery">Neonatal surgery(Newborns Only) </option>
                                    <option value="Thoracic surgery">Thoracic surgery(Chest)</option>
                                    <option value="Oncological surgery">Oncological surgery(Cancer)</option>
                                    <option value="Minimally invasive or endoscopic surgery">Minimally invasive or endoscopic surgery(Keyhole)</option>
                                </optgroup>
                                <optgroup label="Orthopaedic" id="department" name="department">
                                    <option value="Knee replacement surgery (one-side only)">Knee replacement surgery (one-side only) </option>
                                    <option value="Fractures">Fractures</option>
                                    <option value="Foot deformities">Foot deformities</option>
                                </optgroup>
                            </select>
                           <!-- <input type="text" size="30" name="search" id="search">-->
                            <button type="submit" class="btn btn-primary" name="submit">Search</button>
                        </form>
                        <?php
                            include("Controllers/appointmentController.php");
                            $appointment = new appointmentController();
                            if(isset($_POST["submit"])){
                                $search= $_POST["search"];
                                $appointment->getBillingRecords($search);
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
    <script src="js/bills.js"></script>
</body>
</html>