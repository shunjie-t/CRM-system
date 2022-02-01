
<!-- Top navbar -->
<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="home.php">DashBoard</a>
      <?php
        require('./dbcon.php');
        $user = $auth->getUser($_SESSION['uid']);
				$name=$user->displayName;
        $reference = "user";
        $ref = $database->getReference($reference)
                 ->orderByChild('name')
                 ->equalTo($name)
                 ->getValue();
        foreach($ref as $key => $row){
          if($row["role"]=="patient"){
      ?>
          <ul>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarPatientRecordsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                My Records
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarPatientRecordsDropdown">
                <li><a class="dropdown-item" href="viewMyRecords.php">Consulation Records</a></li>
                <li><a class="dropdown-item" href="viewMyMedicalRecords.php">Medical Records</a></li>
                <li><a class="dropdown-item" href="viewMyBills.php">Billing Records</a></li>
              </ul>
            </li>
          </ul>
          <ul>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarAppointmentDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                All Appointments
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarAppointmentDropdown">
                <li><a class="dropdown-item" href="viewMyAppointment.php">Appointments</a></li>
              </ul>
            </li>
          </ul>
          <ul>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarEducationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Education Articles
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarEducationDropdown">
                <li><a class="dropdown-item" href="viewArticles.php">New Feeds</a></li>
              </ul>
            </li>
          </ul>
        <?php
        } elseif($row["role"]=="doctor"){
        ?>
          <ul>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarPatientDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Patients
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarPatientDropdown">
                <li><a class="dropdown-item" href="myPatient.php">My Patients</a></li>
              </ul>
            </li>
          </ul>
          <ul>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarReferralDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Referral
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarReferralDropdown">
                <li><a class="dropdown-item" href="viewReferrals.php">Referrals</a></li>
              </ul>
            </li>
          </ul>
          <ul>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarScheduleDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Doctor Schedule
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarScheduleDropdown">
                <li><a class="dropdown-item" href="doctorSchedule.php?name=<?=$name;?>">My Schedule</a></li>
              </ul>
            </li>
          </ul>
        <?php
        } elseif($row["role"]=="medical administrator"){
        ?>
        <ul>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarPatientProfileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Patients Records
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarPatientProfileDropdown">
              <li><a class="dropdown-item" href="patientProfile.php">Patient Profile</a></li>
            </ul>
          </li>
        </ul>
        <ul>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarMedReferralDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Referrals
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarMedReferralDropdown">
              <li><a class="dropdown-item" href="referralList.php">Referral Details</a></li>
            </ul>
          </li>
        </ul>
        <ul>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarPostArticlesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Educational Articles
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarMedReferralDropdown">
              <li><a class="dropdown-item" href="viewAllArticles.php">Post Educational Articles</a></li>
            </ul>
          </li>
        </ul>
        <?php
        } elseif($row["role"]=="application administrator"){
        ?>
          <ul>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Users
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarUserDropdown">
                <li><a class="dropdown-item" href="user.php">User Management</a></li>
              </ul>
            </li>
          </ul>
        <?php
        }
      }
        ?>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="images/user-800x800.jpg" width="30" height="30">
            <?php
                echo $name;
		      	?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="profile-details.php">My Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li>
</nav>
