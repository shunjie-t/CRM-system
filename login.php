<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRM System</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION['verified_user_id'])){
            $_SESSION['status'] = "You have logged on to the system";
		    header("Location: home.php");
			exit();
        }
    ?>
    <?php include("includes/header.php"); ?>
    <div class="container">
        <div class="row justify-content-center">
            <?php
                if(isset($_SESSION['status'])){
                    echo "<h5 class='alert alert-success'>".$_SESSION['status']."</h5>";
                    unset($_SESSION['status']);
                }
            ?>
            <div class="card">
                <div class="card-header">
                    <h3> Login Here
                        <a href="index.php" class="btn btn-danger float-end">Back</a>                
                    </h3>
                </div>
                <div class="card-body">
                    <form action="login.php" method="post" autocomplete="off">
                        <?php
                            include("Controllers/loginController.php");
                            $email=$password="";
                            $errors = array();
                            class loginUI {
                                public function loginValidate($email, $password){
                                    $loginItem= new loginController();
                                    if(isset($_POST["login"])) {
                                        $email= $_POST['email'];
                                        $password=$_POST['password'];
                                        $loginItem->validateUser($email, $password);
                                    }
                                    if(isset($_POST["register"])) {
                                        header("Location: register.php");
                                    }
                                }	
                            }
                            $login = new loginUI();
                            $login->loginValidate($email, $password);
                        ?>
                        <div class="form-group mb-3">
                            <label>Email: </label>
							<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email address">
                        </div>
                        <div class="form-group mb-3">
                            <label>Password: </label>
							<input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password">
                            <i class="fa fa-eye" aria-hidden="true"  type="button" id="eye"></i>
                        </div>
                        <div class="form-group mb-3">
                            <button class="btn btn-primary" type="submit" name="login">Login</button>
                            <button class="btn btn-secondary" type="submit" name="register">Register Patient Account</button>
                        </div>
                        <div class="form-group mb-3">
                            <a href="forgetPassword.php" class="form-control" style="font-style: italic; color: black;">Forget Password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/togglePassword.js"></script>
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