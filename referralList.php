<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CRM System</title>
    <link rel="stylesheet" href="css/bootstrap5.css">
		<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="css/jquery-ui.css"> -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  </head>
  <body>
    <?php
    include("authentication.php");
    include("includes/authHeader.php");
    include("Controllers/externalReferralController.php");
    $con = new externalReferralController();

    if(isset($_POST['create'])) {
      $value = array();

      foreach($con->getField() as $val) {
        if($val != "referralId" && $val != "dateCreated" && $val != "timeCreated" && $val != "doctorId" && $val != "patientId") {
          $value[$val] = trim($_POST[$val]);
        }
      }

      $con->createReferral($value);
      echo "<meta http-equiv='refresh' content='0'>";
    }

    if(isset($_GET['link'])) {
      $_SESSION['referralId'] = $_GET['link'];
      header("Location: referralDetail.php");
    }
    ?>
    <div class="container">
      <h1>External referrals</h1>
      <div class="card text-center">
        <div class="card-header">
          <a class="btn btn-danger float-end" href="home.php" role="button">Back</a>
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item"><a href="#" data-bs-toggle="tab" data-bs-target="#nav-list" class="nav-link active">List</a></li>
            <li class="nav-item"><a href="#" data-bs-toggle="tab" data-bs-target="#nav-create" class="nav-link">Create</a></li>
            <!--<li class="nav-item"><a href="#" data-bs-toggle="tab" data-bs-target="#nav-import" class="nav-link">Import</a></li>-->
          </ul>
        </div>
      </div>

      <div class="tab-content border mb-3">
        <div class="tab-pane fade show active p-2" id="nav-list">
          <p><span id="quantity"></span> referrals</p>
          <div class="search-container my-1">
            <input type="search" name="searchBar" placeholder="Search" id="searchBar" oninput="search(this.value)">
            <label class="ms-2" for="searchType">Search by: </label>
            <select name="searchType" id="searchType" onchange="search(this.parentElement.firstElementChild.value)">
              <option selected>All</option>
              <option value="HealthCare organization">HealthCare organization</option>
              <option value="Referrer name">Referrer name</option>
              <option value="Doctor name">Doctor name</option>
              <option value="Patient name">Patient name</option>
              <option value="NRIC/Passport number">NRIC/Passport number</option>
              <option value="External referral date">External referral date</option>
            </select>
          </div>
          <table class="table table-striped" id="nav-list">
            <thead>
              <tr>
                <th>ID</th>
                <th>HealthCare Organization</th>
                <th>Referrer Name</th>
                <th>Doctor Name</th>
                <th>Patient Name</th>
                <th>NRIC/Passport number</th>
                <th>External referral date</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="results"></tbody>
            <tbody id="contents">
              <?php
              if(!empty($con->getReferralId())) {
                foreach ($con->getReferralId() as $val) {
                  echo "<tr class='listItem'>
                    <td>" . $val . "</td>
                    <td>" . $con->getReferrerOrganization($val) . "</td>
                    <td>" . $con->getReferrerName($val) . "</td>
                    <td>" . $con->getDoctorName($val) . "</td>
                    <td>" . $con->getPatientName($val) . "</td>
                    <td>" . $con->getPatientIdentityNumber($val) . "</td>
                    <td>" . $con->getReferralDate($val) . "</td>
                    <td><a href='?link=" . $val . "' class='btn btn-primary'>view</a></td>
                  </tr>";
                }
              }
              else {
                echo "<tr>
                <td align='center' colspan='8'>No record found</td>
                </tr>";
              }
              ?>
            </tbody>
          </table>
        </div>

        <div class="tab-pane fade" id="nav-create">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="my-2 p-2">
              <h5>Referral details</h5>
              <hr>
              <div class="form-group mb-4 mx-3">
                <label for="referralDate" class="form-label">Referral date </label>
                <div class="input-group mb-3">
                  <button class="btn btn-outline-secondary" type="button" id="clearReferralDate">Clear</button>
                  <input type="text" class="form-control" name="referralDate" id="referralDate" onkeydown="return false;" autocomplete="off">
                </div>
              </div>
              <div class="form-group mb-4 mx-3">
                <!-- <input type="hidden" name="doctorId"> -->
                <label for="doctorName" class="form-label">Doctor name</label>
                <input list="doctors" name="doctorName" class="form-control" autocomplete="off">
                <datalist id="doctors">
                  <?php
                    // get name of doctors
                    foreach ($con->getAllDoctorName() as $key => $val) {
                      echo "<option value='" . $val . "'>" . $val . "</option>";
                    }
                  ?>
                </datalist>
              </div>
              <div class="form-group mb-4 mx-3">
                <label for="reason" class="form-label">Reason</label>
                <textarea name="reason" class="d-block" rows="4" cols="60"></textarea>
              </div>
            </div>
            <hr>
            <div class="my-2 p-2">
              <h5>Patient details</h5>
              <hr>
              <div class="form-group mb-4 mx-3">
                <!-- <input type="hidden" name="patientId"> -->
                <label for="patientName" class="form-label">Patient's full name</label>
                <input list="patients" name="patientName" class="form-control" autocomplete="off">
                <datalist id="patients">
                  <?php
                    // get name of patient
                    foreach ($con->getAllPatientName() as $key => $val) {
                      echo "<option value='" . $val . "'>" . $val . "</option>";
                    }
                  ?>
                </datalist>
              </div>
              <div class="form-group mb-4 mx-3">
                <label for="patientIdentityNumber" class="form-label">NRIC/Passport number</label>
                <input type="text" name="patientIdentityNumber" class="form-control" autocomplete="off">
              </div>
              <div class="form-group mb-4 mx-3">
                <label for="patientSex" class="form-label">Sex</label>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="patientSex" id="gender" value="Male">Male
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="patientSex" id="gender" value="Female">Female
                  </label>
                </div>
              </div>
              <div class="form-group mb-4 mx-3">
                <label for="patientDateOfBirth" class="form-label">Date of birth</label>
                <div class="input-group mb-3">
                  <button class="btn btn-outline-secondary" type="button" id="clearDateOfBirth">Clear</button>
                  <input type="text" class="form-control" name="patientDateOfBirth" id="dateOfBirth" onkeydown="return false;" autocomplete="off">
                </div>
              </div>
              <div class="form-group mb-4 mx-3">
                <label for="patientPhoneNumber" class="form-label">Phone number</label>
                <input type="tel" name="patientPhoneNumber" class="form-control" autocomplete="off">
              </div>
              <div class="form-group mb-4 mx-3">
                <label for="patientEmailAddress" class="form-label">Email address</label>
                <input type="email" name="patientEmailAddress" class="form-control" autocomplete="off">
              </div>
              <div class="form-group mb-4 mx-3">
                <label for="patientAddress" class="form-label">Address</label>
                <input type="text" name="patientAddress" class="form-control" autocomplete="off">
              </div>
            </div>
            <hr>
            <div class="my-2 p-2">
              <h5>Referrer details</h5>
              <hr>
              <div class="form-group mb-4 mx-3">
                <label for="referrerName" class="form-label">Referrer's name</label>
                <input type="text" name="referrerName" class="form-control" autocomplete="off">
              </div>
              <div class="form-group mb-4 mx-3">
                <label for="referrerPhoneNumber" class="form-label">Phone number</label>
                <input type="tel" name="referrerPhoneNumber" class="form-control" autocomplete="off">
              </div>
              <div class="form-group mb-4 mx-3">
                <label for="referrerEmailAddress" class="form-label">Email address</label>
                <input type="email" name="referrerEmailAddress" class="form-control" autocomplete="off">
              </div>
              <div class="form-group mb-4 mx-3">
                <label for="referrerOrganization" class="form-label">Organization name</label>
                <input type="text" name="referrerOrganization" class="form-control" autocomplete="off">
              </div>
              <div class="form-group mb-4 mx-3">
                <label for="referrerAddress" class="form-label">Address</label>
                <input type="text" name="referrerAddress" class="form-control" autocomplete="off">
              </div>
            </div>
            <hr>
            <div class="m-3 d-flex justify-content-end">
              <input type="submit" name="create" class="btn btn-primary" value="Create">
            </div>
          </form>
        </div>

        <div class="tab-pane fade p-3" id="nav-import">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div style="border:2px dashed black; height:400px;" class="m-3"></div>
            <!--<div class="m-3 d-flex justify-content-end">-->
            <div class="m-3 d-flex align-items-end flex-column">
              <input type="file" name="file" class="form-control-file mb-4">
              <input type="submit" name="import" class="btn btn-primary mt-4" value="Import">
            </div>
          </form>
        </div>
      </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>

    <script type="text/javascript">
      const counter = document.getElementById("quantity");
      const items = document.getElementsByClassName("listItem");
      const itemsRes = document.getElementsByClassName("resultItem");
      counter.innerHTML = items.length;

      var dt = (new Date().getFullYear() - 100).toString() + ":" + (new Date().getFullYear()).toString();

      $(function() {
        $( "#referralDate" ).datepicker({
          yearRange: dt,
          changeYear: true,
        });

        $( "#dateOfBirth" ).datepicker({
          yearRange: dt,
          changeYear: true,
        });

        $("#clearReferralDate").click(function() {
          $("#referralDate").val("");
        });

        $("#clearDateOfBirth").click(function() {
          $("#dateOfBirth").val("");
        });
      });

      function search(term) {
        var type = $('#searchType').val();
        var data = [term, type];

        fetch('searchReferral.php', {
          method: 'post',
          body: new URLSearchParams('term=' + data)
        })
        .then(res => res.json())
        .then(res => output(res))
        .catch(e => console.error('Error: ' + e));
      }

      function output(data) {
  			if(!$('#searchBar').val()) {
  				$('#contents').show();
  				$('#results').empty();
          counter.innerHTML = items.length;
  			}
  			else {
  				$('#contents').hide();
  				$('#results').html(data);
          counter.innerHTML = itemsRes.length;
  			}
  		}
    </script>
    <script src="js/fontawesome.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap5.js"></script>
    <!-- <script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>
