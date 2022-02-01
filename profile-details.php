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
        $data = new userController();
    ?>
    <div class="container">
        <div class="row">
            <?php
                if(isset($_SESSION['status'])){
                    echo "<h5 class='alert alert-success'>".$_SESSION['status']."</h5>";
                    unset($_SESSION['status']);
                }
            ?>
            <div class="col-md-12">
                <div class="card">
                 <div class="card-header">
                    <h3> Profile and Preferences
                        <a href="home.php" class="btn btn-danger float-end">Back</a>                
                    </h3>
                </div>
                <div class="card-body">
                        <h4 class="inlineStyle">Personal details</h4>
                        <div class="form-group">
                            <?php
                                $user = $auth->getUser($_SESSION['uid']);
					            $name=$user->displayName;
                                $doctorName=$user->displayName;
                                $role = $_SESSION["role"];
                                if($role == "doctor"){
                                    $data->getDoctorProfileDetails($doctorName, $doctorName);
                                } else{
                                    $data->getProfileDetails($name);
                                }
                                $userID = $database->getReference('user')->push()->getKey();
                                //$userID = $data->getUserId();
                                $userID = $key;
                                $id = $_SESSION["uid"];
                                
                            ?>
                                <a href="profile-details.php?id=<?=$id;?>&&uid=<?=$userID;?>" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                Edit Profile Details
                                <?php
                                    $userId=$fname=$email=$phone=$officeNo="";    
                                    class viewProfileUI{
                                        public function editProfile($data, $id, $userID, $fname, $email, $phone, $officeNo) {
                                                $role = $_SESSION["role"];
                                                if(isset($_POST['editProfile']))
                                                {
                                                    $id = $id;
                                                    $uid = $userID;
                                                    $fname = $_POST['fname'];
                                                    $email = $_POST['email'];
                                                    $phone = $_POST['phone'];
                                                    if($role != "patient"){
                                                        $officeNo = $_POST['officeNo'];
                                                        $data->validateProfile($role,$id, $uid, $fname, $email, $phone, $officeNo);
                                                    } else {
                                                        $officeNo = "";
                                                        $data->validateProfile($role, $id, $uid, $fname, $email, $phone, $officeNo);
                                                    }
                                                
                                                }
                                            }
                                        }
                                                            
                                    $main = new viewProfileUI();
                                    $main->editProfile($data, $id, $userID, $fname, $email, $phone, $officeNo);
                                ?>
                                </a>&nbsp; 
                                <a href="changePassword.php?id=<?=$id;?>&&uid=<?=$userID;?>" class="btn btn-primary float-end">Change Password</a>
                                <form action="profile-details.php" method="post" name="viewProfile">
                                    <input type="hidden" class="form-control" id="userid" name="userid" value="<?php echo $id; ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <span class="formspan">
                                                    <label><strong>Full Name: </strong></label>
                                                    <input type="text" readonly class="form-control-plaintext" id="fname" value="<?php echo $data->getFname();?>">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <?php if($role == "doctor"){ ?>
                                            <div class="mb-3">
                                                <span class="formspan">
                                                    <label><strong>Gender: </strong></label>
                                                    <input type="text" readonly class="form-control-plaintext" id="gender" value="<?php echo $data->getGender();?>">
                                                </span>
                                            </div>
                                            <?php }?>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <span class="formspan">
                                                    <?php
                                                         $nric = $data->getIdentityNumber();
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
                                                    <input type="text" readonly class="form-control-plaintext" id="email" value="<?php echo $data->getEmail();?>">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <span class="formspan">
                                                    <label><strong>Contact Number: </strong></label>
                                                    <input type="text" readonly class="form-control-plaintext" id="phone" value="<?php echo $data->getPhone();?>">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <?php
                                            if($role != "patient"){
                                            ?>
                                            <div class="mb-3">
                                                <span class="formspan">
                                                    <label><strong>Office Number: </strong></label>
                                                    <input type="text" readonly class="form-control-plaintext" id="officeNo" value="<?php echo $data->getOfficeNo();?>">
                                                </span>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                        if($role == "doctor"){
                                        ?>
                                        <div class="col">
                                            <div class="mb-3">
                                                <span class="formspan">
                                                    <label><strong>Department: </strong></label>
                                                    <input type="text" readonly class="form-control-plaintext" id="department" value="<?php echo $data->getDepartment();?>">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <span class="formspan">
                                                    <label><strong>Venue: </strong></label>
                                                    <input type="text" readonly class="form-control-plaintext" id="venue" value="<?php echo $data->getVenue();?>">
                                                </span>
                                            </div>
                                        </div>    
                                        <?php
                                        }
                                        ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <span class="formspan">
                                                    <label><strong>Role:</strong></label>
                                                    <input type="text" readonly class="form-control-plaintext" id="role" value="<?php echo $data->getRole();?>">
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

     <!-- Modal -->
     <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="editProfileForm" method="post" action=""> 
                        <input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo $userID;?>">
                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id;?>">
                        <div class="mb-3">
                            <span class="formspan">
                                <label><strong>Full Name: </strong></label>
                                <input type="text" readonly class="form-control" id="fname" name="fname" value="<?php echo $data->getFname();?>">
                            </span>
                        </div>
                        <div class="mb-3">
                            <span class="formspan">
                                <label><strong>Email Address:</strong></label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $data->getEmail();?>">
                            </span>
                        </div>
                        <div class="mb-3">
                            <span class="formspan">
                                <label><strong>Contact Number: </strong></label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $data->getPhone();?>">
                            </span>
                        </div>
                        <?php if($role != "patient"){ ?>
                        <div class="mb-3">
                            <span class="formspan">
                                <label><strong>Office Number: </strong></label>
                                <input type="text" class="form-control" id="officeNo" name="officeNo" value="<?php echo $data->getOfficeNo();?>">
                            </span>
                        </div>
                        <?php } ?>
                        <button type="submit" id="editProfile" name="editProfile" class="btn btn-primary float-end">Submit</button>
                        <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Close</button>
                    </form>
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
</body>
</html>