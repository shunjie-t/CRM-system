<?php
    include("authentication.php");
	include("Controllers/userController.php");
    $users = new userController();
    $user = $auth->getUser($_SESSION['uid']);
    $email = $user->email;
?>
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
        $users->getUserByEmail($email);
        $phone = $users->getPhone();
        $maskedPhone = str_repeat('*',4).substr($phone,4,4);
    ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6>Verification</h6>
                </div>
                <div class="card-body">
                    <form>
                        <input type="text" readonly class="form-control" id="phone" name="phone" value="<?=$phone;?>">
                        <div id="recaptcha-container"></div>
                        <button class="btn btn-primary" onclick="phoneAuth();">Send OTP</button>
                    </form>
                    <p>Enter the 6-digit One-Time Password(OTP) sent to your phone(<?=$maskedPhone;?>)</p>
                    <form>
                        <input type="text" class="form-control" id="verficationCode" name="verficationCode" placeholder="Enter Verifcation Code">
                        <button class="btn btn-primary" onclick="codeVerify();">Submit</button>
                    </form>
                    <p>If you do not receive an OTP on your mobile device within 30 seconds, plick click on the "Resend OTP" button here:</p>
                    <form>
                        <button class="btn btn-primary" onclick="resendOTP();">Resend OTP</button>
                    </form>
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
    <script src="js/verification.js" type="text/javascript"></script>
</body>
</html>