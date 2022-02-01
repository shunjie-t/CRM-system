<?php
    class Users{
		protected $user;
        protected $userError;

		function __construct(){
			require 'dbcon.php';
			$this->user = $database->getReference('user');
            $this->userError = $database->getReference('userError');
		}

        public function getUserDetails() {
            require 'dbcon.php';
            $ref_table = "user/";
            $reference = $database->getReference($ref_table)->getValue();
    
            return $reference;
        }
		public function getUserByRole($rl) {
			require 'dbcon.php';
			$reference = $database->getReference('user');
			$data = $reference->getValue();
			$result = array();
	  
			if($reference->getSnapshot()->hasChildren()) {
			  foreach($data as $a) {
				if($a['role'] == $rl) {
				  array_push($result, $a);
				}
			  }
			}
	  
			return $result;
		  }
	  

		public function getUser($uid){
			$userValue = $this->user->getValue();
            $userSnap = $this->user->getSnapshot();

			$userId = $userSnap->numChildren() + 1;
			if($userSnap->hasChildren()){
				foreach($userValue as $key => $user){
					if($key == $uid){
						return $user;
					}
				}
			} 
		}

		public function getUserByEmail($email){
			$userValue = $this->user->getValue();
            $userSnap = $this->user->getSnapshot();

			if($userSnap->hasChildren()){
				foreach($userValue as $key => $user){
					if($user['emailAddress'] == $email){
						return $user;
					}
				}
			} 
		}

		public function getPasswordModel($uid){
			$userValue = $this->user->getValue();
            $userSnap = $this->user->getSnapshot();

			$userId = $userSnap->numChildren() + 1;
			if($userSnap->hasChildren()){
				foreach($userValue as $key => $user){
					if($user["userId"] == $uid){
						return $user;
					}
				}
			}
		}

		public function searchDoctorModel($listVariable){
			require("dbcon.php");
			try {
				$ref_table = "doctors/";
            	$userValue = $database->getReference($ref_table) ->orderByChild('name')  
											->equalTo($listVariable)  
											->getValue();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
			
			$i=1;
			?>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<label>Search Results</label>
						<label class="form-group float-end"> <?php echo count($userValue);?> result(s) found</label>
					</thead>
					<tbody>
			<?php
			
				foreach($userValue as $key => $user){
					?>
					<div class="card">
						<div class="card-header">
							<div class="col">
								<input type="hidden" readonly  class="form-control-plaintext" value="<?=$user['doctorId'];?>">
								<input type="text" readonly  class="form-control-plaintext" value="<?php echo "Dr " .$user['name']?>">
							</div>
						</div>
						<div class="card-body">
							<div class="col-sm-10">
								<label class="form-label"><strong>Specialty: </strong></label>
								<input type="text" readonly  class="form-control-plaintext" value="<?=$user['department']?>">
							</div>
							<div class="col">
								<a href="viewDoctorProfile.php?id=<?=$user['doctorId'];?>&&doctorName=<?=$user['name'];?>&&department=<?=$user['department'];?>&&venue=<?=$user['venue'];?>" class="btn btn-primary">View Profile</a>
							</div>
							<div class="col-sm-10">
								<label class="form-label"><strong>Location: </strong></label>
								<input type="text" readonly class="form-control-plaintext"  value="<?=$user['venue']?>">
							</div>
							<div class="col-sm-10">
								<label class="form-label"><strong>Contact No: </strong></label>
								<input type="text" readonly class="form-control-plaintext" value="<?=$user['officeNumber']?>">
							</div>
							<div class="col">
							<a href="patientBookingCalendar.php?id=<?=$user['doctorId'];?>&&doctorName=<?=$user['name'];?>&&department=<?=$user['department'];?>&&venue=<?=$user['venue'];?>" class="btn btn-primary">Make an Appointment</a>
							</div>
						</div>
					</div>
					<br><hr><br>
					<?php
				}
			?>
					</tbody>
				</table>
			</div>
			<?php
        }

		public function searchDoctorSpecialtyModel($department) {
            require("dbcon.php");
			$ref_table = "doctors/";
            $userValue = $database->getReference($ref_table)->orderByChild('department')
                                            ->equalTo($department)
                                            ->getValue();

			$i=1;
			?>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<label>Search Results</label>
						<label class="form-group float-end"> <?php echo count($userValue);?> result(s) found</label>
					</thead>
					<tbody>
			<?php
				foreach($userValue as $key => $user){
					?>
					<div class="card">
						<div class="card-header">
							<div class="col">
								<input type="hidden" readonly  class="form-control-plaintext" value="<?=$user['doctorId'];?>">
								<input type="text" readonly  class="form-control-plaintext" value="<?php echo "Dr " .$user['name']?>">
							</div>
						</div>
						<div class="card-body">
							<div class="col-sm-10">
								<label class="form-label"><strong>Specialty: </strong></label>
								<input type="text" readonly  class="form-control-plaintext" value="<?=$user['department']?>">
							</div>
							<div class="col">
								<a href="viewDoctorProfile.php?id=<?=$user['doctorId'];?>&&doctorName=<?=$user['name'];?>&&department=<?=$user['department'];?>&&venue=<?=$user['venue'];?>" class="btn btn-primary">View Profile</a>
							</div>
							<div class="col-sm-10">
								<label class="form-label"><strong>Location: </strong></label>
								<input type="text" readonly class="form-control-plaintext"  value="<?=$user['venue']?>">
							</div>
							<div class="col-sm-10">
								<label class="form-label"><strong>Contact No: </strong></label>
								<input type="text" readonly class="form-control-plaintext" value="<?=$user['officeNumber']?>">
							</div>
							<div class="col">
							<a href="patientBookingCalendar.php?id=<?=$user['doctorId'];?>&&doctorName=<?=$user['name'];?>&&department=<?=$user['department'];?>&&venue=<?=$user['venue'];?>" class="btn btn-primary">Make an Appointment</a>
							</div>
						</div>
					</div>
					<br><hr><br>
					<?php
				}
			?>
					</tbody>
				</table>
			</div>
			<?php
        }
        
        public function searchDoctorGenderModel($gender) {
            require("dbcon.php");
			$ref_table = "doctors/";
            $userValue = $database->getReference($ref_table)->orderByChild('gender')
                                            ->equalTo($gender)
                                            ->getValue();

			$i=1;
			?>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<label>Search Results</label>
						<label class="form-group float-end"> <?php echo count($userValue);?> result(s) found</label>
					</thead>
					<tbody>
			<?php
				foreach($userValue as $key => $user){
					?>
					<div class="card">
						<div class="card-header">
							<div class="col">
								<input type="hidden" readonly  class="form-control-plaintext" value="<?=$user['doctorId'];?>">
								<input type="text" readonly  class="form-control-plaintext" value="<?php echo "Dr " .$user['name']?>">
							</div>
						</div>
						<div class="card-body">
							<div class="col-sm-10">
								<label class="form-label"><strong>Specialty: </strong></label>
								<input type="text" readonly  class="form-control-plaintext" value="<?=$user['department']?>">
							</div>
							<div class="col">
								<a href="viewDoctorProfile.php?id=<?=$user['doctorId'];?>&&doctorName=<?=$user['name'];?>&&department=<?=$user['department'];?>&&venue=<?=$user['venue'];?>" class="btn btn-primary">View Profile</a>
							</div>
							<div class="col-sm-10">
								<label class="form-label"><strong>Location: </strong></label>
								<input type="text" readonly class="form-control-plaintext"  value="<?=$user['venue']?>">
							</div>
							<div class="col-sm-10">
								<label class="form-label"><strong>Contact No: </strong></label>
								<input type="text" readonly class="form-control-plaintext" value="<?=$user['officeNumber']?>">
							</div>
							<div class="col">
							<a href="patientBookingCalendar.php?id=<?=$user['doctorId'];?>&&doctorName=<?=$user['name'];?>&&department=<?=$user['department'];?>&&venue=<?=$user['venue'];?>" class="btn btn-primary">Make an Appointment</a>
							</div>
						</div>
					</div>
					<br><hr><br>
					<?php
				}
			?>
					</tbody>
				</table>
			</div>
			<?php
        }

		public function searchAllDoctorModel(){
			require("dbcon.php");
			$ref_table = "doctors";
            $userValue =  $database->getReference($ref_table)->getValue();

			$i=1;
			?>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<label>Search Results</label>
						<label class="form-group float-end"> <?php echo count($userValue);?> result(s) found</label>
					</thead>
					<tbody>
					<?php
						if($userValue>0){
							foreach($userValue as $key => $user){
								?>
								<div class="card">
									<div class="card-header">
										<div class="col">
											<input type="hidden" readonly  class="form-control-plaintext" value="<?=$user['doctorId'];?>">
											<input type="text" readonly  class="form-control-plaintext" value="<?php echo "Dr " .$user['name']?>">
										</div>
									</div>
									<div class="card-body">
										<div class="col-sm-10">
											<label class="form-label"><strong>Specialty: </strong></label>
											<input type="text" readonly  class="form-control-plaintext" value="<?=$user['department']?>">
										</div>
										<div class="col">
											<a href="viewDoctorProfile.php?id=<?=$user['doctorId'];?>&&doctorName=<?=$user['name'];?>&&department=<?=$user['department'];?>&&venue=<?=$user['venue'];?>" class="btn btn-primary">View Profile</a>
										</div>
										<div class="col-sm-10">
											<label class="form-label"><strong>Location: </strong></label>
											<input type="text" readonly class="form-control-plaintext"  value="<?=$user['venue']?>">
										</div>
										<div class="col-sm-10">
											<label class="form-label"><strong>Contact No: </strong></label>
											<input type="text" readonly class="form-control-plaintext" value="<?=$user['officeNumber']?>">
										</div>
										<div class="col">
										<a href="patientBookingCalendar.php?id=<?=$user['doctorId'];?>&&doctorName=<?=$user['name'];?>&&department=<?=$user['department'];?>&&venue=<?=$user['venue'];?>" class="btn btn-primary">Make an Appointment</a>
										</div>
									</div>
								</div>
								<br><hr><br>
								<?php
							}
						}  else{
							echo "
								<tr>
									<td>Record Not Found!!!!</td>
								</tr>
							";
						}
					?>
					</tbody>
				</table>
			</div>
			<?php
		}

		public function searchDoctorListModel($listDoctorVariable){
			$userValue = $this->user->orderByChild('name','role', 'accountStatus')->equalTo($listDoctorVariable, 'doctor', 'Activated')->getValue();

			$i=1;
			foreach($userValue as $key => $row){
				if($row["accountStatus"] == "Activated"){
				?>
					<tr>
						<td><?=$i++;?></td>
						<td><?=$row["name"];?></td>
						<td><?=$row["emailAddress"];?></td>
						<td><?=$row["department"];?></td>
						<td><?=$row["venue"];?></td>
						<td><?=$row["phoneNumber"];?></td>
						<td><?=$row["officeNumber"];?></td>
						<td><?=$row["role"];?></td>
						<td><a href="viewUsers.php?id=<?=$key;?>" class="btn btn-primary">View</a></td>
					</tr>
				<?php
				}
			}
		}

		public function searchMedAdminListModel($listMedAdminVariable){
			$userValue = $this->user->orderByChild('name','role', 'accountStatus')->equalTo($listMedAdminVariable, 'medical administrator', 'Activated')->getValue();

			$i=1;
			foreach($userValue as $key => $row){
				if($row["accountStatus"] == "Activated"){
				?>
					<tr>
						<td><?=$i++;?></td>
						<td><?=$row["name"];?></td>
						<td><?=$row["emailAddress"];?></td>
						<td><?=$row["phoneNumber"];?></td>
						<td><?=$row["officeNumber"];?></td>
						<td><?=$row["role"];?></td>
						<td><a href="viewUsers.php?id=<?=$key;?>" class="btn btn-primary">View</a></td>
					</tr>
				<?php
				}
			}
		}

		public function displayDoctorTableModel(){
			require("dbcon.php");
			$userValue = $database->getReference("user")->orderByChild("role", "accountStatus")
														->equalTo('doctor', 'Activated')
														->getValue();
			
			$i=1;
			if($userValue>0){
				foreach($userValue as $key => $row){
					if($row["accountStatus"] == "Activated"){
					//$i++;
					?>
					<tr>
						<td><?=$i++;?></td>
						<td><?=$row["name"];?></td>
						<td><?=$row["emailAddress"];?></td>
						<td><?=$row["department"];?></td>
						<td><?=$row["venue"];?></td>
						<td><?=$row["role"];?></td>
						<td><a href="viewUsers.php?id=<?=$key;?>" class="btn btn-primary">View</a></td>
					</tr>
					<?php
					}
				}
			}  else{
				echo "
					<tr>
						<td>Record Not Found!!!!</td>
					</tr>
				";
			}
		}

		public function displayMedAdminTableModel(){
			$userValue = $this->user->orderByChild("role", "accountStatus")
									->equalTo('medical administrator','Activated')
									->getValue();

			$i=1;
			if($userValue>0){
				foreach($userValue as $key => $row){
					if($row["accountStatus"] == "Activated"){
					//$i++;
					?>
					<tr>
						<td><?=$i++;?></td>
						<td><?=$row["name"];?></td>
						<td><?=$row["emailAddress"];?></td>
						<td><?=$row["role"];?></td>
						<td><a href="viewUsers.php?id=<?=$key;?>" class="btn btn-primary">View</a></td>
					</tr>
					<?php
					}
				}
			}  else{
				echo "
					<tr>
						<td>Record Not Found!!!!</td>
					</tr>
				";
			}
		}

		//login auth
        public function selectUser($email,$password) {
			require 'dbcon.php';
			$clearTextPassword=$password;
			try{
			
				$user=$auth->getUserByEmail($email);
				try{
					$signInResult = $auth->signInWithEmailAndPassword($email, $clearTextPassword);
				
					$idTokenString =  $signInResult->idToken(); // string|null;

					try {
						$verifiedIdToken = $auth->verifyIdToken($idTokenString);
						$uid = $verifiedIdToken->claims()->get('sub');

						$_SESSION["verified_user_id"] = $idTokenString;
						$_SESSION["idTokenString"] = $idTokenString;
						$_SESSION["uid"]=$uid;
						$_SESSION["email"] = $email;
						$_SESSION["password"] = $password;

						$_SESSION['status'] = "Login Success";
						//header("Location: verifyUser.php");
						header("Location: home.php");
						exit();
					} catch (InvalidToken $e) {
						echo 'The token is invalid: '.$e->getMessage();
					} catch (\InvalidArgumentException $e) {
						echo 'The token could not be parsed: '.$e->getMessage();
					}
				} catch(Exception $e) {
					$_SESSION['status']= "Invalid Password";
					header("Location: login.php");
					exit();
				}
				
			} catch(\Kreait\Firebase\Exception\Auth\UserNotFound $e){
				$_SESSION['status'] = "Invalid Email Address";
				header("Location: login.php");
				exit();
			}
        }

	    //edit profile
		public function updateProfile($role,$id, $uid, $fname, $email, $phone, $officeNo){
			require('dbcon.php');
			try{
				if($role =="patient"){
					$updateData=[
						'name'  => $fname,
						'emailAddress'   => $email,
						'phoneNumber'  => $phone
					];
				} else {
					$updateData=[
						'name'  => $fname,
						'emailAddress'   => $email,
						'phoneNumber'  => $phone,
						'officeNumber' => $officeNo
					];
				}
				
				$properties = [
					'displayName' => $fname,
					'email' => $email,
					'emailVerified' => false,
					'phoneNumber' => $phone,
					'disabled' => false,
				];
				$postRef = $database->getReference('user/' . $uid)->update($updateData);
				$updatedUser = $auth->updateUser($id, $properties);
				//$request = \Kreait\Auth\Request\UpdateUser::new()->withDisplayName($fname);
				//$updatedUser = $auth->updateUser($id, $request);
			} catch(Exception $e){
				$e->getMessage();
			}
			

			if($postRef){
				$_SESSION['status']="Updated Successfully";
				header("Location: home.php");
			} else{
				$_SESSION['status']="Update Failed";
				header("Location: home.php");
			}
		}

		public function getProfileDetailsModel($fname){
			$userValue = $this->user->orderByChild('name')->equalTo($fname)->getValue();
			$userSnap = $this->user->orderByChild('name')->equalTo($fname)->getSnapshot();

			$userId = $userSnap->numChildren() + 1;
			if($userSnap->hasChildren()){
				foreach($userValue as $key => $user){
					if($user['name'] == $fname){
						return $user;
					}
				}
			} 
		}

		public function changePasswordModel($id,$uid, $newPassword){
			require('dbcon.php');
			// Create a key for a new post
			$updateData = [
				'password' => $newPassword
			];
			$ref_table = "user/" .$uid;
            $postRef = $database->getReference($ref_table)->update($updateData);
			$userPost = $auth->changeUserPassword($id, $newPassword);
			if($userPost && $postRef){
				$_SESSION["status"] = "Password updated successfully";
				header("Location: home.php");
				exit();
			} else{
				$_SESSION["status"] = "Failure to update password";
				header("Location: home.php");
				exit();
			}
		}

		public function forgetPassword($email){
			require("dbcon.php");
			$link = $auth->sendPasswordResetLink($email);

			if($link){
				$_SESSION["status"] = "Email Sent Successfully.";
				header("Location: login.php");
				exit();
			} else{
				$_SESSION["status"] = "Something Went Wrong.";
				header("Location: login.php");
				exit();
			}
		}
    }
	class Patients extends Users{
		protected $patient;

		function __construct(){
			require 'dbcon.php';
			$this->patients = $database->getReference('patients');
		}

		public function getPatients() {
			if($this->patients->getSnapshot()->hasChildren()) {
			  return $this->patients->getValue();
			}
			else {
			  return array();
			}
		}
		public function getPatientRecords($fname){
			$patientValue = $this->patients->getValue();
            $patientSnap = $this->patients->getSnapshot();

			$patientId = $patientSnap->numChildren() + 1;
			if($patientSnap->hasChildren()){
				foreach($patientValue as $key => $patient){
					if($patient['Name'] == $fname){
						return $patient;
					}
				}
			} 
		}
		
		public function addPatient($uid, $pid, $rid, $fname,$nric,$gender,$email,$password,$confirmPassword,$dob,$phone,$country,$emergencyContact,$emergencyName,$relationship,$role){
			require('dbcon.php');
			date_default_timezone_set('Asia/Singapore');
			$userData=[
				'userId' => $uid,
				'emailAddress' => $email,
				'identityNumber' => $nric,
                'password' => $password,
                'name' => $fname,
                'phoneNumber' => $phone,
				'officeNumber' => '-',
                'role' => $role,
                'accountStatus' => 'Activated',
			];

			$patientData=[
				'userId' => $uid,
				'patientId' => $pid,
				'Name' => $fname,
				'NRIC' => $nric,
				'Sex' => $gender,
				'Phone' => $phone,
				'Email' => $email,
				'DOB' => $dob,
				'Country' => $country,
				'Emergency Contact' => $emergencyContact,
				'Emergency Name' => $emergencyName,
				'Relationship' => $relationship,
			];

			$recordData = [
				'medicalRecordId' => $rid,
          		'patientId' => $pid,

				  'weight' => [
					'value' => '-',
					'dateCreated' => date('j F Y'),
					'timeCreated' => date('h:i:s A')],
		  
					'height' => [
					'value' => '-',
					'dateCreated' => date('j F Y'),
					'timeCreated' => date('h:i:s A')],
		  
					'bmi' => [
					'value' => '-',
					'dateCreated' => date('j F Y'),
					'timeCreated' => date('h:i:s A')],
		  
					'allergy' => [
					'value' => '-',
					'dateCreated' => date('j F Y'),
					'timeCreated' => date('h:i:s A')],
		  
					'bloodPressure' => [
					'value' => '-',
					'dateCreated' => date('j F Y'),
					'timeCreated' => date('h:i:s A')],
		  
					'bloodGlucose' => [
					'value' => '-',
					'dateCreated' => date('j F Y'),
					'timeCreated' => date('h:i:s A')],
		  
					'cholesterol' => [
					'value' => '-',
					'dateCreated' => date('j F Y'),
					'timeCreated' => date('h:i:s A')],
		  
					'immunization' => [
					'value' => '-',
					'dateCreated' => date('j F Y'),
					'timeCreated' => date('h:i:s A')],
		  
					'medication' => [
					'value' => '-',
					'dateCreated' => date('j F Y'),
					'timeCreated' => date('h:i:s A')],
		  
					'medicalHistory' => [
					'value' => '-',
					'dateCreated' => date('j F Y'),
					'timeCreated' => date('h:i:s A')],
		  
					'medicalCondition' => [
					'value' => '-',
					'dateCreated' => date('j F Y'),
					'timeCreated' => date('h:i:s A')]
			];
			try{
			$request = \Kreait\Firebase\Request\CreateUser::new()
			->withUnverifiedEmail($email)
			->withClearTextPassword($password)
			->withDisplayName($fname);

			$ref_table1 = "user/";
			$ref_table2 = "patients/";
			$ref_table3 = "medicalRecords/";
            $postUser = $database->getReference($ref_table1)->push($userData);
			$postPatients = $database->getReference($ref_table2)->push($patientData);
			$postRecords = $database->getReference($ref_table3)->push($recordData);
			$createdUser = $auth->createUser($request);

			if($postUser && $postPatients && $postRecords&&$createdUser){
				$auth->sendEmailVerificationLink($email);
				//echo "<script>input=prompt('Verification link sent to your email');alert(input);</script>";
				$_SESSION['status'] = "User Created Successfully";
				header("location: login.php");
				exit();
			} else{
				$_SESSION['status'] = "User Not Created";
				header("location: login.php");
				exit();
			}
			}  catch (FirebaseException $e) {
				echo 'An error has occurred while working with the SDK: '.$e->getMessage();
			} catch (Throwable $e) {
				echo 'A not-Firebase specific error has occurred: '.$e->getMessage();
			}
		}

		public function searchPatientModel($listVariable, $searchBy)
		{
			require("dbcon.php");
			$ref_table = "patients";

			try{
				$reference = $database->getReference($ref_table)
									  ->orderByChild($searchBy)								
									  ->startAt($listVariable)
									  ->endAt($listVariable. "\uf8ff")
									  ->getValue();
		    }
			catch(Throwable $e)
			{
				echo $e->getMessage(); exit;
			}
			$i = 1;
			
			
			foreach($reference as $patientkey => $row )
			{
				$nric = $row['NRIC'];
           	    $maskedNRIC = substr($nric,0,1).str_repeat('*',4).substr($nric,5,4);
				
				?>
					<tr>
						<td><?=$i++?></td>
						<td><?=$maskedNRIC?></td>
						<td><?=$row['Name']?></td>
						<td><?=$row['DOB']?></td>
						<td><?=$row['Sex']?></td>
						<td><?=$row['Phone']?></td>
						<td><?=$row['Email']?></td>
			
				<td><a href="viewPatientDetail.php?id=<?=$row['patientId']?>" style='color:black;float:center;'>View</a></td>
				</tr>
			 <?php	
					
			}
		}

		//view my patient details
		public function displaymyPatientModel($doctorID)
		{
			require("dbcon.php");
			$reference = "patients/";
			$ref = $database->getReference($reference)
							->orderByChild('doctorId')
							->equalTo($doctorID)
							->getValue();
			$i = 1;
			foreach($ref as $key => $row)
			{
				$nric = $row['NRIC'];
           	    $maskedNRIC = substr($nric,0,1).str_repeat('*',4).substr($nric,5,4);	
			?>
			<tr>
					<td><?=$i++?></td>
					<td><?=$maskedNRIC?></td>
					<td><?=$row['Name']?></td>
					<td><?=$row['DOB']?></td>
					<td><?=$row['Sex']?></td>
					<td><?=$row['Phone']?></td>
					<td><?=$row['Email']?></td>
					<td><a href="viewPatientDetail.php?id=<?=$row['patientId']?>" style='color:black;float:center;'>View</a></td>
				</tr>
			 <?php			
			
			}
		}

		public function getPatientDetailsModel($id)
		{
			require("dbcon.php");
			$reference = "patients/";

			$userValue = $database->getReference($reference)->getValue();
            $userSnap = $database->getReference($reference)->getSnapshot();

            $userId = $userSnap->numChildren() + 1;
            if($userSnap->hasChildren()){
                foreach($userValue as $key => $user){
                    if($user['patientId'] == $id){
                        return $user;
		
					}
                }
            } 
		}

		public function getAppointmentDetailsModel($id)
		{
			require("dbcon.php");
			$reference = "appointments/";

			$userValue = $database->getReference($reference)->getValue();
            $userSnap = $database->getReference($reference)->getSnapshot();

            $userId = $userSnap->numChildren() + 1;
            if($userSnap->hasChildren()){
                foreach($userValue as $key => $user){
                    if($user['doctorName'] == $id){
                        return $user;
		
					}
                }
            } 
		}

		////get Patient Name for Referral
		public function displayPatientNameModel($doctorID)
		{
			require("dbcon.php");
			$reference = "patients/";
			$ref = $database->getReference($reference)
							->orderByChild('doctorId')
							->equalTo($doctorID)
							->getValue();
			$i = 1;
			foreach($ref as $key => $row)
			{
			?>
				<option value="<?=$row['Name']?>"> <?php echo $row['Name']?></option>
			<?php
			}
		}
	}

	class Doctors extends Users {
		protected $doctors;

    	function __construct() {
   		   parent::__construct();
   		   require('dbcon.php');
			$this->doctors = $database->getReference('doctors');
		}

    	public function getDoctors() {
    		  $data = $this->doctors->getValue();

     	 	if($this->doctors->getSnapshot()->hasChildren()) {
    		    return $data;
   		   }
   		   else {
    		    return array();
   		   }
   		}
		public function addDoctor($uid, $doctorId, $fname, $email, $identityNumber, $phone, $officeNo, $gender, $role, $department, $venue, $password){
			require ('dbcon.php');
			$data=[
				'userId' => $uid,
				'emailAddress' => $email,
				'identityNumber' => $identityNumber,
				'password' => $password,
				'name' => $fname,
				'phoneNumber' => $phone,
				'officeNumber' => $officeNo,
                'gender' => $gender,
				'role' => $role,
				'department' => $department,
				'venue' => $venue,
				'accountStatus' => 'Activated'
			];
			$doctorData = [
				'userId' => $uid,
				'doctorId' => $doctorId,
				'emailAddress' => $email,
				'identityNumber' => $identityNumber,
				'name' => $fname,
				'phoneNumber' => $phone,
				'officeNumber' => $officeNo,
                'gender' => $gender,
				'role' => $role,
				'department' => $department,
				'venue' => $venue,
			];

			$userProperties =[
				'email' => $email,
				'emailVerified' => false,
				'Password' => $password,
                'displayName' => $fname,
				'disabled' => false
			];

			$ref_table1 = "user";
			$ref_table2 = "doctors";
            $postRef = $database->getReference($ref_table1)->push($data);
			$postDoctor = $database->getReference($ref_table2)->push($doctorData);
			$createdUser = $auth->createUser($userProperties);

			if($postRef && $postDoctor && $createdUser){
				$auth->sendEmailVerificationLink($email);
				//echo "<script>input=prompt('Verification link sent to your email');alert(input);</script>";
				$_SESSION['status'] = "User Created Successfully";
				header("location: user.php");
				exit();
			} else{
				$_SESSION['status'] = "User Not Created";
				header("location: user.php");
				exit();
			}  
		}

		public function displayDoctorIDModel($fname)
		{
			require("dbcon.php");
			$reference = "doctors/";
			
			$userValue = $database->getReference($reference)->getValue();
			$userSnap = $database->getReference($reference)->getSnapshot();

			if($userSnap->hasChildren())
			{
                foreach($userValue as $key => $user)
				{
                    if($user['name'] == $fname)
					{
                        return $user;
					}
				
				}
			}
		}

		public function getToDoctorNamesModel($department)
		{
			require("dbcon.php");
			$reference = "doctors/";
			$ref = $database->getReference($reference)
							->orderByChild('department')
							->equalTo($department)
							->getValue();

	
			foreach($ref as $key => $row)
			{
			?>
				<option value="<?=$row['name']?>"> <?php echo $row['name']?></option>
			<?php
			}
		}

		public function getReferredDoctorIDModel($fname, $toDepartment)
		{
			require("dbcon.php");
			$reference = "doctors/";
		
			$userValue = $database->getReference($reference)->getValue();
			$userSnap = $database->getReference($reference)->getSnapshot();

			if($userSnap->hasChildren())
			{
                foreach($userValue as $key => $user)
				{
                    if($user['name'] == $fname && $user['department'] == $toDepartment)
					{
                        return $user;
					}
				
				}
			}
		}

		public function displayDoctorListModel()
		{
			require("dbcon.php");
			$reference = "doctors/";
			$ref = $database->getReference($reference)						
							->getValue();

		    $i = 1;
			foreach($ref as $key => $row)
			{
			?>
			<tr>
				<td><?=$i++?></td>				
				<td><?=$row['name']?></td>
				<td><?=$row['officeNumber']?></td>
				<td><?=$row['department']?></td>
				
			</tr>
		 <?php		
			}
		}

		public function getDoctorDepartmentModel($doctorID)
		{
			require("dbcon.php");
			$reference = "doctors/";
			$userValue = $database->getReference($reference)->getValue();
			$userSnap = $database->getReference($reference)->getSnapshot();
			if($userSnap->hasChildren()){
                foreach($userValue as $key => $user)
				{
                    if($user['doctorId'] == $doctorID)
					{
                        return $user;
					}
				}
			}
		}

		public function getToDepartmentModel($referralTo)
		{
			require("dbcon.php");
			$reference = "doctors/";
			$userValue = $database->getReference($reference)->getValue();
			$userSnap = $database->getReference($reference)->getSnapshot();
			if($userSnap->hasChildren()){
                foreach($userValue as $key => $user)
				{
                    if($user['name'] == $referralTo)
					{
                        return $user;
					}
				}
			}
		}

		public function setDoctorRecordsModel($doctorName){
			require("dbcon.php");
			$doctorValue = $database->getReference("doctors")->getValue();
            $doctorSnap = $database->getReference("doctors")->getSnapshot();

			if($doctorSnap->hasChildren()){
				foreach($doctorValue as $key => $doctor){
					if($doctor['name'] == $doctorName){
						return $doctor;
					}
				}
			} 
		}
	}

	class MedicalAdministrator extends Users{
		protected $medAdmin;

		function __construct(){
			require('dbcon.php');
			$this->user = $database->getReference('medical');
      		$this->userError = $database->getReference('userError');
		}
		public function addMedAdmin($uid, $fname, $email, $identityNumber, $phone, $officeNo, $role, $department, $venue, $password){
			require ('dbcon.php');
			$data=[
				'userId' => $uid,
				'emailAddress' => $email,
				'identityNumber' => $identityNumber,
				'password' => $password,
				'name' => $fname,
				'phoneNumber' => $phone,
				'officeNumber' => $officeNo,
				'role' => $role,
				'accountStatus' => 'Activated'
			];

			$userProperties =[
				'email' => $email,
				'emailVerified' => false,
				'Password' => $password,
                'displayName' => $fname,
				'disabled' => false
			];

			$ref_table = "user";
            $postRef = $database->getReference($ref_table)->push($data);
			$createdUser = $auth->createUser($userProperties);

			if($postRef && $createdUser){
				$auth->sendEmailVerificationLink($email);
				//echo "<script>input=prompt('Verification link sent to your email');alert(input);</script>";
				$_SESSION['status'] = "User Created Successfully";
				header("location: user.php");
				exit();
			} else{
				$_SESSION['status'] = "User Not Created";
				header("location: user.php");
				exit();
			}
		}

		public function deactivateUserModel($id, $uid, $isMedicalAdmin){
			require('dbcon.php');
			$updateData=[
				'accountStatus' => 'Deactivated'
			];

      		if(!$isMedicalAdmin) {
     			$reference = 'user/'.$id;
  				$postRef = $database->getReference($reference)->update($updateData);
				
      		}
			else {
        		$ref = $database->getReference('user');
  	 	 	    foreach($ref->getValue() as $key => $val) {
 			        if($val['userId'] == $id) {
            			$postRef = $ref->getChild($key)->update($updateData);
          			}
        		}
      		}			
			$updatedUser = $auth->disableUser($uid);

			if($postRef && $updatedUser){
				$_SESSION["status"] = "Updated Successfully";
        		if(!$isMedicalAdmin) header("Location: user.php");
        		else header("Location: patientProfile.php");
				exit();
			} else{
				$_SESSION["status"] = "Updated Failed";
        		if(!$isMedicalAdmin) header("Location: user.php");
       			else header("Location: patientProfile.php");
				exit();
			}
		}
	}
?>