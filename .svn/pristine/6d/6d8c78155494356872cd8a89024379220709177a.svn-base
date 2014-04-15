<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Language_Model extends It_Model
{
	public $main_table_name = "avail_language";
	public $main_field_prefix = "";

	public $language_table_name = "language";
	public $language_field_prefix = "";

	public $region_table_name = "region";
	public $region_field_prefix = "";
	
	function __construct() 
	{
		parent::__construct();	  
	}	

	
	public function GetList( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql = "	SELECT 	SQL_CALC_FOUND_ROWS
							sn,language_name,language_value
					FROM
					sys_avail_language									
					WHERE ( 1 )
					";

		if( $condition != NULL )
		{
			$sql .= " AND ( ".$condition." ) ";
		}		
		
		$sql .= $this->getSortSQL( $sort );
			
		$sql .= $this->getLimitSQL( $rows , $page );
		
		$data = array
		(
			"sql" => $sql ,
			"data" => $this->readQuery( $sql ) ,
			"count" => $this->getRowsCount()
		);		
		//echo $sql;
		return $data;
	}	

    public function getLanguageList(){
       //讀取語系
        $where=" launch=1";
        $field="sn,language_name,language_value";
        $sort=array("is_default"=>"DESC");
        $lang_list = $this->main_model->listDB("sys_avail_language",$field,$where,null,null,$sort);        
        return $lang_list['data'];       
    }
    
    public function getLanguageWord(){
        //讀取語系標頭
        $sort=array("value_name"=>"ASC");
        $where=" type=0";
        $field="sn,title,value_name";
        $dataList = $this->main_model->listDB("sys_language_word",$field,$where,null,null,$sort);        
        return $dataList['data'];
    }
    
    
    public function getDefaultLanguage(){       
        $where=" is_default=1";       
        $dataList = $this->listDB("sys_avail_language","language_name,language_value,sn",$where);  
        return  $dataList['data'][0];   
    }
    
}