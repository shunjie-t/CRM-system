<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CRM System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  </head>
  <body>
    <?php
    include("authentication.php");
    include("includes/authHeader.php");
    include("Controllers/patientProfileController.php");
    $con = new patientProfileController();

    if(isset($_GET['link'])){
      $_SESSION['userId'] = $_GET['link'];
      $_SESSION['patientId'] = $con->getPatientId($_GET['link']);
      $_SESSION['patientName'] = $con->getName($_GET['link']);
      header('Location: detailMenu.php');
    }
    ?>
    <div class="container">
      <div id="head-container">
        <h1>Patient accounts</h1>
        <div>
          <p><span id="quantity"></span> accounts</p>
          <a class="btn btn-danger float-end" href="home.php" role="button">Back</a>
        </div>
        <div class="search-container my-4">
          <input type="search" name="searchBar" placeholder="Search" id="searchBar" oninput="search(this.value)">
          <label class="ms-2" for="searchType">Search by: </label>
          <select name="searchType" id="searchType" onchange="search(this.parentElement.firstElementChild.value)">
            <option selected>All</option>
            <option value="NRIC/Passport number">NRIC/Passport number</option>
            <option value="Name">Name</option>
            <option value="Date of birth">Date of birth</option>
            <option value="Phone number">Phone number</option>
            <option value="Email address">Email address</option>
          </select>
        </div>
        <!--<button type="button" name="import" class="float-end btn btn-outline-primary">Import medical records</button>-->
      </div>
      <div id="list-container">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>NRIC/Passport number</th>
              <th>Name</th>
              <th>Date of birth</th>
              <th>Sex</th>
              <th>Phone number</th>
              <th>Email address</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="results"></tbody>
          <tbody id="contents">
            <?php
            if(!empty($con->getUserId())) {
              foreach ($con->getUserId() as $key => $val) {
                if($con->getAccountStatus($val) == "Activated") {
                  echo "<tr class='listItem'>
                    <td>" . $val . "</td>
                    <td>" . $con->getIdentityNumber($val) . "</td>
                    <td>" . $con->getName($val) . "</td>
                    <td>" . $con->getDateOfBirth($val) . "</td>
                    <td>" . $con->getSex($val) . "</td>
                    <td>" . $con->getPhoneNumber($val) . "</td>
                    <td>" . $con->getEmailAddress($val) . "</td>
                    <td><a href='?link=" . $val . "' class='btn btn-primary'>view</a></td>
                  </tr>";
                }
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
    </div>
    <script type="text/javascript">
      const counter = document.getElementById("quantity");
      const items = document.getElementsByClassName("listItem");
      const itemsRes = document.getElementsByClassName("resultItem");
      counter.innerHTML = items.length;

      function search(term) {
        var type = $('#searchType').val();
        var data = [term, type];

        fetch('searchPatient.php', {
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
    <script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

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
