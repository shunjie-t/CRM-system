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
		include("Controllers/userController.php");
		include("includes/authHeader.php");
		$search = new userController();

		$user = $auth->getUser($_SESSION['uid']);
		$name=$user->displayName;
		$search->displayDoctorID($name);
		$doctorID = $search -> getDoctorID();
		
		
		
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
					 	<h3>
                            My Patient
                            <a href="home.php" class="btn btn-danger float-end">Back</a> 
                     	</h3>
					</div>
					<div class="card-body">
						<div class="input-group">
           	 	    		<form action="myPatient.php" method="get">
								<div class="form-outline">
									<label>Search By: </label>
                        			<select id="searchBy" name="searchBy">
										<option value="Name">Patient Name</option>
										<option value="NRIC">Nric</option>
										<input type="search" id="listVariable" name="listVariable" class="form-control">
									</select>
                    			</div>
                    			<input type="submit" id="search" name="search" value="Search" class="form-control">
                			</form>
            			</div>
						<div class="table-responsive">
                            <table class="table table-striped table-hover">
							<?php
								if (isset($_GET['search']) && (!empty($_GET['listVariable']))) {
									$listVariable = $_GET['listVariable'];
									$searchBy = $_GET['searchBy'];
									echo "
									<thead>
										<tr>
											<th>ID</th>
											<th>NRIC/Passport Number</th>
											<th>Patient Name</th>
											<th>Date of Birth</th>
											<th>Sex</th>
											<th>Phone Number</th>
											<th>Email Address</th>																				
										</tr>
									</thead>
									<tbody>";
										 $search->searchPatient($listVariable, $searchBy);
										echo"</tbody>";	
								}else{
									echo"
									<thead>
										<tr>
											<th>ID</th>
											<th>NRIC/Passport Number</th>
											<th>Patient Name</th>
											<th>Date of Birth</th>
											<th>Sex</th>
											<th>Phone Number</th>
											<th>Email Address</th>		
										</tr>
									</thead>
									<tbody>";	
										$search->displaymyPatient($doctorID);	
									echo"</tbody>";
								}								
							?>
							</table>
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