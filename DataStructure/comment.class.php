<?php

    include_once ('../Application/commonFunctions.php');

    class Comment{
        
        public $commentId;
        public $postId;
        public $creator;
        public $content;        
        public $postedDate;
        
        // public function __construct($postId, $creator, $content){     
        //     $this->commentId = getCommentId();       
        //     $this->postId = $postId;
        //     $this->creator = $creator;
        //     $this->content = $content;
        //     $this->postedDate = date("Y/m/d");                                    
        // }                

    }