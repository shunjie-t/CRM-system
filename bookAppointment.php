<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>CRM System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  </head>
  <body>
    <?php
    session_start();
    include("../Controllers/appointmentController.php");
    include("../Controllers/userController.php");
    $Acon = new appointmentController();
    $Ucon = new userController();
    $Ucon->setPatientRecords($_SESSION['patientName']);
    ?>
    <div class="container my-3">
      <div class="card">
        <div class="card-header">
          <h4>Book Appointment</h4>
        </div>
        <div class="card-body">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
						<div class="form-group mb-3">
							<label>Patient Name: </label>
							<input type="text" class="form-control" name="pname" id="pname" value="<?php echo $_SESSION['patientName'] ?>" readonly>
						</div>
            <div class="form-group mb-3">
              <label>Doctor Name: </label>
              <input list="text" class="form-control" name="dname" id="dname" value="Jeremy" readonly>
            </div>
            <div class="form-group mb-3">
              <div class="row">
                <div class="col">
                  <label>Department: </label>
                  <input type="text" readonly class="form-control" name="department" id="department" value="<?php /*echo $Ucon->getDepartment();*/ ?>">
                </div>
                <div class="col">
                  <label>Venue: </label>
                  <input type="text" readonly class="form-control" name="venue" id="venue" value="<?php /*echo $appointment->getVenue();*/ ?>">
                </div>
              </div>
            </div>
						<div class="form-group mb-3">
							<label>Title: </label>
							<input type="text" class="form-control" name="title" id="title">
            </div>
            <div class="form-group my-4">
							<label>Date: </label>
              <div class="input-group mb-3">
                <button class="btn btn-outline-secondary" type="button" id="clearDate">Clear</button>
                <input type="text" class="form-control" name="date" id="datepicker" onkeydown="return false;" autocomplete="off" required>
              </div>
            </div>
            <div class="form-group my-4" id="startTime" style="display: none;">
              <label>Start Time: </label>
              <div class="btn-group d-block mt-3" role="group">
                <div class="row g-3">
                  <?php
                  foreach($Acon->getTimeslot() as $k => $v) {
                    echo "<div class='col-2'>
                      <input type='radio' class='btn-check' name='btnradio' id='btnradio" . ($k+1) . "' autocomplete='off'>
                      <label class='btn btn-outline-primary timeslot' for='btnradio" . ($k+1) . "' style='width:100px;'>" . $v . "</label>
                    </div>";
                  }
                  ?>
                </div>
                <div class="d-flex justify-content-center">
                  <h5 id="notimeslot">No timeslot available</h5>
                </div>
              </div>
            </div>
            <div class="form-group mb-3">
              <label>Notes: </label>
              <textarea name="notes" id="notes" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group my-2 d-flex justify-content-end">
              <input type="submit" name="submit" class="btn btn-primary" value="Book Appointment">
            </div>
         </form>
       </div>
     </div>
   </div>

   <?php
   if(isset($_POST['submit'])) {
     date_default_timezone_set('Asia/Singapore');

     $email = $Ucon->getEmail();
     $aid = count($Acon->getAppointmentId()) + 1;
     $pid = $_SESSION['patientId'];
     $did = 1;
     $pname = $_POST['pname'];
     $dname = $_POST['dname'];
     $title = $_POST['title'];
     $sdate = $_POST['date'];
     $stime = $_POST['btnradio'];
     $etime = $_POST['btnradio'];
     $bdate = date("Y-m-d");
     $dpart = $_POST['department'];
     $venue = $_POST['venue'];
     $notes = $_POST['notes'];

     $Acon->validateAppointment($email,$aid,$pid,$did,$pname,$dname,$title,$sdate,$stime,$etime,$bdate,$dpart,$venue,$notes);
   }
   ?>

   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script type="text/javascript">
     var dt = (new Date().getFullYear()).toString() + ":" + (new Date().getFullYear() + 10).toString();
     const booked = [new Date(2021,06,20).getTime(),new Date(2021,06,24).getTime(),new Date(2021,06,27).getTime(),new Date(2021,06,30).getTime()];

     $(function() {
       $( "#datepicker" ).datepicker({
         yearRange: dt,
         changeYear: true,
         numberOfMonths: 2,
         minDate: new Date()/*,
         beforeShowDay: function(date = new Date()) {
           if($.inArray(date.getTime(),booked) > -1) {
             return [false, "disabled", "Fully booked"];
           }

           return [true, "enabled", "Available"];
         }*/
       })
       .on("change",function(){
         var selectedDate = $(this).val();
         getDate(this);
       });

       $("#clearDate").click(function() {
         $("#datepicker").val("");
         $('input[name="btnradio"]').prop('checked', false);
         $('input[name="btnradio"]').data('checked', false);
         $('#startTime').hide();
       });

       $('input[name="btnradio"]').click(function() {
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

     function getDate(param) {
       fetch('timeslot.php', {
         method: 'post',
         body: new URLSearchParams('term=' + param.value)
       })
       .then(res => res.json())
       .then(res => showTimeslot(res))
       .catch(e => console.error('Error: ' + e));
     }

     function showTimeslot(param) {
       $('.timeslot').each(function() {
         for(var a in param) {
           if(this.innerHTML === param[a]) {
             $(this).parent().hide();
           }
         }
       });
       $('#startTime').show();

       if(param.length == 18) {
         $('#notimeslot').show();
       }
       else {
         $('#notimeslot').hide();
       }
     }
   </script>

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
