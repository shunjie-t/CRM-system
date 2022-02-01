<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<title>CRM System</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap5.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
	</head>
	<body>
		<?php
		include("authentication.php");
    include("includes/authHeader.php");
		include("Controllers/appointmentController.php");

		$con = new appointmentController();
		$con->setAttributeArray();
		$pid = $_SESSION['patientId'];
		$patientName = $_SESSION['patientName'];

		if(isset($_GET['link'])){
			$_SESSION['appointmentId'] = $_GET['link'];
			header('Location: appointmentDetail.php');
		}
		?>
		<div class="container my-3">
			<div class="card">
				<div class="card-header">
					<h3>Appointments of <?=$patientName?></h3>
					<div class="d-flex justify-content-end">
						<a class="btn btn-primary mx-2" href="searchDoctor.php" role="button">Book appointment</a>
						<a class="btn btn-danger mx-2" href="detailMenu.php" role="button">Back</a>
					</div>
				</div>
				<div class="card-body">
					<div id="current">
						<h5>Upcoming appointments</h5>
						<table class="table table-striped">
							<thead>
								<th>ID</th>
								<th>Patient Name</th>
								<th>Doctor Name</th>
								<th>Title</th>
								<th>Start Date</th>
								<th>Start Time</th>
								<th>End Time</th>
								<th>Booked Date</th>
								<th></th>
							</thead>
							<tbody>
								<?php
								$notFound = true;

								if(!empty($con->getAppointmentId())) {
									foreach ($con->getAppointmentId() as $val) {
										if($con->getAppointmentStatus($val) == "Ongoing" && $con->getPatientId($val) == $pid) {
											echo "<tr class='listItem'>
												<td>" . $val . "</td>
												<td>" . $con->getPatientName($val) . "</td>
												<td>" . $con->getDoctorName($val) . "</td>
												<td>" . $con->getTitle($val) . "</td>
												<td>" . $con->getStartDate($val) . "</td>
												<td>" . $con->getStartTime($val) . "</td>
												<td>" . $con->getEndTime($val) . "</td>
												<td>" . $con->getBookedDate($val) . "</td>
												<td><a href='?link=" . $val . "' class='btn btn-primary'>view</a></td>
											</tr>";

											$notFound = false;
										}
									}
								}

								if($notFound) {
									echo "<tr>
										<td align='center' colspan='9'>No record found</td>
									</tr>";
								}
								?>
							</tbody>
						</table>
					</div>
					<hr>
					<div id="past">
						<h5>Past appointments</h5>
						<p><span id="pastQuantity"></span> accounts</p>
						<div class="search-container my-2">
		          <input type="search" name="pastSearchBar" placeholder="Search" id="pastSearchBar" oninput="pastSearch(this.value)">
		          <label class="ms-2" for="pastSearchType">Search by: </label>
		          <select name="pastSearchType" id="pastSearchType" onchange="pastSearch(this.parentElement.firstElementChild.value)">
		            <!-- <option>All</option>
								<option>Patient name</option> -->
		            <option>Doctor name</option>
								<!-- <option>Title</option> -->
		            <option>Start date</option>
								<!-- <option>Start time</option>
								<option>End time</option>
								<option>Booked date</option> -->
		          </select>
		        </div>
						<table class="table table-striped">
							<thead>
								<th>ID</th>
								<th>Patient Name</th>
								<th>Doctor Name</th>
								<th>Title</th>
								<th>Start Date</th>
								<th>Start Time</th>
								<th>End Time</th>
								<th>Booked Date</th>
								<th></th>
							</thead>
							<tbody id="pastResults"></tbody>
							<tbody id="pastContents">
								<?php
								$notFound = true;

								if(!empty($con->getAppointmentId())) {
									foreach ($con->getAppointmentId() as $val) {
										if($con->getAppointmentStatus($val) == "Completed" && $con->getPatientId($val) == $pid) {
											echo "<tr class='pastItem'>
												<td>" . $val . "</td>
												<td>" . $con->getPatientName($val) . "</td>
												<td>" . $con->getDoctorName($val) . "</td>
												<td>" . $con->getTitle($val) . "</td>
												<td>" . $con->getStartDate($val) . "</td>
												<td>" . $con->getStartTime($val) . "</td>
												<td>" . $con->getEndTime($val) . "</td>
												<td>" . $con->getBookedDate($val) . "</td>
												<td><a href='?link=" . $val . "' class='btn btn-primary'>view</a></td>
											</tr>";

											$notFound = false;
										}
									}
								}

								if($notFound) {
									echo "<tr>
										<td align='center' colspan='9'>No record found</td>
									</tr>";
								}
								?>
							</tbody>
						</table>
					</div>
					<hr>
					<div id="missed">
						<h5>Missed appointments</h5>
						<p><span id="missQuantity"></span> accounts</p>
						<div class="search-container my-2">
		          <input type="search" name="missSearchBar" placeholder="Search" id="missSearchBar" oninput="missSearch(this.value)">
		          <label class="ms-2" for="missSearchType">Search by: </label>
		          <select name="missSearchType" id="missSearchType" onchange="missSearch(this.parentElement.firstElementChild.value)">
								<!-- <option>All</option>
								<option>Patient name</option> -->
		            <option>Doctor name</option>
								<!-- <option>Title</option> -->
		            <option>Start date</option>
								<!-- <option>Start time</option>
								<option>End time</option>
								<option>Booked date</option> -->
		          </select>
		        </div>
						<table class="table table-striped">
							<thead>
								<th>ID</th>
								<th>Patient Name</th>
								<th>Doctor Name</th>
								<th>Title</th>
								<th>Start Date</th>
								<th>Start Time</th>
								<th>End Time</th>
								<th>Booked Date</th>
								<th></th>
							</thead>
							<tbody id="missResults"></tbody>
							<tbody id="missContents">
								<?php
								$notFound = true;

								if(!empty($con->getAppointmentId())) {
									foreach ($con->getAppointmentId() as $val) {
										if($con->getAppointmentStatus($val) == "Missed" && $con->getPatientId($val) == $pid) {
											echo "<tr class='missItem'>
												<td>" . $val . "</td>
												<td>" . $con->getPatientName($val) . "</td>
												<td>" . $con->getDoctorName($val) . "</td>
												<td>" . $con->getTitle($val) . "</td>
												<td>" . $con->getStartDate($val) . "</td>
												<td>" . $con->getStartTime($val) . "</td>
												<td>" . $con->getEndTime($val) . "</td>
												<td>" . $con->getBookedDate($val) . "</td>
												<td><a href='?link=" . $val . "' class='btn btn-primary'>view</a></td>
											</tr>";

											$notFound = false;
										}
									}
								}

								if($notFound) {
									echo "<tr>
										<td align='center' colspan='9'>No record found</td>
									</tr>";
								}
								?>
						</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			const pastQty = document.getElementById("pastQuantity");
			const missQty = document.getElementById("missQuantity");
      const pastItm = document.getElementsByClassName("pastItem");
			const missItm = document.getElementsByClassName("missItem");
      const pastRes = document.getElementsByClassName("pastResItem");
			const missRes = document.getElementsByClassName("missResItem");
      pastQty.innerHTML = pastItm.length;
			missQty.innerHTML = missItm.length;

      function pastSearch(term) {
        var type = $('#pastSearchType').val();
        var data = ["Completed", term, type];

        fetch('searchAppointment.php', {
          method: 'post',
          body: new URLSearchParams('term=' + data)
        })
        .then(res => res.json())
        .then(res => pastOutput(res))
        .catch(e => console.error('Error: ' + e));
      }

      function pastOutput(data) {
  			if(!$('#pastSearchBar').val()) {
  				$('#pastContents').show();
  				$('#pastResults').empty();
          pastQty.innerHTML = pastItm.length;
  			}
  			else {
  				$('#pastContents').hide();
  				$('#pastResults').html(data);
          pastQty.innerHTML = pastRes.length;
  			}
  		}

			function missSearch(term) {
        var type = $('#missSearchType').val();
        var data = ["Missed", term, type];

        fetch('searchAppointment.php', {
          method: 'post',
          body: new URLSearchParams('term=' + data)
        })
        .then(res => res.json())
        .then(res => missOutput(res))
        .catch(e => console.error('Error: ' + e));
      }

			function missOutput(data) {
  			if(!$('#missSearchBar').val()) {
  				$('#missContents').show();
  				$('#missResults').empty();
          missQty.innerHTML = missItm.length;
  			}
  			else {
  				$('#missContents').hide();
  				$('#missResults').html(data);
          missQty.innerHTML = missRes.length;
  			}
  		}
		</script>
		<script src="js/fontawesome.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap5.js"></script>
    <!-- <script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
	</body>
</html>