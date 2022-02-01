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
		include('Controllers/userController.php');
        $con = new userController();
		$con->getProfileDetails($_SESSION['patientName']);
		$id = $_SESSION['userId'];
		$email = $con->getEmail();
        $user = $auth->getUserByEmail($email);
		$uid =$user->uid;

		if(isset($_POST['deactivate'])) {

			$con->deactivateUser($id, $uid, true);
		}
	?>
    <div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h3>Patient profile <a href="detailMenu.php" class="btn btn-danger float-end">Back</a></h3>
						</div>
					</div>
					<div class="card-body">
						<h4 class="inlineStyle">Personal details</h4>
						<button type="submit" class="btn btn-primary float-end" data-bs-toggle='modal' data-bs-target='#deactivateModal'>Deactivate account</button>
							<div class="form-group">
											<form method="post" name="viewProfile">
													<input type="hidden" class="form-control" id="userid" name="userid" value="<?php echo $uid; ?>">
													<div class="row">
															<div class="col">
																	<div class="mb-3">
																			<span class="formspan">
																					<label><strong>Full Name: </strong></label>
																					<input type="text" readonly class="form-control-plaintext" id="fname" value="<?php echo $con->getFname();?>">
																			</span>
																	</div>
															</div>
															<div class="col">
																	<div class="mb-3">
																			<span class="formspan">
																					<?php
																							 $nric = $con->getIdentityNumber();
																							 $maskedNRIC = substr($nric,0,1).str_repeat('*',4).substr($nric,5,4);
																					?>
																					<label><strong>NRIC: </strong></label>
																					<input type="text" readonly class="form-control-plaintext" id="nric" value="<?php echo $maskedNRIC?>">
																			</span>
																	</div>
															</div>
													</div>
													<div class="row">
															<div class="col">
																	<div class="mb-3">
																			<span class="formspan">
																					<label><strong>Email Address:</strong></label>
																					<input type="text" readonly class="form-control-plaintext" id="email" value="<?php echo $con->getEmail();?>">
																			</span>
																	</div>
															</div>
															<div class="col">
																	<div class="mb-3">
																			<span class="formspan">
																					<label><strong>Contact Number: </strong></label>
																					<input type="text" readonly class="form-control-plaintext" id="phone" value="<?php echo $con->getPhone();?>">
																			</span>
																	</div>
															</div>
													</div>
													</div>
														<div class="row">
																<div class="col">
																		<div class="mb-3">
																				<span class="formspan">
																						<label><strong>Role:</strong></label>
																						<input type="text" readonly class="form-control-plaintext" id="role" value="<?php echo $con->getRole();?>">
																				</span>
																		</div>
																</div>
														</div>
												</form>
								</div>
					</div>
				</div>
			</div>
    </div>

		<!-- modal -->
    <div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirmation</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
              <div class="modal-body modal-dialog-scrollable">
                <h6>Deactivate this account?</h6>
              </div>
              <div class="modal-footer">
                <input type="submit" name="deactivate" value="Yes" class="btn btn-primary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              </div>
            </form>
        </div>
      </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-app.js"></script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
