<form action="<? echo $url['action']?>" method="post"  id="update_form" class="contentEditForm" >
		<div id="option_bar">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >
						<button type="button" class='btn back' onclick="history.back()">	<?php echo $this -> lang -> line('common_return'); ?></button>	
						
					</td>
				</tr>
			</table>
		</div>
		<table  border="0" cellspacing="0" cellpadding="0" id='dataTable'>
			<tr>
				<td class="left"><span class="require">* </span>語系名稱</td>
				<td> <? $filed='title'?>
				<input  name="<? echo $filed?>" type="text" class="inputs" value="<? echo tryGetArrayValue($filed,$edit_data,"")?>" />
				<?php echo form_error($filed); ?></td>
			</tr>
			<tr>
				<td class="left"><span class="require">* </span>標籤</td>
				<td> <? $filed='value_name'?>
				<input  name="<? echo $filed?>" type="text" class="inputs" value="<? echo tryGetArrayValue($filed,$edit_data)?>" />
				<?php echo form_error($filed); ?></td>
			</tr>					
			<tr>				
				<td colspan="2" class='center'>
				
				<button class='btn back' type="button"  onclick="history.back()">
					<?php echo $this -> lang -> line('common_cancel'); ?>
				</button>
				<button type="submit" class='btn save'>
					<?php echo $this -> lang -> line('common_save'); ?>
				</button>
				</td>
			</tr>
		</table>
		
	<input type="hidden" name="sn" value="<?  echo tryGetArrayValue('sn', $edit_data);?>" />
</form>
