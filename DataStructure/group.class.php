<?php    

    include_once ('../Application/commonFunctions.php');

    class Group{
        
        public $groupName;
        public $groupCreator;
        public $groupAdm1;
        public $groupAdm2;
        public $groupGenre;
        public $bookId;
        public $maxParticipants;
        public $participants = array();           
        
        // public function __construct($groupName, $groupCreator, $groupAdm1 = null, $groupAdm2 = null, $groupGenre = null, $currentBookId = null, $maxParticipants, $participants = null){
        //     $this->groupName = $groupName;
        //     $this->groupCreator = $groupCreator;
        //     $this->groupAdm1 = $groupAdm1;
        //     $this->groupAdm2 = $groupAdm2;  
        //     $this->groupGenre = $groupGenre;
        //     $this->bookId = $currentBookId;
        //     $this->maxParticipants = $maxParticipants;
        //     $this->participants = $participants;                            
        // }                       

    }