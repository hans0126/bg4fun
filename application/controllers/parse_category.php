<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Home extends Frontend_Controller {

	function __construct() {

		parent::__construct();
		//$this -> load -> Model("sss_Model", "main_model");
	}

	public function index() {
			$this->load->library('simple_html_dom');
			$html = file_get_html('http://boardgamegeek.com/browse/boardgamecategory');
		
			foreach($html->find('#main_content a') as $element) {			
				preg_match('/boardgamecategory/',$element->href , $matches_category);
				if($matches_category){
					preg_match('/[0-9][0-9]*/',$element->href , $matches);
					$host = $matches[0];			
					echo "(".$host.")".'-'.$element->innertext."<br/>";
				}				
			 //  echo $element->innertext."<br/>";
			   
			}
		
		echo "<hr/>";
	}
	
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
