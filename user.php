<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRM System</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" href="css/bootstrap5.css">
    <script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!--<script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
    <script>
        function showDoctor(){
            var doctor = document.getElementById("doctor");
            var medadmin = document.getElementById("medadmin");
             
            if(doctor.style.display === "none") {
                doctor.style.display = "block";
                medadmin.style.display = "none";
            } else {
                doctor.style.display = "none";
                medadmin.style.display = "none";
            }
        }

        function showMedicalAdmin(){
            var doctor = document.getElementById("doctor");
            var medadmin = document.getElementById("medadmin");
             
            if(medadmin.style.display === "none") {
                doctor.style.display = "none";
                medadmin.style.display = "block";
            } else {
                doctor.style.display = "none";
                medadmin.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <?php 
    include("authentication.php");
    include("includes/authHeader.php");
    include("Controllers/userController.php");
    $data = new userController();
    ?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
                 <?php 
					if(isset($_SESSION['status'])){
						echo "<h5 class='alert alert-success'>". $_SESSION['status'] ."</h5>";
						unset($_SESSION['status']);
					}
				?>
				<div class="card">
					<div class="card-header">
						<h3>
							Users Management
							<a href="home.php" class="btn btn-danger float-end">Back</a> 
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Create New User
                            <?php
                                $fname=$email=$identityNumber=$phone=$officeNo=$role=$department=$wing=$venue=$password=$gender="";      
                                $ref_table = "user/";
                                $ref_table2 = "doctors/";
                                $count = $database->getReference($ref_table)->getSnapshot()->numChildren();
                                $count2 = $database->getReference($ref_table2)->getSnapshot()->numChildren();
                                $increment = $count + 1;     
                                $increment2 = $count2 + 1;     
                                class createUserUI{
                                    public function checkUser($data, $increment, $increment2, $fname, $email, $identityNumber, $phone, $officeNo, $gender, $role, $department, $venue, $password) {
                                        if(isset($_POST['createUser']))
                                        {
                                            $uid = $increment; 
                                            $doctorId = $increment2;
                                            $fname = $_POST['fname'];
                                            $email = $_POST['email'];
                                            $identityNumber = $_POST['identityNumber'];
                                            $phone = $_POST['phone'];
                                            $officeNo = $_POST['officeNo'];
                                            $gender = $_POST['gender'];
                                            $role = $_POST['role'];
                                            $department = $_POST['department'];
                                            $venue = $_POST['venue'];
                                            $password = $_POST['password'];
                                                        
                                            $data->validateUser($uid, $doctorId, $fname, $email, $identityNumber, $phone, $officeNo, $gender, $role, $department, $venue, $password);
                                        }
                                    }
                                }
                                                
                                $main = new createUserUI();
                                $main->checkUser($data, $increment, $increment2, $fname, $email, $identityNumber, $phone, $officeNo, $gender, $role, $department, $venue, $password);
                            ?>
                            </button>
                    	</h3>
					</div>
                    <div class="col">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <button class="nav-link" onclick="showDoctor();">Doctor</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" onclick="showMedicalAdmin();">Medical Administrator</button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive" id="doctor" style="display:none;">
                            <div class="input-group">
                                <form action="" method="get">
                                    <div class="form-outline">
                                        <input type="search" id="listDoctorVariable" name="listDoctorVariable" class="form-control">
                                    </div>
                                    <input type="submit" id="searchDoctor" name="searchDoctor" value="Search" class="form-control">
                                </form>
                            </div>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Venue</th>
                                    <th>Role</th>
                                </thead>
                                <tbody>
                                <?php
                                    if (isset($_GET['searchDoctor']) && (!empty($_GET['listDoctorVariable']))) {
                                        $listDoctorVariable = $_GET['listDoctorVariable'];
                                        $data->searchDoctorList($listDoctorVariable);
                                    }
                                    else {
                                        $data->displayDoctorTable();
                                    } 
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive" id="medadmin" style="display:none;">
                            <div class="input-group">
                                <form action="" method="get">
                                    <div class="form-outline">
                                        <input type="search" id="listMedAdminVariable" name="listMedAdminVariable" class="form-control">
                                    </div>
                                    <input type="submit" id="searchMedAdmin" name="searchMedAdmin" value="Search" class="form-control">
                                </form>
                            </div>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </thead>
                                <tbody>
                                <?php
                                    if (isset($_GET['searchMedAdmin']) && (!empty($_GET['listMedAdminVariable']))) {
                                        $listMedAdminVariable = $_GET['listMedAdminVariable'];
                                        $data->searchMedAdminList($listMedAdminVariable);
                                    }
                                    else {
                                        $data->displayMedAdminTable();
                                    } 
                                ?>
                                </tbody>
                            </table>
                        </div>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Create New Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" name="createForm">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nameLabel" class="form-label">Full Name: </label>
                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="John Doe">
                                </div>
                            </div>
                            <div class="col">
                                <label>Gender: </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender" value="Male">
                                    <label class="form-check-label">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender" value="Female" checked>
                                    <label class="form-check-label">
                                        Female
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="identityLabel" class="form-label">Identity Number: </label>
                                    <input type="text" class="form-control" id="identityNumber" name="identityNumber" placeholder="S****508D">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="emailLabel" class="form-label">Email address: </label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="phoneLabel" class="form-label">Contact Number: </label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="91234567">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="officeLabel" class="form-label">Office Number: </label>
                                    <input type="text" class="form-control" id="officeNo" name="officeNo" placeholder="61234567">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="roleLabel" class="form-label">Role: </label>
                                <select name="role" class="form-select" aria-label="Default select example">
                                    <option selected>Default</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="medical administrator">Medical Administrator</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="departmentLabel" class="form-label">Department: </label>
                                <select id="department" name="department" class="input-field">
                                    <option  value="All Specialities" selected>  All Specialities </option>
                                    <option  value="Cardiology">  Cardiology  </option>
                                    <option  value="Orthopaedic">  Orthopaedic  </option>
                                    <option  value="Dermatology">  Dermatology  </option>
                                    <option  value="Paediatric">  Paediatric  </option>
                                    <option  value="Neurology">  Neurology  </option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="venueLabel" class="form-label">Venue: </label>
                                <input type="text" class="form-control" id="venue" name="venue">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="passwordLabel" class="form-label">Password: </label>
                                    <input type="text" class="form-control" id="password" name="password" placeholder="password" readonly>
                                    <input type="button" class="btn btn-primary" value="Generate" onClick="randomPassword(8);" tabindex="2">
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="createUser" name="createUser" class="btn btn-primary float-end">Submit</button>
                        <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Close</button>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    
	<script>
        function randomPassword(length) {
            var chars = "abcdefghijklmnopqrstuvwxyz!@ABCDEFGHIJKLMNOP1234567890";
            var pass = "";
            for (var x = 0; x < length; x++) {
                var i = Math.floor(Math.random() * chars.length);
                pass += chars.charAt(i);
            }
            createForm.password.value = pass;
        }
    </script>
    <script src="js/fontawesome.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap5.js"></script>
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
	
	
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