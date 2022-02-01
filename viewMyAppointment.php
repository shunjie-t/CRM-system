<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRM System</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" href="css/bootstrap5.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>-->
    <script>
        function showCurrentAppointment(){
            var current = document.getElementById("current");
            var missed = document.getElementById("missed");
            var past = document.getElementById("past");
             
            if(current.style.display === "none") {
                current.style.display = "block";
                missed.style.display = "none";
                past.style.display = "none";
            } else {
                current.style.display = "none";
                missed.style.display = "none";
                past.style.display = "none";
            }
        }

        function showMissedAppointment(){
            var current = document.getElementById("current");
            var missed = document.getElementById("missed");
            var past = document.getElementById("past");
             
            if(missed.style.display === "none") {
                current.style.display = "none";
                missed.style.display = "block";
                past.style.display = "none";
            } else {
                current.style.display = "none";
                missed.style.display = "none";
                past.style.display = "none";
            }
        }

        function showPastAppointment(){
            var current = document.getElementById("current");
            var missed = document.getElementById("missed");
            var past = document.getElementById("past");
             
            if(past.style.display === "none") {
                current.style.display = "none";
                missed.style.display = "none";
                past.style.display = "block";
            } else {
                current.style.display = "none";
                missed.style.display = "none";
                past.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <?php 
    include("authentication.php");
    include("includes/authHeader.php");
    include("Controllers/appointmentController.php");
    $search = new appointmentController();
    $user = $auth->getUser($_SESSION['uid']);
	$name=$user->displayName;
    ?>
    <div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
                <?php 
					if(isset($_SESSION['status'])){
						echo "<h5 class='alert alert-success'>". $_SESSION['status'] ."</h5>";
						unset($_SESSION['status']);
					}
				?>
                <div class="card-header">
					<h3>
						My Appointments
						<a href="home.php" class="btn btn-danger float-end">Back</a>
                        <?php
                        $reference = "appointments/";
                        $apptSnap = $database->getReference($reference)->orderByChild('patientName')->equalTo($name)->getSnapshot();
                        ?>
                        <a href="searchDoctor.php" class="btn btn-primary float-end">Book New Appointment</a>
                    </h3>
				</div>
            </div>
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button class="nav-link" onclick="showCurrentAppointment();">My Current Appointment</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" onclick="showMissedAppointment();">My Missed Appointment</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" onclick="showPastAppointment();">My Past Appointment</button>
            </li>
        </ul>
        <div class="col-md-12">   
            <div class="table-responsive" id="current" style="display:block;">
                <table class="table table-striped table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Doctor Name</th>
                        <th>Title</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Booked On</th>
                        <th>View</th>
                    </thead>
                    <tbody>
                        <?php
                            $search->displayCurrentAppointment($name);
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive" id="missed" style="display:none;">
				<div class="search-container my-2">
		            <input type="search" name="missSearchBar" placeholder="Search" id="missSearchBar" oninput="missSearch(this.value)">
		            <label class="ms-2" for="missSearchType">Search by: </label>
		            <select name="missSearchType" id="missSearchType" onchange="missSearch(this.parentElement.firstElementChild.value)">
                        <option selected>All</option>    
                        <option value="Doctor Name">Doctor name</option>
		                <option value="Start Date">Start date</option>
		            </select>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Doctor Name</th>
                        <th>Title</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Booked On</th>
                        <th>View</th>
                    </thead>
                    <tbody id="missContents">
                        <p><span id="missQuantity"></span> accounts</p>
                        <input type="hidden" name="patientName" id="patientName" value="<?php echo $name;?>">
                        <?php
                                $search->setAttributeArray();
								$notFound = true;
                                $currentDate= date("Y-m-d");
                                $i=1;
                                $apptValue= $database->getReference("appointments")->orderByChild("patientName")->equalTo($name)->getValue();
								if(!empty($search->getAppointmentId())) {
									foreach ($apptValue as $key => $val) {
										if($val["startDate"] < $currentDate && $val["patientName"] == $name) {
											echo "<tr class='missItem'>
												<td>" . $i++ . "</td>
												<td>" . $val["doctorName"] . "</td>
												<td>" . $val["title"]. "</td>
												<td>" . $val["startDate"]  . "</td>
												<td>" . $val["startTime"]  . "</td>
												<td>" . $val["endTime"]  . "</td>
												<td>" . $val["bookedDate"]  . "</td>";
                                                ?>
												<td><a href="viewAppointment.php?id=<?=$key;?>" class="btn btn-primary">View</a></td>
                                                <?php
											echo "</tr>";


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
                        <tbody id="missResults"></tbody>
                </table>
            </div>
            <div class="table-responsive" id="past" style="display:none;">
                <div class="search-container my-4">
                    <input type="search" name="searchBar" placeholder="Enter search" id="searchBar" oninput="search(this.value)">
                    <label class="ms-2" for="searchType">Search by: </label>
                    <select name="searchType" id="searchType" onchange="search(this.parentElement.firstElementChild.value)">
                        <option selected>All</option>
                        <option value="DoctorName">Doctor Name</option>
                        <option value="AppointmentDate">Appointment Date</option>
                    </select>
                </div>
                <div id="list-container">
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>Title</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>End Time</th>
                            <th>Booked On</th>
                        </thead>
                        <tbody id="default">
                        <p><span id='quantity'></span> Record(s) Found</p>
                        <input type="hidden" name="patientName" id="patientName" value="<?php echo $name;?>">
                            <?php
                                //$search->displayPastAppointment($name);
                                $search->setAttributeArray();
                                //echo $name;
                                $i=1;
                                if(!empty($search->getappointmentId())) {
                                    foreach ($search->getappointmentId() as $key => $val) {
                                      if($search->getAppointmentStatus($val) == "Completed" && $search->getPatientName($val)==$name) {
                                        echo "<tr class='listItem'>
                                          <td>" . $i++ . "</td>
                                          <td>" . $search->getPatientName($val) . "</td>
                                          <td>" . $search->getDoctorName($val) . "</td>
                                          <td>" . $search->getTitle($val) . "</td>
                                          <td>" . $search->getStartDate($val) . "</td>
                                          <td>" . $search->getStartTime($val) . "</td>
                                          <td>" . $search->getEndTime($val) . "</td>
                                          <td>" . $search->getBookedDate($val) . "</td>
                                        </tr>";
                                      }
                                    }
                                  } else{
                                    echo "<tr>
                                        <td ali gn='center' colspan='8'>No record found</td>
                                    </tr>";
                                  }
                            ?>
                        </tbody>
                        <tbody id="searchRes"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
      const counter = document.getElementById("quantity");
      const items = document.getElementsByClassName("listItem");
      const itemsRes = document.getElementsByClassName("filteredRes");
      const missQty = document.getElementById("missQuantity");
      const missItm = document.getElementsByClassName("missItem");
      const missRes = document.getElementsByClassName("missResItem");
      missQty.innerHTML = missItm.length;
      counter.innerHTML = items.length;

      function search(term) {
        var type = $('#searchType').val();
        var patientName = $('#patientName').val();
        var data = [term, type];

        fetch('searchPastAppointment.php', {
            method: 'post',
            body: new URLSearchParams('term=' + data + '&&patientName=' + patientName) 
        })
        // .then(res => res.text())
        .then(res => res.json())
        // .then(res => console.log(res))
        .then(res => output(res))
        .catch(e => console.error('Error: ' + e));
      }

      function missSearch(term) {
        var type = $('#missSearchType').val();
        var patientName = $('#patientName').val();
        var data = [term, type];

        fetch('searchMissedAppointment.php', {
          method: 'post',
          body: new URLSearchParams('term=' + data + '&&patientName=' + patientName)
        })
        .then(res => res.json())
        .then(res => missOutput(res))
        .catch(e => console.error('Error: ' + e));
      }

      function output(data) {
        const sBar = $('#searchBar').val();
        const tbod = document.querySelector("#searchRes");

        if(sBar != "") {
          $('#searchRes').empty();

          if(data.length > 0) {
            for(var a of data) {
              const trHTML = document.createElement('tr');
              trHTML.setAttribute("class", "filteredRes");

              for(var b of a) {
                const tdHTML = document.createElement('td');
                tdHTML.appendChild(document.createTextNode(b));
                trHTML.appendChild(tdHTML);
              }
              //const aHTML = document.createElement('a');
              //aHTML.setAttribute("class", "btn btn-primary");
              //aHTML.setAttribute("href", "?link=" + a[0]);
             // aHTML.appendChild(document.createTextNode("view"));
 
              const tdHTML = document.createElement('td');
             // tdHTML.appendChild(aHTML);
              trHTML.appendChild(tdHTML);
              tbod.appendChild(trHTML);
            }
            counter.innerHTML = itemsRes.length;
          }
          else {
            const trHTML = document.createElement('tr');
            const tdHTML = document.createElement('td');
            tdHTML.appendChild(document.createTextNode("No record found"));
            tdHTML.setAttribute("align", "center");
            tdHTML.setAttribute("colspan", "8");
            trHTML.appendChild(tdHTML);
            tbod.appendChild(trHTML);
            counter.innerHTML = itemsRes.length;
          }

          $('#default').hide();
        }
        else {
          $('#searchRes').empty();
          $('#default').show();
          counter.innerHTML = items.length;
        }
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