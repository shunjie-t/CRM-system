<?php $id = $_GET['id'];?>

<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Referral</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    
   
    <?php
      date_default_timezone_set ('Asia/Singapore');
      $timezone = date_default_timezone_get();
      include("Controllers/userController.php");
      $namePatient = new userController();
      $doctor = new Doctors();
    ?>
    <?php
       if(isset($_POST['department']))
           {
            //include("Controllers/userController.php");
            //$namePatient = new userController();
            $getDepartmentDoctor = $_POST['department'];                                  
            $namePatient->getToDoctorNames($getDepartmentDoctor);
            exit;       
           }?>
</head>

<body>
<div id = "response"></div>
<?php
    include("authentication.php");
    include("includes/authHeader.php");
    include("Controllers/referralController.php");
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                    if(isset($_SESSION['status'])) 
                    {
                        echo "<h5 class='alert alert-success'>".$_SESSION['status']."</h5>";
                        unset($_SESSION['status']);
                    }
                    
                    $user = $auth->getUser($_SESSION['uid']);
                    $name=$user->displayName;

                    $namePatient->displayDoctorID($name);
                    $doctorID = $namePatient -> getDoctorID();

                    $namePatient->getDoctorDepartment($doctorID);
                    $departmentOfDoctor = $namePatient->getDepartment();
                    
                   
                    
                ?>
                <div class="card">
                    <div class="card-header">
                        <h4>Add Referral
                            <a href="home.php" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <form action="" method="post">
                    <?php
                   

                     $i = 1;
                     if(isset($_POST['submit']))
                     {
                         $control = new referralController();

                         $ref= "referral/";
                         $total = $database->getReference($ref)->getSnapshot()->numChildren();
                         

                         $increment =  $total + 1;
                         $rid = $increment;
                         $referralBy = $_POST['referralBy'];
                         $referralTo = $_POST['referralTo'];  
                         $byID = $doctorID;
                         $date = $_POST['date'];
                     
                         $fromDepartment = $_POST['fromDepartment'];
                         $toDepartment = $_POST['toDepartment'];
                         $referralType = $_POST['referralType'];
                         $urgency = $_POST['urgency'];
                         $patientName = $_POST['patientName'];   

                         $namePatient->displayDoctorID($referralTo);
                         $idofReferral = $namePatient->getDoctorID(); 
                         $control-> validateReferral($rid, $byID, $idofReferral, $referralBy, $referralTo, $date, $fromDepartment, $toDepartment, $referralType, $urgency, $patientName);   
                    }
                    ?>

                    <div class="form-group mb-3">
							<label>Referral By: </label>
							<input type="text" readonly class="form-control" value="<?php echo $name?>" name="referralBy" id="referralBy">
						</div>
                        <div class="form-group mb-3">
	
						<div class="form-group mb-3">
							<label>Referred Date: </label>
							<input type="text" readonly value="<?php echo date("Y-m-d");?>" class="form-control" name="date" id="date">
                        </div>
                        <div class="form-group mb-3">
                            <label>From Department: </label>
                            <input type="text" class="form-control" readonly value="<?php echo $departmentOfDoctor ?>" name="fromDepartment" id="fromDepartment">
                        </div>
                        <div class="form-group mb-3">
                            <div class="col">
                                <label for="departmentLabel" class="form-label">To Department: </label>
                                <select name="toDepartment" id="toDepartment" class="input-field">
                                    <option value="Cardiology">  Cardiology </option>
                                    <option value="Orthopaedic">  Orthopaedic </option>
                                    <option value="Dermatology">  Dermatology </option>
                                    <option value="Paediatric">  Paediatric </option>
                                    <option value="Neurology">  Neurology </option>                    
                                </select>
                            </div>
                        </div>
                
                        <div class="form-group mb-3">
							<label>Referral To: </label>   
                            
                        <select name ="referralTo" class ="form-label" id ="referralTo">                            
                           
                        </select>
                        </div>

                        <div class="form-group mb-3">
							<label>Referral Type: </label>
							<input type="text" class="form-control" name="referralType" id="referralType">
                        </div>
                        <div class="form-group mb-3">
							<label>Urgency: </label>
							<input type="text" class="form-control" name="urgency" id="urgency" >
                        </div>
                        <div class="form-group mb-3">
							<label>Patient Name: </label>
                            <select id="patientName" name="patientName" class="input-field">    
                                <?php
                                    $namePatient->displaymyPatientName($doctorID);
                                ?>
                            </select>
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

 

<script type="text/javascript">
        $(document).ready(function(){
            $("#toDepartment").change(function()
            {       
                 var html_code = '';
                 var department = $("#toDepartment").val();
            $.ajax({
                type: 'post',
                data: {department:department},
                dataType:"text",
                success:function(response)
                {
                    //html_code += '<option value=""> Select A Doctor </option>';
                    //html_code += '<option value='+response+'>'+response+'</option>"';
                    $('#referralTo').html(response);
                   
                   //.append("<option value='"+response+"'>"+response+"</option>");     
                }
            });
            });
        });
 </script>
</body>
</html>