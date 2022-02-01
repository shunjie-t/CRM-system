<?php
    class articleModel{
        public function __construct() {
            chdir(__DIR__);
        }

       public function createArticle($articleId, $link, $title, $category, $description){
            require("dbcon.php");
            $data =[
                'articleId' => $articleId,
                'file' => $link,
                'title' => $title,
                'category' => $category,
                'description' => $description
            ];

            $ref_table = "articles/";
            $reference = $database->getReference($ref_table)->push($data);

            if($reference){
                $_SESSION['status'] = "Article Created Successfully";
				header("location: viewAllArticles.php");
				exit();
            } else {
                $_SESSION['status'] = "Article Not Created";
				header("location: viewAllArticles.php");
				exit();
            }
        }

        public function viewArticleModel(){
            require("dbcon.php");
            $articleValue = $database->getReference("articles")->getValue();

            $i =1;
            foreach($articleValue as $key => $article){
                ?>
                    <tr>
                        <td><?=$i++;?></td>
                        <td><?=$article["title"];?></td>
                        <td><?=$article["category"];?></td>
                        <td><img src="images/<?=$article["file"];?>" alt="<?php $article["file"]; ?>" class="img-fluid" width="400px" height="50px"></td>
                    </tr>
                <?php
            }
        }

        public function viewPatientArticleModel(){
            require("dbcon.php");
            $articleValue = $database->getReference("articles")->getValue();

            $i=1;
            ?>
            <div class="row">
            <?php
            foreach($articleValue as $key => $article){
                ?>
                    <hr class="my-3">
                    <div class="col-4">
                      <a href="viewArticleDescription.php?title=<?=$article["title"];?>">
                        <img src="images/<?=$article['file'];?>" class="img-fluid" width="400px" height="50px">
                      </a>
                    </div>
                    <div class="col-4">
                      <h5>Title</h5>
                      <p><?=$article["title"];?></p>
                    </div>
                    <div class="col-4">
                      <h5>Category</h5>
                      <p><?=$article["category"];?></p>
                      <a href="viewArticleDescription.php?title=<?=$article["title"];?>" class="btn btn-primary" style="text-align:center;float:right;">View</a>
                    </div>
                <?php
            }
            ?>
            </div>
            <?php
        }

        public function viewArticleDescriptionModel($title){
            require("dbcon.php");
                $articleValue = $database->getReference("articles")->orderByChild("title")->equalTo($title)->getValue();
            
                foreach($articleValue as $key => $article){
                ?>
                    <div class="card">
                        <div class="card-header">
                            <h4><?=$article["title"];?></h4>
                        </div>
                        <div class="card-body">
                            <h6 style="white-space: pre-line"><?=$article["description"];?></h6>
                        </div>
                    </div>
                <?php
                }
        }
        
        public function getArrayData() {
          require("dbcon.php");
          $result = $database->getReference("articles")->getValue();
          return $result;
        }
        
        public function getAllTitleModel() {
          require("dbcon.php");
          $articleValue = $database->getReference("articles")->getValue();
          $result = array();
          foreach($articleValue as $val) {
            $result[$val['articleId']] = $val['title'];
          }
          return $result;
        }
        
         public function getAllCategoryModel() {
          require("dbcon.php");
          $articleValue = $database->getReference("articles")->getValue();
          $result = array();
          foreach($articleValue as $key => $val) {
            $result[$val['articleId']] = $val['category'];
          }
          return $result;
        }
    }
?>