<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRM System</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
</head>
<body>
<?php
	include("authentication.php");
	include("includes/authHeader.php");
    include("Controllers/articleController.php");
    $article = new articleController();
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
            <div class="card">
                <div class="card-header">
                    <h3>
                        View All Articles
                        <a href="home.php" class="btn btn-danger float-end">Back</a>
                        <a href="postArticles.php" class="btn btn-primary float-end">Post New Articles</a>
                    </h3>
                </div>
                <div class="card-body">
									<div>
										<input type="search" name="searchBar" placeholder="Search" id="searchBar" oninput="search(this.value)">
										<label class="ms-2" for="searchType">Search by: </label>
					          <select name="searchType" id="searchType" onchange="search(this.parentElement.firstElementChild.value)">
											<option value="All">All</option>
											<option value="Title">Title</option>
											<option value="Categories">Categories</option>
					          </select>
									</div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
															<th>ID</th>
															<th>Title</th>
															<th>Category</th>
															<th>Image</th>
                            </thead>
														<tbody id="results"></tbody>
                            <tbody id="contents">
                                <?php
                                    $article->viewArticleList();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

   <!-- The core Firebase JS SDK is always required and must be listed first -->
	<script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-app.js"></script>

	<!-- TODO: Add SDKs for Firebase products that you want to use
		 https://firebase.google.com/docs/web/setup#available-libraries -->
	<script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-analytics.js"></script>

	<script type="text/javascript">
		function search(term) {
			var type = $('#searchType').val();
			var data = [term, type, 'medical administrator'];

			fetch('searchArticle.php', {
				method: 'post',
				body: new URLSearchParams('term=' + data)
			})
			.then(res => res.text())
			.then(res => output(res))
			.catch(e => console.error('Error: ' + e));
		}

		function output(data) {
			if(!$('#searchBar').val()) {
				$('#contents').show();
				$('#results').empty();
			}
			else {
				$('#contents').hide();
				$('#results').html(data);
			}
		}
	</script>

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
