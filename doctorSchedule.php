<?php 
    include("authentication.php");
    include("includes/authHeader.php");
    $doctorName = $_GET["name"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>CRM System</title>
	<link rel="stylesheet" href="css/calendarStyle.css">
	<script src="https://use.fontawesome.com/5def5740b2.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <!--have to download folder in fullcalendar.io first-->
	<link rel="stylesheet" href="lib/main.css">
	<style>

		#calendar {
			width: 700px;
			margin: 0 auto;
		}

		.response {
			height: 60px;
		}

		.success {
			background: #cdf3cd;
			padding: 10px 60px;
			border: #c3e6c3 1px solid;
			display: inline-block;
		}
	</style>
	<script type="text/javascript" src="lib/main.js"></script> 
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var calendars = document.getElementById('calendar');
            var doctorName = document.getElementById('doctorName').value;
			var calendar = new FullCalendar.Calendar(calendars, {
				timeZone: 'UTC',
				initialView: 'dayGridMonth',
				editable: true,
				selectable: true,
				selectHelper:true,
				dateClick:function(info){
					alert ('Date: ' + info.dateStr);
					var date = info.dateStr;
					if(date != "" ){
						location.href = 'createNewAppointment.php?doctorName=' + doctorName + '&&department=' + department + '&&wing=' + wing  + '&&venue=' + venue+ '&&date=' + date;		
					}
				},
				displayEventTime: false,
				eventRender: function (event, element, view) {
					if (event.allDay === 'true') {
						event.allDay = true;
					} else {
						event.allDay = false;
					}
				},
				eventSources: [
					{
						url: './fetchDoctorAppointment.php?name=<?=$doctorName;?>',
						method: 'POST',
						extraParams: {
							doctorName : 'doctorName'
						},
						failure: function(){
							alert('there was an error while fetching events');
						},
						color: 'yellow',
						textColor: 'black',
						selectable: false
					}
				],
				eventClick: function(info) {
					var eventObj = info.event;
					if(eventObj != "" )
					{
						location.href = 'viewApptPatientDetail.php?id='+ eventObj.id + '&&startDate=' + eventObj.title;
					}
                }	
			});
		calendar.render();
		});
		
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>
							Doctor Schedule -> <?php echo $doctorName;?>
							<a href="home.php" class="btn btn-danger float-end">Back</a> 
                    	</h3>
                    </div>
                    <div class="card-body">
                        <input type="hidden" readonly class="form-control-plaintext" id="doctorName"  name="doctorName" value="<?php echo $doctorName;?>">

                        <div class="response"></div>
	            	    <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    
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