<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_Model extends IT_Model {

    function __construct() {
        parent::__construct();
    }

    public function GetWebAdminList($condition = NULL, $rows = NULL, $page = NULL, $sort = array()) {

        $sql = "	SELECT 	SQL_CALC_FOUND_ROWS
							sn,
							name
					FROM 	sys_admin_group					
					WHERE ( 1 )
					";

        if ($condition != NULL) {
            $sql .= " AND ( " . $condition . " ) ";
        }

        $sql .= $this -> getSortSQL($sort);

        $sql .= $this -> getLimitSQL($rows, $page);

        $data = array(
            "sql" => $sql,
            "data" => $this -> readQuery($sql),
            "count" => $this -> getRowsCount()
        );

        return $data;
    }

    public function GetGroupAuthorityList($condition = NULL, $rows = NULL, $page = NULL, $sort = array()) {
        $sql = "	SELECT 	SQL_CALC_FOUND_ROWS
							sys_admin_group_authority.*
					FROM 	sys_admin_group_authority					
					WHERE ( 1 )
					";

        if ($condition != NULL) {
            $sql .= " AND ( " . $condition . " ) ";
        }

        $sql .= $this -> getSortSQL($sort);

        $sql .= $this -> getLimitSQL($rows, $page);

        $data = array(
            "sql" => $sql,
            "data" => $this -> readQuery($sql),
            "count" => $this -> getRowsCount()
        );

        return $data;
    }

    public function GetTotalModelList() {

        $model_category = $this -> main_model -> listDB('sys_module_category', "sn,title");
        $model_category = $model_category['data'];

        foreach ($model_category as $key => $value) {
            $list[$value['sn']]["title"] = $value["title"];
            foreach ($this->language_select_list as $key2 => $value2) {
                $where = "module_category_sn=" . $value['sn'] . " and avail_language_sn=" . $value2['sn'];
                $sort=array("sort"=>"ASC");
                $model = $this -> main_model -> listDB('sys_module',"sn,title" , $where,NULL,NULL,$sort);
                if ($model['count'] > 0) {
                    $model = $model['data'];
                    $list[$value['sn']]['language'][$value2['language_value']]['title']=$value2['language_name'];
                    $list[$value['sn']]['language'][$value2['language_value']]['model']=$model;
                }
            }
        }     
        return $list;

    }
    
    
    public function updateWebAdminGroup($edit_data){        
        $this->main_model->deleteDB('sys_admin_belong_group',array("sys_admin_sn"=>$edit_data['sn']));
        $this->main_model->addDB('sys_admin_belong_group',array("sys_admin_sn"=>$edit_data['sn'],"sys_admin_group_sn"=>$edit_data['admin_group']));           
    }

}
