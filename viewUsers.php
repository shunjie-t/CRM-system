<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRM System</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="css/bootstrap5.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>-->
</head>
<body>
    <?php
        $id = $_GET['id'];
        include("authentication.php");
        include("includes/authHeader.php");
        include("Controllers/userController.php");
        $con=new userController();
        $con->setAttribute($id);
        $role = $con->getRole();
        $email = $con->getEmail();
        $user = $auth->getUserByEmail($email);
        $uid = $user->uid;
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>
							View Users
							<a href="user.php" class="btn btn-danger float-end">Back</a> 
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Deactivate User
                            <?php
                                $info = $con->getAccountStatus();
                                if(isset($_POST['Yes'])){
                                    if($info == "Activated"){$con->deactivateUser($id, $uid, $isMedicalAdmin);}
                                } elseif(isset($_POST['No'])){
                                    header("Location: user.php");
                                }
                            ?>
                            </button>
                    	</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <form action="" method="post" name="viewForm">
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
                                    <?php
                                        if($role == 'doctor'){
                                        ?>
                                            <div class="mb-3">
                                            <span class="formspan">
                                                <label><strong>Gender: </strong></label>
                                                <input type="text" readonly class="form-control-plaintext" id="gender" value="<?php echo $con->getGender();?>">
                                            </span>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <span class="formspan">
                                                <?php
                                                $nric = $con->getIdentityNumber();
                                                $maskedNRIC = substr($nric,0,1).str_repeat('*',4).substr($nric,5,4);
                                                ?>
                                                <label><strong>Identity Number:</strong></label>
                                                <input type="text" readonly class="form-control-plaintext" id="email" value="<?php echo $maskedNRIC; ?>">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <span class="formspan">
                                                <label><strong>Email Address:</strong></label>
                                                <input type="text" readonly class="form-control-plaintext" id="email" value="<?php echo $con->getEmail();?>">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <span class="formspan">
                                                <label><strong>Contact Number: </strong></label>
                                                <input type="text" readonly class="form-control-plaintext" id="phone" value="<?php echo $con->getPhone();?>">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <span class="formspan">
                                                <label><strong>Office Number: </strong></label>
                                                <input type="text" readonly class="form-control-plaintext" id="officeNo" value="<?php echo $con->getOfficeNo();?>">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php
                                    if($role == 'doctor'){
                                    ?>
                                    <div class="col">
                                        <div class="mb-3">
                                            <span class="formspan">
                                                <label><strong>Department:</strong></label>
                                                <input type="text" readonly class="form-control-plaintext" id="department" value="<?php echo $con->getDepartment();?>">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <span class="formspan">
                                                <label><strong>Venue:</strong></label>
                                                <input type="text" readonly class="form-control-plaintext" id="venue" value="<?php echo $con->getVenue();?>">
                                            </span>
                                        </div>
                                    </div>
                                    <?php } ?>
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
                                    <div class="col">
                                    <div class="col">
                                        <div class="mb-3">
                                            <span class="formspan">
                                                <label><strong>Account Status:</strong></label>
                                                <input type="text" readonly class="form-control-plaintext" id="AccountStatus" value="<?php echo $con->getAccountStatus();?>">
                                            </span>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </form>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Deactivate Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="activateForm" method="post" action=""> 
                        <label style="float:center;"><strong> Confirm to Activate/Deactivate this record? </strong></label>
                        <input type="submit" class="btn btn-success" id="Yes" name="Yes" value="Yes" style="float:center;">
                        <input type="submit" class="btn btn-danger" id="No" name="No" value="No" style="float:center;">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/fontawesome.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap5.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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