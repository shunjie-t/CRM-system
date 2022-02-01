<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include("includes/header.php");
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Patient Registration
                            <a href="login.php" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <form action="" method="post" autocomplete="off">
                        <?php
                            require_once('dbcon.php');
                            include("Controllers/loginController.php");
                            $register = new loginController();
                            $fname=$nric=$gender=$email=$password=$confirmPassword=$dob=$phone=$country=$emergencyContact=$emergencyName=$relationship=$role="";
                            $ref_table1 = "user/";
                            $ref_table2 = "patients/";
                            $ref_table3 = "medicalRecords/";
                            $count1 = $database->getReference($ref_table1)->getSnapshot()->numChildren();
                            $count2 = $database->getReference($ref_table2)->getSnapshot()->numChildren();
                            $count3 = $database->getReference($ref_table3)->getSnapshot()->numChildren();
                            $increment1 = $count1 + 1;
                            $increment2 = $count2 + 1;
                            $increment3 = $count3 + 1;
                            class registerUI{
                                public function checkRegister($register,$increment1, $increment2, $increment3, $fname,$nric,$gender,$email,$password,$confirmPassword,$dob,$phone,$country,$emergencyContact,$emergencyName,$relationship,$role){
                                    if(isset($_POST["submit"])) {
                                        $uid = $increment1;
                                        $pid = $increment2;
                                        $rid = $increment3;
                                        $fname= $_POST['fname'];
                                        $nric=$_POST['nric'];
                                        $gender=$_POST['gender'];
                                        $email= $_POST['email'];
                                        $password=$_POST['password'];
                                        $confirmPassword=$_POST['confirmPassword'];
                                        $dob=$_POST['dob'];
                                        $phone=$_POST['phone'];
                                        $country=$_POST['country'];
                                        $emergencyContact= $_POST['emergencyContact'];
                                        $emergencyName = $_POST['emergencyName'];
                                        $relationship=$_POST['relationship'];
                                        $role=$_POST['role'];

                                        $register->validateRegister($uid, $pid, $rid, $fname,$nric,$gender,$email,$password,$confirmPassword,$dob,$phone,$country,$emergencyContact,$emergencyName,$relationship,$role);
                                    }
                                }
                            }

                            $main = new registerUI();
                            $main->checkRegister($register, $increment1, $increment2, $increment3, $fname,$nric,$gender,$email,$password,$confirmPassword,$dob,$phone,$country,$emergencyContact,$emergencyName,$relationship,$role);
                        ?>
						<div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label>Name: </label>
                                    <input type="text" class="form-control" name="fname" id="name">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label>NRIC: </label>
                                    <input type="text" class="form-control" name="nric" id="nric">
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label>Email: </label>
                                    <input type="text" class="form-control" name="email" id="email">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label>Password: </label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label>Confirm Password: </label>
                                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label>Date Of Birth: </label>
                                    <input type="date" class="form-control" name="dob" id="dob" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label>Contact Number: </label>
                                    <input type="text" class="form-control" name="phone" id="phone" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label>Country of Residence: </label>
                                    <input type="text" class="form-control" name="country" id="country" required>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label>Emergency Contact: </label>
                                    <input type="text" class="form-control" name="emergencyContact" id="emergencyContact">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label>Name of Emergency Contact Person: </label>
                                    <input type="text" class="form-control" name="emergencyName" id="emergencyName">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label>Relationship to Patient: </label>
                                    <select class="form-select" aria-label="Default select example" name="relationship" id="relationship">
                                        <option value="Son">Son</option>
                                        <option value="Daughter">Daughter</option>
                                        <option value="Mother">Mother</option>
                                        <option value="Father">Father</option>
                                        <option value="Siblings">Siblings</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group mb-3">
							<label>Role: </label>
							<input type="text" class="form-control" name="role" id="role" value="patient" readonly>
                        </div>
						<div class="form-group mb-3">
                            <button type="submit" name="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>