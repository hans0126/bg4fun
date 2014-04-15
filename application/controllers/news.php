<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();	
		
		$this->addNavi("最新消息", fUrl("index"));			
	}

	public function index($page=1)
	{
	
		$this->addCss("css/main.css");	
		$this->addCss("css/dir/news.css");
		
		$this->setSubTitle("最新消息");
		
		$data = array();
		$this->loadBanner($data,"news");
	
		$news_list = $this->c_model->GetList( "news" , "" ,TRUE, 6 , $page , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($news_list["data"],'img_filename','news');

		$data['news_list']=$news_list["data"];
		$data['pageInfo']=$news_list["pageInfo"];		
		$data['page']=$page;	
		
		$this->display("news_list_view", $data);			
		
	}
	/**/
	public function detail($news_sn)
	{
		
		$this->addCss("css/main.css");	
		$this->addCss("css/dir/news.css");
		
		$this->setSubTitle("最新消息");
		
		$data = array();
		$this->loadBanner($data,"news");
	
	
		$news_info = $this->c_model->GetList( "news" , "sn =".$this->db->escape($news_sn), TRUE);
			
		if(count($news_info["data"])>0)
		{
			img_show_list($news_info["data"],'img_filename','news');			
			
			$data["news_info"] = $news_info["data"][0];			
			$this->addNavi($news_info["data"][0]["title"], fUrl("index"));	
			$this->display("news_detail_view",$data);
		}
		else
		{
			redirect(frontendUrl());	
		}		
	}
	
}

