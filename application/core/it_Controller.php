<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class IT_Controller extends CI_Controller 
{
	
	public $language_value = "";
	public $language_sn = "";
	public $language_name = "";
	public $language_select_list = array();	
	
	
	function __construct() 
	{
		parent::__construct();

	}	
	
	protected function getLanguageList()
	{		
		$list = $this->language_model->GetList( );
		$this->language_select_list = $list["data"];	
	}
	
	protected function getLanguageInfo()
	{
		
		if($this->language_value == NULL)
		{
			return array();
		}
		
		$condition = "language_value = '".$this->language_value."'";		
		$list = $this->language_model->GetList( $condition );
		$list = $list["data"];
		return $list;		
	}


}

require('Backend_Controller.php');
require('Frontend_Controller.php');