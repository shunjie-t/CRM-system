<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Billing Records</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        session_start();
        include ('dbcon.php');
        if(isset($_POST['submit'])){
            $title = $_POST['title'];
            $minAmount = $_POST['minAmount'];
            $maxAmount = $_POST['maxAmount'];

            $data= [
                'title' => $title,
                'minAmount' => $minAmount,
                'maxAmount' => $maxAmount
            ];


            $ref_table = "billing";
            $postRef = $database->getReference($ref_table)->push($data);

			if($postRef){
				$_SESSION['status'] = "Records Created Successfully";
				header("location: addBilling.php");
				exit();
			} else{
				$_SESSION['status'] = "Records Not Created";
				header("location: addBilling.php");
				exit();
			}

        }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                    if(isset($_SESSION['status'])) {
                        echo "<h5 class='alert alert-success'>".$_SESSION['status']."</h5>";
                        unset($_SESSION['status']);
                    }
                ?>
                <div class="card">
                    <div class="card-body">
                    <form action="addBilling.php" method="post">
						<div class="form-group mb-3">
							<label>Title: </label>
							<input type="text" class="form-control" name="title" id="title">
						</div>
                        <div class="form-group mb-3">
							<label>Minimum amount: </label>
							<input type="text" class="form-control" name="minAmount" id="minAmount">
                        </div>
						<div class="form-group mb-3">
							<label>Maximum Amount: </label>
							<input type="text" class="form-control" name="maxAmount" id="maxAmount">
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" name="submit" class="btn btn-primary">submit</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>