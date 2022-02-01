<?php
    include ("./articleModel.php");
    class articleController{
        protected $articleId;
        protected $link;
        protected $title;
        protected $category;
        protected $description;

        protected $articleIdArray = array();
        protected $linkArray = array();
        protected $titleArray = array();
        protected $categoryArray = array();
        protected $descriptionArray = array();

        function __construct() {
          $this->setArrays();
        }
        public function getArticleId(){
            return $this->articleId;
        }
        public function getLink(){
            return $this->link;
        }
        public function getTitle(){
            return $this->title;
        }
        public function getCategory(){
            return $this->category;
        }
        public function getDescription(){
            return $this->description;
        }
        public function getArticleIdArray() {
          return $this->articleIdArray;
        }
        public function getLinkArray($aid = null) {
          if(!is_null($aid)) return $this->linkArray[$aid];
          return $this->linkArray;
        }
        public function getTitleArray($aid = null) {
          if(!is_null($aid)) return $this->titleArray[$aid];
          return $this->titleArray;
        }
        public function getCategoryArray($aid = null) {
          if(!is_null($aid)) return $this->categoryArray[$aid];
          return $this->categoryArray;
        }
        public function getDescriptionArray($aid = null) {
          if(!is_null($aid)) return $this->descriptionArray[$aid];
          return $this->descriptionArray;
        }
        
        public function setArrays() {
          $article = new articleModel();
          $data = $article->getArrayData();
          foreach($data as $v) {
            array_push($this->articleIdArray, $v['articleId']);
            $this->linkArray[$v['articleId']] = $v['file'];
            $this->titleArray[$v['articleId']] = $v['title'];
            $this->categoryArray[$v['articleId']] = $v['category'];
            $this->descriptionArray[$v['articleId']] = $v['description'];
          }
        }

         public function validateArticle($articleId, $link, $title, $category, $description){
            $errors = Array();
            $article = new articleModel();

            if(empty($link)){
                array_push($errors, "Article File is required");
            }
            if(empty($title)){
                array_push($errors, "Title is required");
            }

            if (count($errors) > 0) {
                echo "<div style='color: red; font-weight: bold;'>";
                foreach ($errors as $error) {
                  echo "<label>$error</label><br>";
                }
                echo "</div>";
            }

            if(count($errors) == 0){
                $article->createArticle($articleId, $link, $title, $category, $description);
            }
        }

        public function viewArticleList(){
            $article = new articleModel();
            $article->viewArticleModel();
        }
        public function viewPatientArticle(){
            $article = new articleModel();
            $article->viewPatientArticleModel();
        }

        public function viewArticleDescription($title){
            $article = new articleModel();
            $article->viewArticleDescriptionModel($title);
        }
        
        public function search($data) {
          $term = substr($data, 0, strpos($data, ","));
          $data = substr($data, (strpos($data,",") + 1));
          $filter = substr($data, 0, strpos($data, ","));
          $user = substr($data, (strpos($data, ",") + 1));
          $field = ["Title","Categories"];
          $value = [$this->getTitleArray(), $this->getCategoryArray()];
          $result = "";
          $match = array();

          foreach($field as $key1 => $val1) {
            if($filter == $val1 || $filter == "All") {
              foreach($value[$key1] as $key2 => $val2) {
                if(strpos(strtolower($val2), strtolower($term)) !== false && !in_array($key2, $match)) {
                  array_push($match, $key2);
                }
              }
            }
          }

          if($user == "medical administrator") {
            if(!empty($match)) {
              foreach($match as $val) {
                $result .= "<tr><td>" . $val . "</td><td> " . $this->getTitleArray($val) . "</td><td>" . $this->getCategoryArray($val) . "</td><td><img src='images/" . $this->getLinkArray($val) . "' alt='" . $this->getLinkArray($val) . "' class='img-fluid' width='400px' height='50px'></td></tr>";
              }
            }
            else {
              $result .= "<tr>
                <td align='center' colspan='4'>No record found</td>
              </tr>";
            }
          }
          else if($user == "patient") {
            if(!empty($match)) {
              $result .= "<div class='row'>";
              foreach($match as $val) {
                $result .= "<hr class='my-3'>
                <div class='col-4'>
                  <a href='viewArticleDescription.php?title=" . $this->getTitleArray($val) . "'>
                    <img src='images/" . $this->getLinkArray($val) . "' class='img-fluid' width='400px' height='50px'>
                  </a>
                </div>
                <div class='col-4'>
                  <h5>Title</h5>
                  <p>" . $this->getTitleArray($val) . "</p>
                </div>
                <div class='col-4'>
                  <h5>Category</h5>
                  <p>" . $this->getCategoryArray($val) . "</p>
                  <a href='viewArticleDescription.php?title=" . $this->getTitleArray($val) . "' class='btn btn-primary' style='text-align:center;float:right;'>View</a>
                </div>";
              }
              $result .= "</div>";
            }
            else {
              $result .= "<div class='d-flex justify-content-center'>
                <h5 class='mt-5'>No record found</h5>
              </div>";
            }
          }
          return $result;
        }
    }
?>