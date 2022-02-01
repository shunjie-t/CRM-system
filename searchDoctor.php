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
    include("Controllers/userController.php");
    $search = new userController();
    $user = $auth->getUser($_SESSION['uid']);
	$name=$user->displayName;
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>
						Search For Doctor
						<?php
						if($_SESSION['role'] == "medical administrator") echo "<a href='appointmentOverview.php' class='btn btn-danger float-end'>Back</a>";
						else echo "<a href='viewMyAppointment.php' class='btn btn-danger float-end'>Back</a>";
						?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <form action="" method="get">
                                <div>
                                    <label for="department">Search by Department:</label>
                                    <select id="department" name="department" class="input-field">
                                        <option  value="All Specialities" selected>  All Specialities </option>
                                        <option  value="Cardiology">  Cardiology  </option>
                                        <option  value="Orthopaedic">  Orthopaedic  </option>
                                        <option  value="Dermatology">  Dermatology  </option>
                                        <option  value="Paediatric">  Paediatric  </option>
                                        <option  value="Neurology">  Neurology  </option>
                                    </select>
                                </div>
                                <div>
                                    <label for="gender">Search by Gender:</label>
                                    <select id="gender" name="gender" class="input-field">
                                        <option  value="Male" selected> Male </option>
                                        <option  value="Female">  Female  </option>
                                    </select>
                                </div><br>
                                <input type="search" id="listVariable" name="listVariable" class="input-field"><br>
                                <input type="submit" id="search" name="search" value="Search" class="form-control">
                            </form>
                        </div>
                        <?php
                            if (isset($_GET['search'])) {
                                if(!empty($_GET['listVariable'])){
                                    $listVariable = $_GET['listVariable'];
                                    $search->searchDoctor($listVariable);
                                } elseif($_GET['department'] != "All Specialities"){
                                    $department = $_GET['department'];
                                    $search->searchDoctorSpecialty($department);
                                } elseif($_GET['gender']){
                                    $gender = $_GET['gender'];
                                    $search->searchDoctorGender($gender);
                                } 
                            } else {
                                $search->searchAllDoctor();
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