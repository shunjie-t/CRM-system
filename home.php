<?php
	include("authentication.php");
	include("dbcon.php");
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
			<div class="col-md-12">
				<?php 
					if(isset($_SESSION['status'])){
						echo "<h5 class='alert alert-success'>". $_SESSION['status'] ."</h5>";
						unset($_SESSION['status']);
					}
				?>
				<?php
					$user = $auth->getUser($_SESSION['uid']);
					$name=$user->displayName;
				?>
				<h3 style="text-align:center;">Hello, <?=$name?> </h3>
				<h5 style="text-align:center;">Welcome to Private Hospital CRM System. </h5>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row align-items-start">
  			<div class="col">
  				<div class="card" style="width: 25rem;">
				  	<a href="profile-details.php"> 
						<img src="images/myprofile.jpg" width="400" height="375" class="card-img-top">
					</a>
     				<div class="card-body">
      					<p class="card-text">You can view all your personal details here.you may choose to edit your address and your contact number and change your password.</p>
        				<a href="profile-details.php" class="btn btn-primary" style="text-align:center;">Profile Details</a>
      				</div>
   				</div>
  			</div>
			<?php
			$reference = "user/";
			try{
				$ref = $database->getReference($reference)
								->orderByChild('name')
								->equalTo($name)
								->getValue();
				foreach($ref as $key => $row){
					$_SESSION["role"] = $row["role"];
					$role = $_SESSION["role"];
					if($role=="patient"){
					?>
					<div class="col">
						<div class="card" style="width: 25rem;">
							<a href="viewMyRecords.php">
								<img src="images/records.jpg" width="400" height="400" class="card-img-top">
							</a>
							<div class="card-body">
								<p class="card-text">you can view the details of all your consultation here. </p>
								<a href="viewMyRecords.php" class="btn btn-primary" style="text-align:center;">View Consultation Records</a>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card" style="width: 25rem;">
							<a href="viewMyMedicalRecords.php">
								<img src="images/records.jpg" width="400" height="400" class="card-img-top">
							</a>
							<div class="card-body">
								<p class="card-text">you can view the details of all your  medical records here. </p>
								<a href="viewMyMedicalRecords.php" class="btn btn-primary" style="text-align:center;">View Medical Records</a>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card" style="width: 25rem;">
							<a href="viewMyAppointment.php">
								<img src="images/appointment.jpg" width="400" height="400" class="card-img-top">
							</a>
							<div class="card-body">
								<p class="card-text">You can view all details of your appointment such as the current appointments and the past appointments that have been attended or missed.</p>
								<a href="viewMyAppointment.php" class="btn btn-primary" style="text-align:center;">View My Appointment</a>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card" style="width: 25rem;">
							<a href="viewMyBills.php">
								<img src="images/billing.jpg" width="400" height="400" class="card-img-top">
							</a>
							<div class="card-body">
								<p class="card-text">You can view details of your billing records such as the estimated amount you spent and the estimated cost of the consultaition and the cost of the tests.</p>
								<a href="viewMyBills.php" class="btn btn-primary" style="text-align:center;">View Bill Estimator</a>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card" style="width: 25rem;">
							<a href="viewArticles.php">
								<img src="images/education.jpg" width="400" height="400" class="card-img-top">
							</a>
							<div class="card-body">
								<p class="card-text">Here is some of the articles that are updated monthly for you to have some knowledge on how to lead a healthier lifestyle.</p>
								<a href="viewArticles.php" class="btn btn-primary" style="text-align:center;">View Educational Articles</a>
							</div>
						</div>
					</div>
					<?php
					} elseif($role=="doctor"){
					?>
					<div class="col">
						<div class="card" style="width: 25rem;">
							<a href="myPatient.php">
								<img src="images/mypatient.jpg" width="400" height="350" class="card-img-top">
							</a>
							<div class="card-body">
								<p class="card-text">you can view the details of your patient. Some things you can explore such as the consultation records, patient's medical records and the date of appointments of your patients</p>
								<a href="myPatient.php" class="btn btn-primary" style="text-align:center;">My Patients</a>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card" style="width: 25rem;">
							<a href="viewReferrals.php">
								<img src="images/appointment.jpg" width="400" height="400" class="card-img-top">
							</a>
							<div class="card-body">
								<p class="card-text">you can view the list of referral referred by you or patients that had been referred to you.</p>
								<a href="viewReferrals.php" class="btn btn-primary" style="text-align:center;">Referrals</a>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card" style="width: 25rem;">
							<a href="doctorSchedule.php?name=<?=$name;?>">
								<img src="images/schedule.jpg" width="400" height="400" class="card-img-top">
							</a>
							<div class="card-body">
								<p class="card-text">You can view the upcoming appointments.</p>
								<a href="doctorSchedule.php?name=<?=$name;?>" class="btn btn-primary" style="text-align:center;">My Schedule</a>
							</div>
						</div>
					</div>
					<?php
					}elseif($role=="medical administrator"){
					?>
						<div class="col">
							<div class="card" style="width: 25rem;">
								<a href="patientProfile.php">
									<img src="images/patientProfile.png" width="400" height="400" class="card-img-top">
								</a>
								<div class="card-body">
									<p class="card-text">You are able to view profiles of all patients. Some information such as patient personal information, medical records, appointment details can be viewed from here.</p>
									<a href="patientProfile.php" class="btn btn-primary" style="text-align:center;">Patient Profile</a>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card" style="width: 25rem;">
								<a href="referralList.php">
									<img src="images/appointment.jpg" width="400" height="400" class="card-img-top">
								</a>
								<div class="card-body">
									<p class="card-text">You can view the list of referral that doctor have referred patients from one department to another.</p>
									<a href="referralList.php" class="btn btn-primary" style="text-align:center;">Referrals</a>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card" style="width: 25rem;">
								<a href="viewAllArticles.php">
									<img src="images/education.jpg" width="400" height="400" class="card-img-top">
								</a>
								<div class="card-body">
									<p class="card-text">You are able to create or edit educational articles for patients to view.</p>
									<a href="viewAllArticles.php" class="btn btn-primary" style="text-align:center;">Education Articles</a>
								</div>
							</div>
						</div>
					<?php
					} elseif($role=="application administrator"){
					?>
					<div class="col">
						<div class="card" style="width: 25rem;">
							<a href="user.php">
								<img src="images/user.jpg" width="400" height="400" class="card-img-top">
							</a>
							<div class="card-body">
								<p class="card-text">you can view details of all user accounts and manage them with one table. You can create new user accounts when there are new staffs in the organisations.</p>
								<a href="user.php" class="btn btn-primary" style="text-align:center;">Users Management</a>
							</div>
						</div>
					</div>
					<?php
					}
				}
				?>
				<?php
			}catch(Throwable $e){
				echo $e->getMessage();
				exit();
			}
		?>
			
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
</body>
</html>