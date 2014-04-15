<?
	$left_menu_html = '';

	foreach ($left_menu_list as $key => $value)
	{
		$sub_menu_html = '';

		foreach ($value["module_list"] as $subkey => $subvalue)
		{
			$select_this='';
			if($subvalue["id"]==$this->module_info["id"]){
				$select_this="this";
			}
				
			$sub_menu_html .= '<li class="lv2"><a class="'.$select_this.'" href="'.$subvalue["url"].'">'.$subvalue["title"].'</a></li>';
		}
		
		$left_menu_html.='
			<li><a href="#" class="this">'.$value["module_category_title"].'</a>
				  <ul>					
					  '.$sub_menu_html.'
				  </ul>
			  </li>';			  			  
	}

	

?>
<?php 
	if(MULTIPLE_LANGUAGES){		
?>
<div id="language">	
	<div id='lang_icon'></div>	
	<select onchange="jUrl('<?=base_url();?>backend/' + this.value + '/<?php echo $this->router->fetch_class()?>')" >
	<? foreach ($this->language_select_list as $item): ?>
	<option value="<?=$item["language_value"]?>"  <?=$item["language_value"]==$this->language_value?"selected":"" ?>><?=$item["language_name"]?></option>
	<? endforeach; ?>
    </select>
</div>
<?php
	}
?>


<div id="treeMenu">
  <ul>
	  <?=$left_menu_html?>
  </ul>
</div>