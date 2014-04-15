<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

abstract class Backend_Controller extends IT_Controller 
{
	public $title = "";	//標題	

	public $left_menu_list = array();
	public $top_menu_list = array();
	public $module_info;

	public $sub_title = "";
	
	public $page = 1;
	public $per_page_rows = 20;
	
	public $query_string_ary;
    
    public $basic_language='';
	
	
	public $img_config = array();
	
	function __construct() 
	{
		parent::__construct();
		
		if(!checkAdminLogin())
		{
			redirect(backendUrl("login"));
		}
		
		//保留語系檔用
		if (!MULTIPLE_LANGUAGES) {
		   $this->basic_language=$this->language_model->getDefaultLanguage();
         
		}
		
		$this->query_string_ary=$_GET;	
	
		$this->initBackend();		
		$this->getParameter();
		$this->generateTopMenu();	
		$this->initImgConfig();	
	
		$this->lang->load("common");
		//$this->config->set_item('language', $this->language_value);	
		
	}
	
	
	function initBackend()
	{
				
		if (MULTIPLE_LANGUAGES) {
			$this -> language_value = $this -> uri -> segment(2);
			$this->config->set_item('language_value', $this -> language_value);
		
			$language_list = $this -> getLanguageInfo();		
			
			if ($language_list != FALSE && sizeof($language_list) > 0) {
					
				$this -> language_sn = $language_list[0]["sn"];
			
				//取得所有語系列表
				$this -> getLanguageList();

				//取得module 相關資訊
				$module_id = $this -> router -> fetch_class();
			
				$this -> module_info = $this -> getModuleInfo($module_id);
				
				//取得左側menu
				$this -> getLeftMenu($this -> language_sn);					
				
			} else{
						
				$this -> redirectHome();
			}
		} else {
			$this -> language_sn=1;
			$module_id = $this -> router -> fetch_class();
			$this -> module_info = $this -> getModuleInfo($module_id);
			$this -> getLeftMenu($this -> language_sn);

		}
	}
	
	public function getParameter()
	{
		$this->page = $this->input->get('page',TRUE);
		$this->per_page_rows =	$this->config->item('per_page_rows','pager');		
	}
	
	
	function initImgConfig()
	{
		$this->img_config['upload_path'] = $this->config->item('upload_tmp_path','image');
		$this->img_config['allowed_types'] = $this->config->item('allowed_types','image');
		$this->img_config['max_size']	= $this->config->item('upload_max_size','image');
	}
	
	
	
	//取得單元上方子選單
	abstract public function generateTopMenu();	

	protected function getModuleInfo($module_id) {
		$condition = " sys_module.id = '" . $module_id . "' and sys_module.avail_language_sn =" . $this -> language_sn;
		$module_info = $this -> module_model -> GetList($condition);
		
		if (sizeof($module_info["data"]) > 0) {
			return $module_info["data"][0];
		} else {
			return array("id" => "", "title" => "");
		}
	}

	
	
	protected function getLeftMenu($language_sn) {
		$condition = "sys_module.sn = 0";

		if ($this -> session -> userdata('supper_admin') === "1") {
			$condition = "  sys_module.avail_language_sn =" . $language_sn;
		} elseif ($this -> session -> userdata('admin_auth') !== FALSE) {

			$condition = "  sys_module.avail_language_sn =" . $language_sn . " AND  sys_module.sn in (" . implode(",", $this -> session -> userdata('admin_auth')) . ")";
		}
		$condition .= " and sys_module.launch=1 ";

		$sort = array("sys_module_category.sort" => "asc", "sys_module.sort" => "asc");
        
        
        
		$left_menu_list = $this -> module_model -> GetList($condition, NULL, NULL, $sort);
		
	
		//echo nl2br($left_menu_list["sql"]);
		//dprint($left_menu_list["data"]);
		$this -> left_menu_list = $this -> _adjustLeftMenu($left_menu_list["data"]);
	}

	
	private function _adjustLeftMenu($left_menu_list) {

		//dprint($left_menu_list);
		$menu_list = array();
		if ($left_menu_list != FALSE) {
			if(MULTIPLE_LANGUAGES){
				$language_value="/".$this -> language_value;
			}else{
				$language_value='';	
			}			
			
			for ($i = 0; $i < sizeof($left_menu_list); $i++) {
				$left_menu_list[$i]["url"] = site_url() . "backend" . $language_value . "/" . $left_menu_list[$i]["id"];
				//$left_menu_list[$i]["url"] = base_url()."backend/".$left_menu_list[$i]["id"];
				$menu_list[$left_menu_list[$i]["module_category_sn"]]["module_category_title"] = $left_menu_list[$i]["module_category_title"];
				$menu_list[$left_menu_list[$i]["module_category_sn"]]["module_list"][] = $left_menu_list[$i];
			}
		}

		return $menu_list;
	}

	
	
		
	/**
	 * 回到backend 首頁
	 */	
	public function redirectHome()
	{
		//取得預設語系
		if(MULTIPLE_LANGUAGES){
			$condition = "is_default = 1";
			$list = $this -> language_model -> GetList($condition);
			$list = $list["data"];
		
			if (sizeof($list) > 0) {
			
				
				header("Location:" . base_url() . "backend/" . $list[0]["language_value"] . "/home");
				
				//header("Location:".base_url()."backend/home");
				//header( "Location: ".$this->relative_root_path.$this->system_path."index.php?sn=".$list[0]["sn"]."&lang=".$this->language );
				exit ;
			} else {
				show_error('language not found');
			}
		}else{
			header("Location:" . base_url() . "backend/home");
		}
	}
	
	
	
	/**
	 * 登出
	 */
	public function logout()
	{
		$this->session->unset_userdata('admin_sn');
		$this->session->unset_userdata('admin_id');
		$this->session->unset_userdata('admin_email');
		$this->session->unset_userdata('supper_admin');
		$this->session->unset_userdata('admin_login_time');
		$this->session->unset_userdata('admin_auth');
		//$this->session->unset_userdata('admin_accept');
		$this->redirectHome();		
	}	
	/**
	 * output view
	 */
	function display($view, $data = array())
    {
		
		
		$view = $this->config->item('backend_name').'/'.$this->router->fetch_class()."/".$view;	
		//$view = 'backend/'.$this->router->fetch_class()."/".$view;
		$data['templateUrl'] = $this->config->item("template_backend_path");
		
		
		$data['module_info'] = $this -> module_info;
	//	$data['language_select_list'] = $this->language_select_list;	
		
		$data['content'] = $this->load->view($view, $data, TRUE);		
		$data['backend_message'] =$this->session->flashdata('backend_message');		
		$data['top_menu_list'] = $this->top_menu_list;	
		$data['left_menu_list'] = $this->left_menu_list;	
		$data['header_area'] = $this->load->view($this->config->item('backend_name').'/template_header_view', $data, TRUE);		
		$data['left_menu'] = $this->load->view($this->config->item('backend_name').'/template_left_menu_view', $data, TRUE);
		
		return $this->load->view($this->config->item('backend_name').'/template_index_view', $data);
	}
	
	/*2代*/
	function displayPlus($view, $data = array() )
	{	
		$data["language_value"] = $this->language_value;
		
		$view="/backend/".$this->router->fetch_class()."/".$view;
		$data['content'] = $this->load->view($view, $data, TRUE);
		
		$data['backend_message'] =$this->session->flashdata('backend_message');
		$data['language_select_list'] = $this->language_select_list;	
		$data['top_menu_list'] = $this->top_menu_list;	
		$data['left_menu_list'] = $this->left_menu_list;	
		$data['header_area'] = $this->load->view('backend/template_header_view', $data, TRUE);		
		$data['left_menu'] = $this->load->view('backend/template_left_menu_view', $data, TRUE);
		
		return $this->load->view('backend/template_index_view', $data);
	}
	
	/**
	 * title:子項目名稱 ,items:相關action  
	 */
	public function addTopMenu($title,$items = array())
	{
		
		$action = "index";
		if(sizeof($items)>0)
		{
			$action = $items[0];
		}		
		
		if(MULTIPLE_LANGUAGES){
				$language_value="/".$this -> language_value;
		}else{
				$language_value='';	
		}
		
		
		/***$url = base_url()."backend/".$this->language_value."/".$this->router->fetch_class()."/".$action;***/
		$url = base_url().$this->config->item('backend_name').$language_value."/".$this->router->fetch_class()."/".$action;
		
		$this->top_menu_list[] = array("title"=>$title,"url"=>$url,"items"=>$items);
	}
	
	public function setSubTitle($sub_title = "")
	{
		$this->sub_title = $sub_title;
	}
	
	
	public function index()
	{
		if($this->top_menu_list!= FALSE && sizeof($this->top_menu_list) > 0)
		{
			redirect($this->top_menu_list[0]["url"]);	
		}			
		else
		{
			$this->redirectHome();	
		}		
	}
		
	
	/**
	 * launch item
	 * @param	string : launch table
	 * @param	string : redirect action
	 * 
	 */
	 /*
	public function launchItem($launch_str_table,$redirect_action)
	{
		//原本啟用的
		if( isset( $_POST['launch_org'] ) )
		{
			$launch_org = $_POST['launch_org'];
		}			
		else
		{
			$launch_org = array();
		}
			
		
		//被設為啟用的
		if( isset( $_POST['launch'] ) )
		{
			$launch = $_POST['launch'];
		}
		else 
		{
			$launch = array();
		}		
		
		
		//要更改為啟用的
		$launch_on = array_values( array_diff( $launch , $launch_org ) );
		
		//要更改為停用的
		$launch_off = array_values( array_diff( $launch_org , $launch ) );
		
		
		
		//啟用
		if( sizeof( $launch_on ) > 0 )
		{
			$this->it_model->updateData( $launch_str_table , array("launch" => 1),"sn in (".implode(",", $launch_on).")" );	
		}
		
		
		//停用
		if( sizeof( $launch_off ) > 0 )
		{
			$this->it_model->updateData( $launch_str_table , array("launch" => 0),"sn in (".implode(",", $launch_off).")" );	
		}
		
		//$this->output->enable_profiler(TRUE);
		
		$this->showSuccessMessage();
		redirect(bUrl($redirect_action));	
	}
	
	*/
	
	/**
	 * delete item
	 * @param	string : launch table
	 * @param	string : redirect action
	 * 
	 */
	public function deleteItem($launch_str_table,$redirect_action)
	{
		$del_ary = $this->input->post('del',TRUE);
		if($del_ary!= FALSE && count($del_ary)>0)
		{
			foreach ($del_ary as $item_sn)
			{
				$this->it_model->deleteData( $launch_str_table , array("sn"=>$item_sn) );	
			}
		}		
		$this->showSuccessMessage();
		redirect(bUrl($redirect_action, FALSE));	
	}
	
	/**
	 * delete item
	 * @param	string : launch table
	 * @param	string : redirect action
	 * 
	 */
	public function deleteItemAndFile($launch_str_table,$redirect_action,$del_forder = '')
	{
		$del_ary = $this->input->post('del',TRUE);
		if($del_ary!= FALSE && count($del_ary)>0)
		{
			foreach ($del_ary as $item_sn)
			{				
				$this->it_model->deleteData( $launch_str_table , array("sn"=>$item_sn) );
				
				if($this->input->post('del_file_'.$item_sn,TRUE) !== FALSE)
				{
					@unlink($del_forder.$this->input->post('del_file_'.$item_sn,TRUE));		
				}	
			}
		}		
		$this->showSuccessMessage();
		redirect(bUrl($redirect_action, FALSE));	
	}
	
	public function showSuccessMessage()
	{
		$this->showMessage('Update Success!!');
	}
	
	public function showFailMessage()
	{
		$this->showMessage('Update Failed!!','backend_error');
	}
	
	public function showMessage($message = '', $calss = 'backend_message')
	{
		
		$message_html = 
		'<tr>
			<td class="content_left"></td>
			<td  class="content_center"><div class="'.$calss.'">'.$message.'</div></td>
			<td class="content_right"></td>
		</tr>';
		
		$this->session->set_flashdata('backend_message',$message_html);
	}
	
	
	
	/**
	 * 分頁
	 */	
public function getPager($total_count,$cur_page,$per_page,$redirect_action)
	{
		$config['total_rows'] = $total_count;
		$config['cur_page'] = $cur_page;
		$config['per_page'] = $per_page;		
		
		$this->pagination->initialize($config);
		$pager = $this->pagination->create_links();		
		$pager['action'] = $redirect_action;
		$pager['per_page_rows'] = $per_page;
		$pager['total_rows'] = $total_count;		
		//$offset = $this->pagination->offset;
		//$per_page = $this->pagination->per_page;
				
		return $pager;	
	} 
	
	
	//記得要加上media bank權限
	function loadElfinder()
	{
	  $this->load->helper('path');
	  $opts = array(
	    'debug' => true, 
	    'roots' => array(
	      array( 
	        'driver' => 'LocalFileSystem', 
	        'path'   => set_realpath('upload')."media", 
	        'URL'    => site_url('upload').'/media'
	        // more elFinder options here
	      ) 
	    )
	  );
	  $this->load->library('elfinderlib', $opts);
	}
	
	
	
	
	function profiler()
	{
		$this->output->enable_profiler(TRUE);	
	}
	
	
	function dealPost()
	{
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		$edit_data["content"] = $this->input->post("content");	
		
		$arr_data = array
		(				
		     "sn" => tryGetData("sn",$edit_data,NULL)	
			, "parnet_sn" => tryGetData("parnet_sn",$edit_data,NULL)	
			, "title" => tryGetData("title",$edit_data)	
			, "brief" => tryGetData("brief",$edit_data)	
			, "content_type" => tryGetData("content_type",$edit_data)	
			, "start_date" => tryGetData("start_date",$edit_data,date( "Y-m-d H:i:s" ))
			, "end_date" => tryGetData("end_date",$edit_data)
			, "forever" => tryGetData("forever",$edit_data,0)
			, "launch" => tryGetData("launch",$edit_data,0)
			, "sort" => tryGetData("sort",$edit_data,500)
			, "url" => tryGetData("url",$edit_data)
			, "target" => tryGetData("target",$edit_data,0)
			, "content" => tryGetData("content",$edit_data)
			, "update_date" =>  date( "Y-m-d H:i:s" )
		);        	
		
		
		
		return $arr_data;
	}
	
}