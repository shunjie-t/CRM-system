<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRM System</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
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
    $ref_table = "articles/";
    $count = $database->getReference($ref_table)->getSnapshot()->numChildren();
    $increment = $count + 1;
    $articleId = $link = $title = $description = "";
    class createArticleUI{
        public function validateArticle($article, $increment, $link, $title, $description){
            if(isset($_POST["createPost"])){
                $articleId = $increment;

                $link = $_FILES["articlesFile"]["name"];
								$fileTmpName = $_FILES["articlesFile"]["tmp_name"];
								$fileExt = explode('.', $link);
								$fileExt = strtolower(end($fileExt));
								$allowedExt = ['jpg','jpeg','png','gif'];

                $title = $_POST["articlesTitle"];
								$category = $_POST['articlesCategory'];
                $description = $_POST["description"];

								if(in_array($fileExt, $allowedExt)) {
									if($_FILES['articlesFile']['error'] === 0) {
										move_uploaded_file($fileTmpName, 'images/'.$link);
										$article->validateArticle($articleId, $link, $title, $category, $description);
									}
									else {
										echo "<div style='color: red; font-weight: bold;'>
										<label>Error uploading file.</label>
										</div>";
									}
								}
								else {
									echo "<div style='color: red; font-weight: bold;'>
									<label>File type not allowed.</label>
									</div>";
								}
            }
        }
    }

    $main = new createArticleUI();
    $main -> validateArticle($article, $increment, $link, $title, $description);
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        Post Articles
                        <a href="viewAllArticles.php" class="btn btn-danger float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form method="post" name="createPost" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Articles Input</label>
                            <input class="form-control" type="file" name="articlesFile" id="articlesFile">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Article Title</label>
                            <input class="form-control" type="text" name="articlesTitle" id="articlesTitle">
                        </div>
												<div class="mb-3">
													<label for="articlesCategory" class="form-label">Article Categories</label>
													<select class="form-control" name="articlesCategory">
														<option value="Educational Articles Categories">Educational Articles Categories</option>
														<option value="Exercise & Fitness">Exercise & Fitness</option>
														<option value="Mind & Balance">Mind & Balance</option>
														<option value="Senior Health & Caregiving">Senior Health & Caregiving</option>
														<option value="Conditions and Illnesses">Conditions and Illnesses</option>
													</select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Article Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Enter some description on article"></textarea>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" name="createPost">Create Post</button>
                        </div>
                    </form>
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
