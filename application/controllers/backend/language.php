<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Language extends Backend_Controller {
    public $tableName = "sys_avail_language";

    function __construct() {
        parent::__construct();
        $this -> load -> Model("language_model", "main_model");

    }

    public function index() {

        $data['url'] = array(
            "edit" => bUrl('edit', true),
            "del" => bUrl("delete"),
            "sort" => bUrl("dataSort"),
            "ajax" => bUrl("get_module"),
            "index" => bUrl("index"),
            "edit" => bUrl('edit'),
            "launch" => bUrl('ajax_launch')
        );

        $field = NULL;
        $sort = array(
            "is_default" => "DESC",
            "sort" => "ASC"
        );
        $dataList = $this -> main_model -> listDB($this -> tableName, $field, NULL, NULL, NULL, $sort);
        $data['list'] = $dataList['data'];

        $data["pager"] = NULL;
        $this -> display("language_list_view", $data);
    }

    /*編輯*/
    public function edit($sn = NULL) {
        $data['url'] = array("action" => bUrl('update'));
        $dataList = $this -> main_model -> listDB($this -> tableName);

        if ($sn == "") {
            $data['edit_data'] = array("launch" => 1);
            $this -> display("language_edit_view", $data);
        } else {
            $dataList = $this -> main_model -> listDB($this -> tableName, NULL, "sn =" . $sn);

            if (count($dataList["data"]) > 0) {
                $data["edit_data"] = $dataList["data"][0];
                $this -> display("language_edit_view", $data);
            } else {
                redirect(bUrl("index"));
            }
        }
    }

    /*更新*/
    public function update($sn = null) {

        foreach ($_POST as $key => $value) {
            $edit_data[$key] = $this -> input -> post($key, TRUE);
        }

        if (!$this -> _validate()) {
            $data["edit_data"] = $edit_data;
            $data['url'] = array("action" => bUrl('update'));
            $dataList = $this -> main_model -> listDB($this -> tableName);
            $data["module_category"] = $dataList['data'];

            $this -> display("language_edit_view", $data);
        } else {

            $sn = $edit_data["sn"];

            $arr_data = array(
                "language_name" => $this -> input -> post('language_name', TRUE),
                "language_value" => $this -> input -> post('language_value', TRUE)
            );

            if ($sn != FALSE) {
                $arr_return = $this -> main_model -> updateData($this -> tableName, $arr_data, "sn =" . $sn);

                if ($arr_return['success']) {
                    $this -> showSuccessMessage();
                } else {
                    $this -> showFailMessage();
                }

            } else {
                $arr_return = $this -> main_model -> addData($this -> tableName, $arr_data);

                if ($arr_return['id'] > 0) {
                    $this -> showSuccessMessage();
                } else {
                    $this -> showFailMessage();
                }

            }

            redirect(bUrl("index"));
        }
    }

    /*刪除*/
    public function delete() {

        $del_ary = array('sn' => $this -> input -> post('del', TRUE));
        if ($del_ary != FALSE && count($del_ary) > 0) {
            $re = $this -> main_model -> deleteDB($this -> tableName, NULL, $del_ary);
        }

        $this -> showSuccessMessage();
        redirect(bUrl("index", FALSE));
    }

    /*排序*/
    public function dataSort() {

        foreach ($_POST as $key => $value) {
            $edit_data[$key] = $this -> input -> post($key, TRUE);
        }

        foreach ($edit_data as $key => $value) {
            if (is_numeric($key) && is_numeric($value)) {
                $arr_data = array("sort" => $value);
                $arr_return = $this -> main_model -> updateData($this -> tableName, $arr_data, "sn =" . $key);
            }
        }

        $this -> showSuccessMessage();
        redirect(bUrl("index"));
    }

    /*ajax 啟用*/

    public function ajax_launch() {

        $arr_data = array("launch" => $_POST['launch']);

        $arr_return = $this -> main_model -> updateDB($this -> tableName, $arr_data, "sn =" . $_POST['sn']);
        unset($arr_return['sql']);
        echo json_encode($arr_return);
    }

    /*資料驗證*/
    function _validate() {
        $this -> form_validation -> set_error_delimiters('<div class="error">', '</div>');
        $this -> form_validation -> set_rules('language_name', 'language name', 'trim|required');
        $this -> form_validation -> set_rules('language_value', 'language value', 'trim|required');

        return ($this -> form_validation -> run() == FALSE) ? FALSE : TRUE;
    }

    /********/
    /*語系標籤*/
    /*******/
    public function language_word() {

        $language_word_type = $this -> input -> get('language_word_type', TRUE);
        if (!$language_word_type) {
            $language_word_type = 0;
        }

        $data['url'] = array(
            "del" => "language_word_delete",
            "index" => "language_word",
            "edit" => 'language_word_edit',
            "fast_add" => 'language_word_fast_add'
        );

        $sort = array("value_name" => "ASC");
        $where = " type=" . $language_word_type;
        $dataList = $this -> main_model -> listDB("sys_language_word", NULL, $where, $this -> per_page_rows, $this -> page, $sort);

        $data["language_word_type"] = $language_word_type;
        $data['list'] = $dataList['data'];

        $data["pager"] = array(
            "per_page_rows" => $this -> per_page_rows,
            "current_page" => $this -> page,
            "total_row" => $dataList["count"],
            "action" => $data['url']['index']
        );

        $this -> display("language_word_list_view", $data);
    }

    public function language_word_edit() {

        $language_word_type = $this -> input -> get('language_word_type', TRUE);
        if (!$language_word_type) {
            $language_word_type = 0;
        }

        $sn = $this -> input -> get('sn', TRUE);

        $data['url'] = array("action" => bUrl('language_word_update'));
        //$dataList = $this->main_model->listDB('sys_language_word');

        if ($sn == "") {
            $data['edit_data'] = array();
            $this -> display("language_word_edit_view", $data);
        } else {
            $dataList = $this -> main_model -> listDB('sys_language_word', NULL, "sn =" . $sn);

            if (count($dataList["data"]) > 0) {
                $data["edit_data"] = $dataList["data"][0];
                $this -> display("language_word_edit_view", $data);
            } else {
                redirect(bUrl("index"));
            }
        }
    }

    public function language_word_update() {

        $language_word_type = $this -> input -> get('language_word_type', TRUE);
        if (!$language_word_type) {
            $language_word_type = 0;
        }

        foreach ($_POST as $key => $value) {
            $edit_data[$key] = $this -> input -> post($key, TRUE);
        }

        if (!$this -> _language_word_validate()) {
            $data["edit_data"] = $edit_data;
            $data['url'] = array("action" => bUrl('language_word_update'));
            $dataList = $this -> main_model -> listDB("sys_language_word");

            $this -> display("language_word_edit_view", $data);
        } else {
            $sn = $edit_data["sn"];

            $arr_data = array(
                "title" => $this -> input -> post('title', TRUE),
                "value_name" => $this -> input -> post('value_name', TRUE),
                "type" => $language_word_type
            );

            if ($sn != FALSE) {
                $arr_return = $this -> main_model -> updateDB("sys_language_word", $arr_data, "sn =" . $sn);

                if ($arr_return['success']) {
                    $this -> showSuccessMessage();
                } else {
                    $this -> showFailMessage();
                }

            } else {
                $arr_return = $this -> main_model -> addDB("sys_language_word", $arr_data);

                if ($arr_return > 0) {
                    $this -> showSuccessMessage();
                } else {
                    $this -> showFailMessage();
                }

            }

            redirect(bUrl("language_word", true, array("sn")));
        }
    }

    public function language_word_delete() {

        $del_ary = array('sn' => $this -> input -> post('del', TRUE));
        if ($del_ary != FALSE && count($del_ary) > 0) {
            $re = $this -> main_model -> deleteDB("sys_language_word", NULL, $del_ary);
        }

        $this -> showSuccessMessage();
        redirect(bUrl("language_word", FALSE));
    }

    public function language_word_fast_add($type) {

        $arr_data = $_POST['content'];
        $arr_data = explode(";", $arr_data);

        foreach ($arr_data as $value) {
            if (preg_match('/@/', $value)) {
                $arr = explode("@", $value);
                if(preg_match('/^[A-Za-z0-9]+$/',$arr[1])){                
                    $arr_insert = array(
                        "title" => trim($arr[0]),
                        "value_name" => trim($arr[1]),
                        "type" => $type
                    );
                    $arr_return = $this -> main_model -> addDB("sys_language_word", $arr_insert);
                }
            }
        }

        echo json_encode(array(1));
    }

    /*資料驗證*/
    function _language_word_validate() {
        $this -> form_validation -> set_error_delimiters('<div class="error">', '</div>');
        $this -> form_validation -> set_rules('title', '名稱', 'trim|required');
        $this -> form_validation -> set_rules('value_name', '標籤名稱', 'trim|required');

        return ($this -> form_validation -> run() == FALSE) ? FALSE : TRUE;
    }

    /*語系單字建立*/
    public function language_word_detail() {

        $data['url'] = array("update" => "language_word_detail_update");

        $lang_list = $this -> main_model -> getLanguageList();
        $dataList = $this -> main_model -> getLanguageWord();

        foreach ($dataList as $key => $value) {
            foreach ($lang_list as $key2 => $value2) {
                $where = "avail_language_sn=" . $value2['sn'] . " and language_word_sn=" . $value['sn'];
                $word = $this -> main_model -> listDB("sys_language_word_detail", null, $where);
                $lang_value = '';
                if ($word['count'] > 0) {
                    $lang_value = $word['data'][0]['title'];
                }
                $dataList[$key][$value2['language_value']] = $lang_value;
            }
        }

        $data['lang_list'] = $lang_list;
        $data['list'] = $dataList;

        $this -> display("language_word_detail_edit_view", $data);

    }

    /**/
    public function language_word_detail_update() {
                   
        
     
       
       
        
      
        
        foreach ($_POST as $key => $value) {
            $edit_data[$key] = $this -> input -> post($key, TRUE);
        }

        $lang_list = $this -> main_model -> getLanguageList();
        $dataList = $this -> main_model -> getLanguageWord();
               
        foreach ($lang_list as $key => $value) {
           
              $out_data='';
           
            foreach ($dataList as $key2 => $value2) {

                $where = "avail_language_sn =" . $value['sn'] . " and language_word_sn =" . $value2['sn'];
                $word = $this -> main_model -> listDB("sys_language_word_detail", null, $where);
                $lang_value = tryGetValue($edit_data[$value2['value_name']."_".$value['language_value']]);

                if ($word['count'] > 0) {
                    
                    $arr_data=array("title"=> $lang_value);                  
                    $where=array("avail_language_sn"=>$value['sn'],
                                "language_word_sn"=>$value2['sn']);
                   
                    $arr_return = $this -> main_model -> updateDB("sys_language_word_detail", $arr_data, $where);
                   
                } else {
                    
                      $arr_data=array("avail_language_sn"=>$value['sn'],
                                "language_word_sn"=>$value2['sn'],
                                "title"=>$lang_value);                   
                      
                      $arr_return = $this -> main_model -> addDB("sys_language_word_detail", $arr_data);                     
                }
                
                // $lang_out_data[$value['language_value']][$value2['value_name']]= $lang_value;
                
                 $out_data.="\$lang['".$value2['value_name']."']='".$lang_value."';\n";
            }
            
            //寫入檔案
                   
            write_file('system/language/'.$value['language_value'].'.php', "<?php\n\n".$out_data."\n\n?>");

        }

       

       redirect(bUrl("language_word"));

    }

    public function generateTopMenu() {
        //$this->lang->load("admin",$this->language_value);
        //addTopMenu 參數1:子項目名稱 ,參數2:相關action
        $this -> addTopMenu('語系管理', array(
            "index",
            "edit",
            "update"
        ));
        $this -> addTopMenu('語系標籤', array(
            "language_word",
            "language_word_edit",
            "language_word_update"
        ));
        $this -> addTopMenu('語系文檔', array("language_word_detail"));

    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
