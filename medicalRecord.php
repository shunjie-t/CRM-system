<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CRM System</title>
    <link rel="stylesheet" href="css/bootstrap5.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
  </head>
  <body>
    <?php
    include("authentication.php");
    include("includes/authHeader.php");
    include("Controllers/medicalRecordController.php");
    include("Controllers/patientProfileController.php");

    $uid = $_SESSION["userId"];
    $pid = $_SESSION["patientId"];
    $MRcon = new medicalRecordController();
    $Pcon = new patientProfileController();

    if(!in_array($pid, $MRcon->getPatientId())) {
      $MRcon->createMedicalRecord($pid);
      echo "<meta http-equiv='refresh' content='0'>";
    }

    $mrid = array_search($pid, $MRcon->getPatientId());
    $values = [2 => $MRcon->getWeight($mrid), 3 => $MRcon->getHeight($mrid), 4 => $MRcon->getBmi($mrid),
    5 => $MRcon->getAllergy($mrid), 6 => $MRcon->getBloodPressure($mrid), 7 => $MRcon->getBloodGlucose($mrid),
    8 => $MRcon->getCholesterol($mrid), 9 => $MRcon->getImmunization($mrid), 10 => $MRcon->getMedication($mrid),
    11 => $MRcon->getMedicalHistory($mrid), 12 => $MRcon->getMedicalCondition($mrid)];

    $oldVal= array();
    $newVal = array();
    $reason = array();

    if(isset($_POST['submit-multiple'])) {
      $oldVal = $MRcon->getRecord($mrid);
      unset($oldVal['medicalRecordId']);
      unset($oldVal['patientId']);
      unset($oldVal['bmi']);

      $fldArr = $MRcon->getField(false);
      unset($fldArr[0]);
      unset($fldArr[1]);
      unset($fldArr[4]);
      $fldArr = array_values($fldArr);

      for($a = 0; $a < count($fldArr); $a++) {
        $newVal[$fldArr[$a]] = trim($_POST['value'][$a]);
        $reason[$fldArr[$a]] = trim($_POST['reason'][$a]);
      }

      $MRcon->updateMedicalRecord($mrid,0,$oldVal,$newVal,$reason);
      echo "<meta http-equiv='refresh' content='0'>";
    }
    else if(isset($_POST['submit-single'])) {
      $val = $MRcon->getRecord($mrid)[$_POST['hiddenFld']];
      $key = $_POST['hiddenFld'];

      $oldVal[$key] = $val;
      $newVal[$key] = trim($_POST['value']);
      $reason[$key] = trim($_POST['reason']);

      $MRcon->updateMedicalRecord($mrid,0,$oldVal,$newVal,$reason);
      echo "<meta http-equiv='refresh' content='0'>";
    }

    /*if(!isset($_SESSION["patientId"])) {
      header('Location: patientProfile.php');
    }
    else {
      $uid = $_SESSION["userId"];
      $pid = $_SESSION["patientId"];
      $MRcon = new medicalRecordController();
      $Pcon = new patientProfileController();

      if(!in_array($pid, $MRcon->getPatientId())) {
        $MRcon->createMedicalRecord($pid);
        echo "<meta http-equiv='refresh' content='0'>";
      }

      $mrid = array_search($pid, $MRcon->getPatientId());
      $values = [2 => $MRcon->getWeight($mrid), 3 => $MRcon->getHeight($mrid), 4 => $MRcon->getBmi($mrid),
      5 => $MRcon->getAllergy($mrid), 6 => $MRcon->getBloodPressure($mrid), 7 => $MRcon->getBloodGlucose($mrid),
      8 => $MRcon->getCholesterol($mrid), 9 => $MRcon->getImmunization($mrid), 10 => $MRcon->getMedication($mrid),
      11 => $MRcon->getMedicalHistory($mrid), 12 => $MRcon->getMedicalCondition($mrid)];
    }*/
    ?>
    <div class="container">
      <div class="row border p-3 my-2">
        <div class="d-flex justify-content-end mb-1">
          <a class="btn btn-danger mx-2" href="detailMenu.php" role="button">Back</a>
        </div>
        <h1>Patient details</h1>
        <div class="col-6 p-3">
          <h5>Name</h5>
          <span class="lead" style="margin:0 10px;"><?php echo $Pcon->getName($uid); ?></span>
        </div>
        <div class="col-6 p-3">
          <h5>NRIC/Passport number</h5>
          <span class="lead" style="margin:0 10px;"><?php echo $Pcon->getIdentityNumber($uid); ?></span>
        </div>
        <div class="col-6 p-3">
          <h5>Date of birth</h5>
          <span class="lead" style="margin:0 10px;"><?php echo $Pcon->getDateOfBirth($uid); ?></span>
        </div>
        <div class="col-6 p-3">
          <h5>Sex</h5>
          <span class="lead" style="margin:0 10px;"><?php echo $Pcon->getSex($uid); ?></span>
        </div>
        <div class="col-6 p-3">
          <h5>Phone number</h5>
          <span class="lead" style="margin:0 10px;"><?php echo $Pcon->getPhoneNumber($uid); ?></span>
        </div>
        <div class="col-6 p-3">
          <h5>Email address</h5>
          <span class="lead" style="margin:0 10px;"><?php echo $Pcon->getEmailAddress($uid); ?></span>
        </div>
      </div>

      <div class="card text-center">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item"><a href="#" data-bs-toggle="tab" data-bs-target="#nav-list" class="nav-link active">List</a></li>
            <li class="nav-item"><a href="#" data-bs-toggle="tab" data-bs-target="#nav-editAll" class="nav-link">Edit all</a></li>
          </ul>
        </div>
      </div>

      <div class="tab-content border mb-3">
        <div class="tab-pane fade show active p-2" id="nav-list">
          <div class="p-3">
            <div class="mb-4">
              <h1 class="me-auto">Medical records</h1>
            </div>
            <?php
            for($a = 2; $a < count($MRcon->getField()); $a++) {
              echo "<div class='item border p-3'>
                <h5 id='" . $MRcon->getField(false)[$a] . "'>" . $MRcon->getField()[$a] . "</h5>
                <span class='lead' style='margin:0 10px;'>" . $values[$a] . "</span>";
                if($MRcon->getField()[$a] == "Weight") echo "<span class='lead'>kg</span>";
                else if($MRcon->getField()[$a] == "Height") echo "<span class='lead'>cm</span>";
                else if($MRcon->getField()[$a] == "Blood Pressure") echo "<span class='lead'>mmHg</span>";
                else if($MRcon->getField()[$a] == "Blood Glucose") echo "<span class='lead'>mmol/L</span>";
                else if($MRcon->getField()[$a] == "Cholesterol") echo "<span class='lead'>mg/dL</span>";
                echo "<button type='button' class='edit btn btn-outline-secondary float-end' data-bs-toggle='modal' data-bs-target='#myModal'>
                Edit <img src='images/edit.svg'>
                </button>
              </div>";
            }
            ?>
          </div>
        </div>
        <div class="tab-pane fade" id="nav-editAll">
          <div class="p-3">
            <h1 class="me-auto">Edit all records</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
              <?php
              for($a = 2; $a < count($MRcon->getField()); $a++) {
                if($MRcon->getField()[$a] == "Weight") {
                  echo "<div class='mb-3'>
                  <label for='value[]'>" . $MRcon->getField()[$a] . "</label>
                  <input type='number' name='value[]' placeholder='" . $values[$a] . "' class='d-block' min='1' max='600' step='0.5' required>";
                  if($values[$a] != "-") {
                    echo "<label for='reason[]'>Reason of amendment</label>
                    <textarea name='reason[]' rows='8' cols='80' class='d-block' required></textarea>";
                  }
                  echo "</div>";
                }
                else if($MRcon->getField()[$a] == "Height") {
                  echo "<div class='mb-3'>
                  <label for='value[]'>" . $MRcon->getField()[$a] . "</label>
                  <input type='number' name='value[]' placeholder='" . $values[$a] . "' class='d-block' min='20' max='300' step='1' required>";
                  if($values[$a] != "-") {
                    echo "<label for='reason[]'>Reason of amendment</label>
                    <textarea name='reason[]' rows='8' cols='80' class='d-block' required></textarea>";
                  }
                  echo "</div>";
                }
                else if($MRcon->getField()[$a] == "Blood pressure" || $MRcon->getField()[$a] == "Blood glucose" || $MRcon->getField()[$a] == "Cholesterol") {
                  echo "<div class='mb-3'>
                  <label for='value[]'>" . $MRcon->getField()[$a] . "</label>
                  <input type='number' name='value[]' placeholder='" . $values[$a] . "' class='d-block' min='10' max='300' step='1' required>";
                  if($values[$a] != "-") {
                    echo "<label for='reason[]'>Reason of amendment</label>
                    <textarea name='reason[]' rows='8' cols='80' class='d-block' required></textarea>";
                  }
                  echo "</div>";
                }
                else if($MRcon->getField()[$a] != "Bmi") {
                  echo "<div class='mb-3'>
                  <label for='value[]'>" . $MRcon->getField()[$a] . "</label>
                  <input type='text' name='value[]' placeholder='" . $values[$a] . "' class='d-block' required>";
                  if($values[$a] != "-") {
                    echo "<label for='reason[]'>Reason of amendment</label>
                    <textarea name='reason[]' rows='8' cols='80' class='d-block' required></textarea>";
                  }
                  echo "</div>";
                }
              }
              ?>
              <div class="d-flex justify-content-end mt-3">
                <input type="submit" name="submit-multiple" value="Submit" class="btn btn-primary">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modal Header</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
              <div class="modal-body modal-dialog-scrollable">
                  <div>
                    <input type="hidden" name="hiddenFld" id="hiddenFld">
                    <label for="value" class="valueLbl"></label>
                    <input type="text" name="value" class="valueFld d-block">
                    <label for="reason" class="reasonLbl">Reason of amendment</label>
                    <textarea type="text" name="reason" class="reasonFld" rows="4" cols="40"></textarea>
                  </div>
              </div>
              <div class="modal-footer">
                <input type="submit" name="submit-single" value="Submit" class="btn btn-primary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
        </div>
      </div>
    </div>

    <script type="text/javascript">
    var fld = "", val = "";
    const item = document.querySelectorAll(".items");

    document.querySelectorAll(".edit").forEach(btn => {
      btn.addEventListener("click", event => {
        const mFld = document.getElementsByClassName("multiValFld");
        const mVRea = document.getElementsByClassName("multiValRea");

        const valueFld = document.getElementsByClassName("valueFld");
        const reasonLbl = document.getElementsByClassName("reasonLbl");
        const reasonFld = document.getElementsByClassName("reasonFld");
        fld = btn.parentElement.firstElementChild.innerHTML;
        val = btn.parentElement.children[1].innerHTML;
        valueFld[0].required = true;

        if(val == "-") {
          reasonLbl[0].style.display = "none";
          reasonFld[0].style.display = "none";
          reasonFld[0].required = false;
        }
        else {
          reasonLbl[0].style.display = "block";
          reasonFld[0].style.display = "block";
          reasonFld[0].required = true;
        }

        document.getElementById("hiddenFld").value = btn.parentElement.firstElementChild.id;
        document.getElementsByClassName("modal-title")[0].innerHTML = 'Edit ' + fld.toLowerCase();
        document.getElementsByClassName("valueLbl")[0].innerHTML = fld;
        document.getElementsByClassName("valueFld")[0].setAttribute("placeholder", val);

        if(fld == "Weight") {
          valueFld[0].type = "number";
          valueFld[0].min = "1";
          valueFld[0].max = "600";
          valueFld[0].step = "0.5";
        }
        else if(fld == "Height") {
          valueFld[0].type = "number";
          valueFld[0].min = "20";
          valueFld[0].max = "300";
          valueFld[0].step = "1";
        }
        else if(fld == "Blood pressure" || fld == "Blood glucose" || fld == "Cholesterol") {
          valueFld[0].type = "number";
          valueFld[0].min = "10";
          valueFld[0].max = "300";
          valueFld[0].step = "1";
        }
        else {
          valueFld[0].type = "text";
        }
      })
    });
    </script>
    <script src="js/fontawesome.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap5.js"></script>
    <!-- <script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>
