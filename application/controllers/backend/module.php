<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends Backend_Controller 
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->Model("module_model","main_model");
		//$this->lang->load("admin",$this->language_value);
	}
	
	public function index($lan_sn=NULL,$mod_sn=NULL)
	{
		
		//語言sn
		
		$data['language_select_list']=$this->language_select_list;
				
		//module_group
		$tableName="sys_module_category";
		$field="sn,title";
		$sort=array("sort"=>"ASC");
		$dataList = $this->main_model->listDB($tableName,$field,NULL,NULL,NULL,$sort);
		$data['module_select_list']=$dataList['data'];
	
		
		if($lan_sn==''){
		    if(MULTIPLE_LANGUAGES){
			     $lan_sn=$data['language_select_list'][0]['sn'];
            }else{
                $lan_sn=$this->basic_language['sn'];  
               
            }
		}
		
		if($mod_sn==''){
			$mod_sn=$data['module_select_list'][0]['sn'];
		}		
	
	
		$query="/".$lan_sn."/".$mod_sn;
		
			
		$data['url']=array("edit"=>bUrl('edit').$query
							,"del"=>bUrl("delete").$query
							,"sort"=>bUrl("dataSort").$query
							,"ajax"=>bUrl("get_module").$query
							,"index"=>bUrl("index")
							,"copy"=>bUrl('edit')
                            ,"launch"=>"ajax_launch");			
		
		$tableName="(sys_module a inner join sys_module_category b   
					on a.module_category_sn = b.sn) ";
					
		$field="a.title
				,a.id
				,a.sort
				,a.launch
				,a.sn
				,b.title as gtitle";
				
		$where="a.module_category_sn=".$mod_sn."
				and a.avail_language_sn=".$lan_sn;
		
		$sort= array("a.module_category_sn"=>"ASC"
					,"a.sort"=>"asc");
		
		$dataList = $this->main_model->listDB( $tableName , $field , $where , NULL , NULL , $sort);
	
		$dataCount=$dataList["count"];
		$dataList=$dataList['data'];
			
		
		
		
		foreach($dataList as $key=>$value){
			$arr_temp=$this->main_model->listDB( "sys_module" , "avail_language_sn" , "id='".$value['id']."'" , NULL,NULL , array("avail_language_sn"=>"ASC"));			
			foreach($arr_temp['data'] as $key2=>$value2){				
				$dataList[$key]['language'][]=$value2['avail_language_sn'];			
			}			
		}		
		
		$data["list"] = $dataList;
		$data["lan_sn"]=$lan_sn;
		$data["mod_sn"]=$mod_sn;
		//取得分頁
			
		$data["pager"]=NULL;		
		$this->display("module_list_view",$data);
	}
	
	
	/*編輯*/
	public function edit($lan_sn,$mod_sn,$sn="",$copy=0)
	{
		
		$data['url']=array("action"=>bUrl('update')."/".$lan_sn."/".$mod_sn);
			
		$dataList = $this->main_model->listDB( "sys_module_category" , "sn,title" );
		$data['copy']=$copy;
		$data["module_category"] = 	$dataList['data'];
				
		if($sn == "")
		{			
			$data['edit_data']=array("launch"=>1);							
			$this->display("module_edit_view",$data);
		}
		else 
		{
			$dataList = $this->main_model->listDB("sys_module",NULL,"sn =".$sn);
		
			if(count($dataList["data"])>0)
			{												
				$data["edit_data"] =$dataList["data"][0];				
				$this->display("module_edit_view",$data);
			}
			else
			{
				redirect(bUrl("index"));	
			}
		}
	}
	
	/*更新*/
	public function update($lan_sn,$mod_sn)
	{
		
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}	
		
		if ( ! $this->_validate() )
		{
			$data["edit_data"] = $edit_data;
			$data['url']=array("action"=>bUrl('update')."/".$lan_sn."/".$mod_sn);
			$dataList = $this->main_model->listDB( "sys_module_category" , "sn,title" );		
			$data["module_category"] = 	$dataList['data'];	
					
			$this->display("module_edit_view",$data);
		}			
        else 
        {
        	
			$sn = $edit_data["sn"];
						
        	$arr_data = array(
				"title" => $this->input->post('title',TRUE),
				"id" => $this->input->post('id',TRUE),
				"sort" => $this->input->post('sort',TRUE),
				"module_category_sn" => $this->input->post('module_category',FALSE),
				"avail_language_sn"=>$lan_sn			
			);
			
			if($sn != FALSE)
			{
				$arr_return=$this->main_model->updateData( "sys_module" , $arr_data,"sn =".$sn );				
				
				if($arr_return['success'])
				{
					$this->showSuccessMessage();					
				}
				else 
				{
					$this->showFailMessage();
				}
				
			}
			else 
			{
				$arr_return = $this->main_model->addData( "sys_module" , $arr_data );
				
				
				if($arr_return['id'] > 0)
				{
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
					
			}
			
			redirect(bUrl("index")."/".$lan_sn."/".$mod_sn);	
        }	
	}
	/*刪除*/
	public function delete($lan_sn,$mod_sn)
	{
	
		$del_ary =array('sn'=> $this->input->post('del',TRUE));		
		
       
		if($del_ary!= FALSE && count($del_ary)>0)
		{			
			$this->main_model->deleteDB( "sys_module",NULL,$del_ary );					
		}	
		
     	
		$this->showSuccessMessage();
		redirect(bUrl("index", FALSE)."/".$lan_sn."/".$mod_sn);	
	}
	
	
	/*排序*/
	public function dataSort($lan_sn,$mod_sn)
	{	
		
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}		
		
		foreach($edit_data as $key => $value){
			if(is_numeric($key) && is_numeric($value)){				
				$arr_data=array("sort"=>$value);
				$arr_return=$this->main_model->updateData( "sys_module" , $arr_data,"sn =".$key );				
			}
		}		
		
		$this->showSuccessMessage();
		redirect(bUrl("index")."/".$lan_sn."/".$mod_sn);	
	}	
	
    
    public function ajax_launch() {
      
        $arr_data = array("launch" => $_POST['launch']);
        $arr_return = $this -> main_model -> updateDB("sys_module", $arr_data, "sn =" . $_POST['sn']);
        unset($arr_return['sql']);
        echo json_encode($arr_return);
    }
    
	/*資料驗證*/
	 function _validate()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		//$sn = tryGetValue($this->input->post('sn',TRUE),0);		
		$this->form_validation->set_rules('title', 'module 名稱', 'trim|required' );	
		$this->form_validation->set_rules('id', 'module 別名', 'trim|required' );
		$this->form_validation->set_rules('sort', 'module 排序', 'trim|max_length[3]|numeric|min_length[1]' );			
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}	
	
	
	/******/
	/*群組*/
	/******/
	public function group()
	{
		
		$data['url']=array("edit"=>'editGroup'
							,"del"=>'deleteGroup'
							,"sort"=>"dataSortGroup"
                            ,"launch"=>"ajax_launch_group");
		
		
		$this->sub_title = $this->lang->line("admin_group_list");

		$dataList = $this->main_model->listDB( "sys_module_category" , "title,sn,sort,launch" , NULL , $this->per_page_rows , $this->page , array("sort"=>"asc"));
		$data["list"] = $dataList["data"];
		
		//取得分頁
		
        
		$this->display("group_list_view",$data);
	}
	
	public function editGroup($sn="")
	{
		$data['url']=array("action"=>bUrl('updateGroup'));
		$this->sub_title = $this->lang->line("admin_group_form");
				
		if($sn === "")
		{
			$data["edit_data"] = array();
			$this->display("group_edit_view",$data);
		}
		else 
		{
			$dataList = $this->main_model->listDB("sys_module_category",NULL,"sn =".$sn);
			
			if(count($dataList["data"])>0)
			{
				//$this->output->enable_profiler(TRUE);				
				$data["edit_data"] =$dataList["data"][0];
				$this->display("group_edit_view",$data);
			}
			else
			{
				redirect(bUrl("group"));	
			}
		}
	}
	
	public function updateGroup()
	{
		
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}		
		
		if ( ! $this->_validateGroup() )
		{
			$data["edit_data"]=array();
			$data['url']=array("action"=>bUrl('updateGroup'));
			$this->display("group_edit_view",$data);
		}			
        else 
        {
        	
			$sn = $edit_data["sn"];
						
        	$arr_data = array(
				"title" => $this->input->post('title',TRUE),			
				"sort" => $this->input->post('sort',TRUE)					
			);
			
			if($sn != FALSE)
			{
				
				$arr_retuen=$this->main_model->updateData( "sys_module_category" , $arr_data,"sn =".$sn );
				
				if($arr_retuen['success'])
				{
					$this->showSuccessMessage();					
				}
				else 
				{
					$this->showFailMessage();
				}
				redirect(bUrl("group"));	
			}
			else 
			{
				$arr_return = $this->main_model->addData( "sys_module_category" , $arr_data );
				if($arr_return['id'] > 0)
				{
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
				redirect(bUrl("group"));		
			}
        }	
	}

	public function dataSortGroup()
	{	
		
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		
		
		
		foreach($edit_data as $key => $value){
			if(is_numeric($key) && is_numeric($value)){				
				$arr_data=array("sort"=>$value);
				$arr_return=$this->main_model->updateData( "sys_module_category" , $arr_data,"sn =".$key );				
			}
		}
		
		
		
		$this->showSuccessMessage();
		redirect(bUrl("group"));	
	}
	
    
     public function ajax_launch_group() {
      
        $arr_data = array("launch" => $_POST['launch']);
        $arr_return = $this -> main_model -> updateDB("sys_module_category", $arr_data, "sn =" . $_POST['sn']);
        unset($arr_return['sql']);
        echo json_encode($arr_return);
    }

	/***/
	
	private function _validateGroup()
	{		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		$this->form_validation ->set_rules( 'title',"module 群組名稱", 'trim|required' );
		$this->form_validation->set_rules('sort', 'module 排序', 'trim|max_length[3]|numeric|min_length[1]' );
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}
	
	
	
	
	public function deleteGroup()
	{
		$del_ary =array('sn'=> $this->input->post('del',TRUE));		
		
		if($del_ary!= FALSE && count($del_ary)>0)
		{			
			$this->main_model->deleteDB( "sys_module_category",NULL,$del_ary );			
		}		
		
		$this->showSuccessMessage();
		redirect(bUrl("group",FALAE));	
	}
	
	/*ajax */
	 public function get_module()
    {
      /*  $name = $this->input->get('_name');
        $value = $this->input->get('_value');

		$arr_return=$this->main_model->listDB("");
		      

        echo json_encode( $this->combo_model->get_dropdown($name, $value) );
        //exit();*/
    }	
	
	public function generateTopMenu()
	{
		//$this->lang->load("admin",$this->language_value);		
		//addTopMenu 參數1:子項目名稱 ,參數2:相關action  
		$this->addTopMenu('module管理',array("index","edit","update"));
		$this->addTopMenu('module群組',array("group","editGroup","updateGroup"));			
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */