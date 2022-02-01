<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CRM System</title>
    <link rel="stylesheet" href="css/bootstrap5.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/jquery-ui.css">
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
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

    if(isset($_POST['changeAppt'])) {
      $ndate = $_POST['sdate'];
      $ntime = $_POST['stime'];
      $con->rescheduleAppointment($aid,$ndate,$ntime,$ntime,false);
    }
    ?>
    <div class="container my-3">
      <div class="card">
        <div class="card-header">
          <h1>Reschedule appointment</h1>
          <div class="d-flex justify-content-end mb-1">
            <a class="btn btn-danger mx-2" href="appointmentDetail.php" role="button">Back</a>
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

          <hr>

          <div id="form" class="p-2">
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
              <div class="form-group mb-3">
  							<label>Date: </label>
                <?php echo "<input type='text' class='form-control' name='sdate' id='sdate' autocomplete='off' readonly required value='" . $_SESSION['sdate'] . "'>" ?>
              </div>
              <div class="form-group mb-5" id="startTime">
                <label>Start Time: </label>
                <div class="btn-group d-block my-2" role="group">
                  <div class="row g-3">
                    <?php
                    $timeslot = $con->getTimeslot($_SESSION['sdate'], $con->getDoctorId($aid));
                    if(!empty($timeslot)) {
                      foreach($timeslot as $k => $v) {
                        echo "<div class='col-2'>
                          <input type='radio' class='btn-check' name='stime' id='stime" . ($k+1) . "' value='" . $v . "' autocomplete='off'>
                          <label class='btn btn-outline-primary timeslot' for='stime" . ($k+1) . "' style='width:100px;'>" . $v . "</label>
                        </div>";
                      }
                    }
                    else {
                      echo "<div class='d-flex justify-content-center'>
                        <h5 id='notimeslot'>No timeslot available</h5>
                      </div>";
                    }
                    ?>
                  </div>
                </div>
              </div>
              <div class="form-group my-2 d-flex justify-content-end">
                <a type="button" name="cancel" href="javascript:window.history.back();" class="btn btn-secondary me-2" role="button">Previous</a>
                <input type="submit" name="changeAppt" class="btn btn-primary" value="Change appointment">
              </div>
           </form>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      $(function() {
        $('input[name="stime"]').click(function() {
            var rBtn = $(this);

            if (rBtn.data('waschecked') == true) {
              rBtn.prop('checked', false);
              rBtn.data('waschecked', false);
            }
            else {
              rBtn.data('waschecked', true);
            }
        });
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
