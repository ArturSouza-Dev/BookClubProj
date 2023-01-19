<?php    

    include_once ('../Application/commonFunctions.php');

    class Post {
        
        public $postId;
        public $creator;
        public $content;
        public $postedDate;  
        public $postComments = array();  
        public $maxComments = 20;           
        
        // public function __construct($creator, $content, $postedDate) {     
        //     $this->postId = getPostId();       
        //     $this->creator = $creator;
        //     $this->content = $content;
        //     $this->postedDate = $postedDate;                    
        // }                        
        
    }