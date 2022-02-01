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
    <?php
        include("authentication.php");
        include("includes/authHeader.php");
        include('Controllers/userController.php');
        $data = new userController();
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3> Change Password
                            <a href="profile-details.php" class="btn btn-danger float-end">Back</a>                
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php
                            $id = $_GET['id'];
                            $uid = $_GET['uid'];
                           // echo $id;
                           // $data->setPassword($id);
                            $newPassword=$confirmNewPassword="";
                            class changePasswordUI{
                                public function changePassword($data, $id, $uid, $newPassword, $confirmNewPassword){
                                    if(isset($_POST["changePassword"])){
                                        $newPassword = $_POST["newPassword"];
                                        $confirmNewPassword = $_POST["confirmNewPassword"];

                                        $data->changePassword($id, $uid,  $newPassword, $confirmNewPassword);
                                    }
                                }
                            }
                            $main = new changePasswordUI();
                            $main->changePassword($data, $id, $uid,  $newPassword, $confirmNewPassword);
                        ?>
                        <form action="" method="post" name="changePassword">
                          <!--  <div class="form-group mb-3">
                                <label>Old Password:</label>
                                <input type="text" class="form-control" id="oldPassword" name="oldPassword" value="<?php echo $data->getPassword();?>" readonly>
                            </div>-->
                            <div class="form-group mb-3">
                                <label>New Password:</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword">
                            </div>
                            <div class="form-group mb-3">
                                <label>Confirm New Password:</label>
                                <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword">
                            </div>
                            <div class="form-group mb-3">
                                <button class="btn btn-primary" name="changePassword">Change Password</button>
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