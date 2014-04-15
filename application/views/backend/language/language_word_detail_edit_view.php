	
<form action="<?php  echo bUrl($url['update'])?>" id="update_form" method="post" class="contentForm">
	
		<div id="option_bar">
		
		</div>
		
				
		
		<div class="list">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
				<tr class='first_row'>
					
					<td>標籤名稱</td>
					<?php for($i=0;$i<sizeof($lang_list);$i++){ ?>
					<td><?php echo $lang_list[$i]['language_name']?></td>	
					<?php }?>
						
				
				</tr>
				<tbody>
				<? for($i=0;$i<sizeof($list);$i++){ ?>
				<tr>
					<td><?php echo $list[$i]["title"]?>
					    <div><?php echo $list[$i]["value_name"]?></div>
					</td>
					<?php for($j=0;$j<sizeof($lang_list);$j++){ ?>
					<td><textarea name="<?php echo $list[$i]["value_name"]."_".$lang_list[$j]['language_value']?>"><?php echo $list[$i][$lang_list[$j]['language_value']]?></textarea></td>
					<?php }?>	
					
				</tr>
				<? } ?>
				</tbody>
				<tr><td colspan="<?php echo sizeof($lang_list)+1?>">
				        <button type="submit" class='btn save'>
                            <?php echo $this -> lang -> line('common_save'); ?>
                        </button>
                    </td></tr>
			</table>
		</div>
	
</form>


