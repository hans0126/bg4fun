<?
/*
 $auth_menu_html = '';
 foreach ($auth_list as $key => $value)
 {
 $sub_menu_html = '';
 foreach ($value["module_list"] as $subkey => $subvalue)
 {
 $select_this = in_array($subvalue["sn"], $have_auth_list)?"checked":"";

 $sub_menu_html .=
 '<li>

 <label><input type="checkbox" name="auth[]" value="'.$subvalue["sn"].'" '.$select_this.'>'.$subvalue["title"].'</label>

 </li>';

 }

 $auth_menu_html.=
 '
 <li>
 <div class="title_area">
 '.$value["module_category_title"].'
 <button type="button" class="btn select_all" onclick="authSelect(this,true)" >全選</button>
 <button type="button"  class="btn select_revers" onclick="authSelect(this,false)">全取消</button>

 </div>
 <ul>
 '.$sub_menu_html.'
 </ul>
 <div style="clear:both"></div>
 </li>
 ';
 }
 *
 *
 */
?>
<script>
	function authSelect(obj, method) {
		if (method) {
			$(obj).parent().parent().children('ul').find('input[type=checkbox]').attr('checked', true);
		} else {
			$(obj).parent().parent().children('ul').find('input[type=checkbox]').attr('checked', false);
		}
	}
</script>
<form action="<?=$url["action"] ?>" method="post" class="contentEditForm">
    <div id="option_bar">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >
						<button type="button" class='btn back' onclick="history.back()">	<?php echo $this -> lang -> line('common_return'); ?></button>	
						
					</td>
				</tr>
			</table>
		</div>
    	<div id="permissions">            
                <ul>
				<?php
				    foreach ($auth_list as $key => $value){
				  ?>
				     <li>
                        <div class="model_title"><?php echo $value['title']?></div>
                        <?php foreach ($value['language'] as $key2=>$value2){?>
                            <ul>
                                <div class="language_title"><?php echo $value2['title']?>
                                    <button type="button" class="btn select_all" onclick="authSelect(this,true)" >全選</button>
                                    <button type="button"  class="btn select_revers" onclick="authSelect(this,false)">全取消</button>
                                    
                                    
                                </div>
                                <ul class="model_group">
                                     <?php foreach ($value2['model'] as $key3=>$value3){
                                           $select_this = in_array($value3["sn"], $have_auth_list)?"checked":"";   
                                         
                                      ?>
                                      
                                        <label><input type="checkbox" name="auth[]" value="<?php echo $value3["sn"]?>" <?php echo $select_this?>><?php echo $value3["title"]?></label>  
                                         
                                     <?php } ?>
                                    
                                </ul>                                
                            </ul>      
                            
                        <?php } ?>
                        
                     </li>  
                 <?php
                    }
				?>                    
                </ul>			
    	</div>        
    
    <input type="hidden" name="web_admin_group_sn" value="<?=tryGetArrayValue('group_sn', $edit_data) ?>" />
   <button class='btn back' type="button"  onclick="history.back()">
					<?php echo $this -> lang -> line('common_cancel'); ?>
				</button>
				<button type="submit" class='btn save'>
					<?php echo $this -> lang -> line('common_save'); ?>
				</button>
</form>