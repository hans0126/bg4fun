<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends Frontend_Controller {

    function __construct() {

        parent::__construct();
        $this -> load -> Model("Bgg_Parser_Model");
    }

    public function index() {       
       $data=array();  
       $this->display("search/view",$data);       
    }
    
    public function search_result() {        
           $result=$this-> Bgg_Parser_Model-> searchFromBgg($_POST['keyword']);           
            echo json_encode($result['result']);           
    }
    
    public function bg_detail() {       
           $result=$this-> Bgg_Parser_Model-> getGameFromBgg($_POST['bgg_id']);           
            echo json_encode($result);          
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
