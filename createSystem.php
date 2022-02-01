<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create System Administrator</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        session_start();
        include ('dbcon.php');
        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            $identityNumber = $_POST['identityNumber'];
            $password = $_POST['password'];
            $fname = $_POST['fname'];
            $phone = $_POST['phone'];
            $officeNo = $_POST['officeNo'];
            $role = $_POST['role'];

            $data= [
                'emailAddress' => $email,
                'identityNumber' => $identityNumber,
                'password' => $password,
                'name' => $fname,
                'phoneNumber' => '+65'.$phone,
                'officeNumber' => $officeNo,
                'role' => $role,
                'userId' => '6',
                'accountStatus' => 'Activated'
            ];


            $ref_table = "user";
            $postRef = $database->getReference($ref_table)->push($data);

			if($postRef){
				$_SESSION['status'] = "User Created Successfully";
				header("location: createSystem.php");
				exit();
			} else{
				$_SESSION['status'] = "User Not Created";
				header("location: createSystem.php");
				exit();
			}

        }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                    if(isset($_SESSION['status'])) {
                        echo "<h5 class='alert alert-success'>".$_SESSION['status']."</h5>";
                        unset($_SESSION['status']);
                    }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h4>Add Users
                            <a href="index.php" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <form action="createSystem.php" method="post">
						<div class="form-group mb-3">
							<label>Email: </label>
							<input type="email" class="form-control" name="email" id="email">
						</div>
                        <div class="form-group mb-3">
							<label>Identity Number: </label>
							<input type="text" class="form-control" name="identityNumber" id="identityNumber">
                        </div>
						<div class="form-group mb-3">
							<label>Password: </label>
							<input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group mb-3">
							<label>Name: </label>
							<input type="text" class="form-control" name="fname" id="fname">
                        </div>
                        <div class="form-group mb-3">
							<label>Phone: </label>
							<input type="text" class="form-control" name="phone" id="phone">
                        </div>
                        <div class="form-group mb-3">
							<label>Office Number: </label>
							<input type="text" class="form-control" name="officeNo" id="officeNo">
                        </div>
                        <div class="form-group mb-3">
							<label>Role: </label>
							<input type="text" class="form-control" name="role" id="role" value="system administrator" readonly>
                        </div>
						<div class="form-group mb-3">
                            <button type="submit" name="submit" class="btn btn-primary">submit</button>
                        </div>
                    
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>