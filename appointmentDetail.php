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
    include("Controllers/appointmentController.php");
    $con = new appointmentController();
    $con->setAttributeArray();

    $aid = intval($_SESSION['appointmentId']);

    if(isset($_POST['cancelAppt'])) {
      $con->cancelAppointment($aid, false);
    }

    if(isset($_POST['markAppt'])) {
      $con->markAppointment($aid, false);
    }

    if(isset($_POST['next'])) {
      $_SESSION['sdate'] = $_POST['sdate'];
      header('Location: rescheduleAppointmentMA.php');
    }
    ?>
    <div class="container my-3">
      <div class="card">
        <div class="card-header">
          <h1>Appointment detail</h1>
          <div class="d-flex justify-content-end mb-1">
            <?php
            if($con->getAppointmentStatus($aid) == "Ongoing") {
              echo "<button type='button' class='btn btn-primary mx-1' data-bs-toggle='modal' data-bs-target='#cancelModal'>Cancel appoinment</button>
              <button type='button' class='btn btn-primary mx-1'  data-bs-toggle='modal' data-bs-target='#markModal'>Verify attendance</button>
              <button type='button' id='reschedule' name='button' class='btn btn-primary mx-1'>Reschedule appointment</button>";

              /*echo "<form action='#' method='post'>
                <input type='submit' name='cancelAppt' class='btn btn-primary mx-1' value='Cancel appoinment'>
                <input type='submit' name='markAppt' class='btn btn-primary mx-1' value='Mark attendance'>
              </form>
              <button type='button' id='reschedule' name='button' class='btn btn-primary mx-1'>Reschedule appointment</button>";*/
            }
            ?>
            <a class="btn btn-danger mx-2" href="appointmentOverview.php" role="button">Back</a>
          </div>
        </div>
        <div class="card-body">
          <div class="row p-2">
            <div class="col-6 appt-item">
              <h4>Appointment number</h4>
              <h5 class="lead" id="aid"><?php echo $aid; ?></h5>
            </div>
            <div class="col-6 appt-item">
              <h4>Patient name</h4>
              <h5 class="lead"><?php echo $con->getPatientName($aid); ?></h5>
            </div>
            <div class="col-6 appt-item">
              <h4>Appointment notes</h4>
              <h5 class="lead"><?php echo $con->getNotes($aid); ?></h5>
            </div>
            <div class="col-6 appt-item">
              <h4>Venue</h4>
              <h5 class="lead"><?php echo $con->getVenue($aid); ?></h5>
            </div>
            <div class="col-6 appt-item">
              <h4>Attendence</h4>
              <h5 class="lead"><?php echo $con->getAppointmentStatus($aid); ?></h5>
            </div>
            <div class="col-6 appt-item">
              <h4>Date</h4>
              <h5 class="lead"><?php echo $con->getStartDate($aid); ?></h5>
            </div>
            <div class="col-6 appt-item">
              <h4>Start time</h4>
              <h5 class="lead"><?php echo $con->getStartTime($aid); ?></h5>
            </div>
            <div class="col-6 appt-item">
              <h4>End time</h4>
              <h5 class="lead"><?php echo $con->getEndTime($aid); ?></h5>
            </div>
          </div>

          <hr id="sep" style="display:none;">

          <div id="form" class="p-2" style="display:none;">
            <form action="#" method="post">
  						<div class="form-group mb-3">
  							<label>Title: </label>
  							<input type="text" class="form-control" name="title" id="title" value="<?php echo $con->getTitle($aid);?>" readonly>
              </div>
              <div class="form-group mb-3">
                <label>Doctor Name: </label>
                <input list="doctors" class="form-control" name="dname" id="dname" value="<?php echo $con->getDoctorName($aid);?>" readonly>
              </div>
              <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label><strong>Original Date of Appointment:</strong></label>
                    <input type="text" readonly class="form-control" value="<?php echo $con->getStartDate($aid);?>">
                  </div>
                </div>
                <div class="col">
                  <div class="mb-3">
                    <label><strong>Appointment Time:</strong></label>
                    <input type="text" readonly class="form-control" value="<?php echo $con->getStartTime($aid);?>">
                  </div>
                </div>
              </div>
              <div class="form-group">
  							<label>Date: </label>
                <div class="input-group mb-3">
                  <button class="btn btn-outline-secondary" type="button" id="clearDate">Clear</button>
                  <input type="text" class="form-control" name="sdate" id="datepicker" onkeydown="return false;" autocomplete="off" required>
                </div>
              </div>
              <div class="form-group my-2 d-flex justify-content-end">
                <button type="button" name="cancel" class="btn btn-secondary me-2" id="cnlReschedule">Cancel</button>
                <input type="submit" name="next" class="btn btn-primary" value="Next">
              </div>
           </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Cancel appointment modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirmation</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
              <div class="modal-body modal-dialog-scrollable">
                <h6>Cancel this appointment?</h6>
              </div>
              <div class="modal-footer">
                <input type="submit" name="cancelAppt" value="Yes" class="btn btn-primary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              </div>
            </form>
        </div>
      </div>
    </div>

    <!-- Mark attendance modal -->
    <div class="modal fade" id="markModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirmation</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
              <div class="modal-body modal-dialog-scrollable">
                <h6>Mark attendance as present?</h6>
              </div>
              <div class="modal-footer">
                <input type="submit" name="markAppt" value="Yes" class="btn btn-primary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              </div>
            </form>
        </div>
      </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>

    <script type="text/javascript">
      var dt = (new Date().getFullYear()).toString() + ":" + (new Date().getFullYear() + 10).toString();
      var formHidden = true;

      $(function() {
        $( "#datepicker" ).datepicker({
          yearRange: dt,
          changeYear: true,
          numberOfMonths: 2,
          minDate: new Date()
        });

        $("#clearDate").click(function() {
          $("#datepicker").val("");
        });

        $("#reschedule").click(function() {
          if(formHidden) {
            $("#sep").show();
            $("#form").show();
            formHidden = false;
          }
          else {
            $("#sep").hide();
            $("#form").hide();
            formHidden = true;
          }
        });

        $("#cnlReschedule").click(function() {
          $('#sep').hide();
          $('#form').hide();
        });
      });
    </script>
    <!-- <script src="js/fontawesome.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap5.js"></script> -->
    <script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>
