<form action="" id="update_form" method="post" class="contentForm">
 
    	<div id="option_bar">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><button type="button" class='btn add' onclick="jUrl('<?php echo bUrl($url['edit'])?>')"><?php echo $this -> lang -> line("common_insert"); ?></td>
              </tr>
            </table>
        </div>
        <div class="list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
              <tr class='first_row'>
                <td width="10%"><?php echo $this->lang->line("field_serial_number");?></td>
                <td><?php echo $this->lang->line("field_group_name");?></td>
                <td width="10%">排序</td> 
                <td>啟用</td>
                <td >編輯</td>
                <td width="10%">
                		<button type="button" class='btn select_all'  onclick="SelectAll( 'del[]' )">
							<?php echo $this -> lang -> line("common_select_all"); ?>
						</button>
						<button type="button" class='btn select_revers'  onclick="ReverseSelect( 'del[]' )" >
							<?php echo $this -> lang -> line("common_reverse_select"); ?>
						</button>
                    </td>
              </tr>
     
              <? for($i=0;$i<sizeof($list);$i++){ ?>
              <tr class="<?php echo $i%2==0?"odd":"even"?>">
                <td><?php echo $list[$i]["sn"]?></td>
                <td><?php echo $list[$i]["title"]?> </td>
                <td><input name='<?php echo $list[$i]["sn"]?>' class='sort_input' value='<?php echo $list[$i]["sort"]?>'></td>
                <td><button type="button" class="launch <?php if($list[$i]["launch"]){echo "this";}?>" sn="<?php echo $list[$i]["sn"]?>"></button></td>
                <td><button type="button" class='btn edit' onclick="self.location.href='<?php echo bUrl($url['edit'])."/".$list[$i]["sn"] ?>'" > <?php echo $this -> lang -> line("common_handle"); ?> </button>
</td>              
                <td><input name="del[]" id="del" value="<?php echo $list[$i]["sn"]?>" type="checkbox" ></td>
              </tr>
              <? } ?>

              <tr>
              	<td colspan="2">
				&nbsp;
                </td>
                  <td>
						<button type="button" class='btn sort' onclick="listViewAction('#update_form','<? echo $url['sort']?>')"/>
						<?php echo $this -> lang -> line("common_sort"); ?>
						</button>
				</td>
                <td>&nbsp;</td>    
                  <td>&nbsp;</td>              
              	<td>                	
						<button type="button" class='btn del' onclick="listViewAction('#update_form','<? echo bUrl($url['del']) ?>','是否確定刪除')"> <?php echo $this -> lang -> line("common_delete"); ?> </button>
                </td>
              </tr>
             
            </table>
            
        </div>    
    
</form>
<script>
    $(function(){
        
        ajax_launch('.launch','<?php echo bUrl($url['launch'])?>');   
        
    })
</script>    
