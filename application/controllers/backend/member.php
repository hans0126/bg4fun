<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Backend_Controller {
	
	public $level_limit=2;
	public $path="upload/product";
	
	function __construct() 
	{
		parent::__construct();
		$this->load->Model("member_model");		
	}
	
	

	/**
	 * member
	 */
	public function index()
	{
		//$this->sub_title = "category";		
		
		$data['url']=array("edit"=>bUrl('edit')
							,"del"=>bUrl("del")							
							,"index"=>bUrl("index")					
                            ,"launch"=>"ajax_launch");	
		
		
		
		$list = $this->member_model->listDB( "member" , "" ,FALSE, $this->per_page_rows , $this->page , array("sn"=>"desc") );
	
		
		$data["list"] = $list["data"];
		
		//dprint($data);
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"index");	
		
		$this->display("member_list_view",$data);
	}
	
	/**
	 * category edit page
	 */
	public function edit()
	{
		$sn=$this->input->get('sn', TRUE);
		
		$data['url']=array("index"=>bUrl("index",true,array('sn'))		
                            ,"update"=>bUrl("update"));		
			
		$this->sub_title = "member edit";
				
		if($sn == "")
		{
			$data["edit_data"] = array();
			$this->display("member_form_view",$data);
		}
		else 
		{		
			$news_info = $this->member_model->listDB( "member" ,NULL, "sn =".$sn);
			
			if(count($news_info["data"])>0)
			{				
				$data["edit_data"] = $news_info["data"][0];			
				
				$this->display("member_form_view",$data);
			}
			else
			{
				redirect($data['url']['index']);	
			}
		}
	}
	
	
		
	/**
	 * 更新News
	 */
	public function update()
	{
		
		$data['url']=array("index"=>bUrl("index",true,array('sn'))		
                            ,"update"=>bUrl("update"));		
		
		foreach( $_POST as $key => $value ){
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}	
						
		if ( ! $this->_validateNews())
		{
			$data["edit_data"] = $edit_data;		
			$this->display("member_form_view",$data);
		}
        else 
        {		
			//圖片處理 img_filename
			$this->img_config['resize_setting'] = array("news"=>array(194,120));
			deal_content_img($edit_data,$this->img_config,"img_filename","news");
			//deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename","News");
			
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "web_menu_content" , $edit_data, "sn =".$edit_data["sn"] ))
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
									
				$arr_data["create_date"] =   date( "Y-m-d H:i:s" );
				
				$news_sn = $this->it_model->addData( "web_menu_content" , $edit_data );
				if($news_sn > 0)
				{				
					$edit_data["sn"] = $news_sn;
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
	
			}
			
			//圖片刪除 img_filename
			del_img($edit_data,"img_filename","news");
			
			redirect(bUrl("newsList"));	
        }	
	}
	
	public function ajax_launch() {
      
        $arr_data = array("launch" => $_POST['launch']);
        $arr_return = $this -> member_model -> updateDB("member", $arr_data, "sn =" . $_POST['sn']);
        unset($arr_return['sql']);
        echo json_encode($arr_return);
    }
	
	/**
	 * 驗證newsedit 欄位是否正確
	 */
	function _validateNews()
	{		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		
		$this->form_validation->set_rules( 'title', '名稱', 'is_unique[member.oauth_type]' );
		$this->form_validation->set_message('test','Member is not valid!');
				
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}
	
	
	

	/**
	 * delete News
	 */
	function del()
	{
		$this->deleteItem("member", "index");
	}


		

	/**
	 * 驗證News edit 欄位是否正確
	 */
	function _validateItem()
	{
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');			
		$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete News
	 */
	function delItem()
	{
		$News_sn = $this->input->post("News_sn",TRUE);
		$this->deleteItem("News_item", "itemList?News_sn=".$News_sn);
	}

	/**
	 * launch News
	 */
	function launchItem()
	{
		$News_sn = $this->input->post("News_sn",TRUE);
		$this->launchItem("News_item","itemList?News_sn=".$News_sn);
	}
	
	
	
	public function GenerateTopMenu()
	{		
		$this->addTopMenu("會員管理",array("index","edit","update"));
	}
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */