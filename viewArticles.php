<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRM System</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<script src="https://use.fontawesome.com/5def5740b2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script>
        function showArticle(){
            var article = document.getElementById("article");
            var feed = document.getElementById("feed");

            if(article.style.display === "none") {
                article.style.display = "block";
                feed.style.display = "none";
            } else {
                article.style.display = "none";
                feed.style.display = "none";
            }
        }

        function showFeed(){
            var article = document.getElementById("article");
            var feed = document.getElementById("feed");

            if(feed.style.display === "none") {
                article.style.display = "none";
                feed.style.display = "block";
            } else {
                article.style.display = "none";
                feed.style.display = "none";
            }
        }
    </script>
	<style>
		* {box-sizing: border-box;}
		body {font-family: Verdana, sans-serif;}
		.mySlides {display: none;}
		img {vertical-align: middle;}

		/* Slideshow container */
		.slideshow-container {
		  max-width: 1000px;
		  position: relative;
		  margin: auto;
		}

		/* Caption text */
		.text {
		  color: #f2f2f2;
		  font-size: 15px;
		  padding: 8px 12px;
		  position: absolute;
		  bottom: 8px;
		  width: 100%;
		  text-align: center;
		}

		/* Number text (1/3 etc) */
		.numbertext {
		  color: #f2f2f2;
		  font-size: 12px;
		  padding: 8px 12px;
		  position: absolute;
		  top: 0;
		}

		/* The dots/bullets/indicators */
		.dot {
		  height: 15px;
		  width: 15px;
		  margin: 0 2px;
		  background-color: #bbb;
		  border-radius: 50%;
		  display: inline-block;
		  transition: background-color 0.6s ease;
		}

		.active {
		  background-color: #717171;
		}

		/* Fading animation */
		.fade {
		  -webkit-animation-name: fade;
		  -webkit-animation-duration: 1.5s;
		  animation-name: fade;
		  animation-duration: 1.5s;
		}

		@-webkit-keyframes fade {
		  from {opacity: .4}
		  to {opacity: 1}
		}

		@keyframes fade {
		  from {opacity: .4}
		  to {opacity: 1}
		}

		/* On smaller screens, decrease text size */
		@media only screen and (max-width: 300px) {
		  .text {font-size: 11px}
		}
	</style>
</head>
<body>
    <?php
    include("authentication.php");
    include("includes/authHeader.php");
	include("Controllers/articleController.php");
    $article = new articleController();
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>
							Educational Articles
							<a href="home.php" class="btn btn-danger float-end">Back</a>
                    	</h3>
                    </div>
					<div class="col">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <button class="nav-link" onclick="showArticle();">Educational Articles</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" onclick="showFeed();">News Feeds</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
						<div id="article" style="display:none;">
							<div>
								<input type="search" name="searchBar" placeholder="Search" id="searchBar" oninput="search(this.value)">
								<label class="ms-2" for="searchType">Search by: </label>
								<select name="searchType" id="searchType" onchange="search(this.parentElement.firstElementChild.value)">
									<option value="All">All</option>
									<option value="Title">Title</option>
									<option value="Categories">Categories</option>
								</select>
							</div>
							<div id="results"></div>
							<div id="contents">
								<?php
									$article->viewPatientArticle();
								?>
							</div>
						</div>
						<div id="feed" style="display:none;">
							<form>
								<select class="form-select" aria-label="Default select example" onchange="showRSS(this.value)">
									<option value="">Select an RSS-feed:</option>
									<option value="MOH">Ministry Of Health Singapore-Latest</option>
									<option value="Nutrition">Recipes </option>
								</select>
							</form>
							<div id="rssOutput">RSS-feed will be listed here...</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<script>
		var slideIndex = 0;
		showSlides();

		function showSlides() {
		  var i;
		  var slides = document.getElementsByClassName("mySlides");
		  var dots = document.getElementsByClassName("dot");
		  for (i = 0; i < slides.length; i++) {
			slides[i].style.display = "none";
		  }
		  slideIndex++;
		  if (slideIndex > slides.length) {slideIndex = 1}
		  for (i = 0; i < dots.length; i++) {
			dots[i].className = dots[i].className.replace(" active", "");
		  }
		  slides[slideIndex-1].style.display = "block";
		  dots[slideIndex-1].className += " active";
		  setTimeout(showSlides, 10000); // Change image every 2 seconds
		}


		function search(term) {
			var type = $('#searchType').val();
			var data = [term, type, 'patient'];

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
    <script>
        function showRSS(str) {
			  if (str.length==0) {
				document.getElementById("rssOutput").innerHTML="";
				return;
			  }
			  if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			  } else {  // code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			  xmlhttp.onreadystatechange=function() {
				if (this.readyState==4 && this.status==200) {
				  document.getElementById("rssOutput").innerHTML=this.responseText;
				}
			  }
			  xmlhttp.open("GET","includes/getrss.php?q="+str,true);
			  xmlhttp.send();
			}
    </script>
</body>
</html>
