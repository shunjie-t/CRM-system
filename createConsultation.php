<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Consultation</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <?php
      date_default_timezone_set ('Asia/Singapore');
      $timezone = date_default_timezone_get();
    ?>
</head>
<body>

    <?php
    include("authentication.php");
    include("includes/authHeader.php");
    include("Controllers/consultationController.php");                                                  	
    $user = $auth->getUser($_SESSION['uid']);
    $name=$user->displayName;
    $control = new consultationController();
    $id = $_GET['id'];
    $startdatetime = $_GET['startDate'];
    $date = $_SESSION['startDate'];
    $time = $_SESSION['time'];
    $purpose =  $_SESSION['title'];
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
                        <h4>Add New Consultation For Appointment
                            <a href="home.php" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <form action="" method="post">
                    <?php                 
                            $control->getPatientDetails($id);        
                            $i = 1;
                            if(isset($_POST['submit']))
                            {
                                $ref= "consultation/";
                                $total = $database->getReference($ref)->getSnapshot()->numChildren();
                                $increment =  $total + 1;

                                $consultationId = $increment;
                                $patientName = $_POST['patientName'];
                                $nric = $_POST['nric'];
                                $date = $_POST['date'];
                                $time = $_POST['time'];
                                $doctorName = $_POST['doctorName'];
                                $reason = $_POST['reason'];
                                $diagnosis = $_POST['diagnosis'];
                                $prescription = $_POST['prescription'];
                                $notes = $_POST['notes'];

                                $control-> validateConsultation($consultationId, $nric, $patientName, $date, $time, $doctorName, $reason, $diagnosis, $prescription, $notes);
                            }
                      ?>


						<div class="form-group mb-3">
							<label>Name: </label>
							<input type="text" class="form-control" value="<?php echo $control->getPatientName()?>" name="patientName" id="patientName" readonly>
						</div>
                        <div class="form-group mb-3">
                            <?php
                                $nric = $control->getNRIC();
                                $maskedNRIC = substr($nric,0,1).str_repeat('*',4).substr($nric,5,4);
                            ?>
							<label>Identity Number: </label>
                            <input type="hidden" class="form-control" value="<?php echo $control->getNRIC()?>" name="nric" id="nric" readonly>
							<input type="text" class="form-control" value="<?php echo $maskedNRIC?>" name="masked" id="masked" readonly>
                        </div>
						<div class="form-group mb-3">
							<label>Date: </label>
							<input type="text"  readonly class="form-control" value="<?php echo $date;?>" name="date" id="date">
                        </div>
                        <div class="form-group mb-3">
							<label>Time Slot: </label>
							<input type="text" readonly class="form-control" value="<?php echo $time;?>"name="time" id="time">
                        </div>
                        <div class="form-group mb-3">
							<label>Doctor Name: </label>
							<input type="text" readonly class="form-control" value="<?php echo $name ?>" name="doctorName" id="doctorName">
                        </div>
                        <div class="form-group mb-3">
							<label>Purpose Of Visit: </label>
							<input type="text" readonly class="form-control" value="<?php echo $purpose;?>"name="reason" id="reason">
                        </div>
                        <div class="form-group mb-3">
							<label>Diagnosis: </label>
                            <textarea name="diagnosis" id="diagnosis" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
							<label>Prescription: </label>
                            <textarea name="prescription" id="prescription" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
							<label>Notes: </label>
							<textarea name="notes" id="notes" cols="30" rows="10" class="form-control"></textarea>
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