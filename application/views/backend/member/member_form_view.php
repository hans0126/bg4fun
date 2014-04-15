<form action="<? echo $url['update']?>" method="post"  id="update_form" enctype="multipart/form-data" class="contentEditForm">
	<div id="option_bar">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td >
					<button type="button" class='btn back' onclick="jUrl('<?php echo  $url['index']?>')"><?php echo $this->lang->line('common_return'); ?></button>
				</td>
			</tr>
		</table>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>		
    	<tr>
			<td class="left">ID： </td>
			<td>
				<? $filed='id'?>
				<? echo tryGetData($filed,$edit_data)?>
				 <input type="hidden" name="<? echo $filed?>" value="<? echo tryGetData($filed, $edit_data)?>" />
			</td>
		</tr>
		<tr>
			<td class="left">oauth key： </td>
			<td>
				<? $filed='oauth_key'?>
				<? echo tryGetData($filed,$edit_data)?>
				 <input type="hidden" name="<? echo $filed?>" value="<? echo tryGetData($filed, $edit_data)?>" />
				
			</td>
		</tr>
		<tr>
			<td class="left">oauth type： </td>
			<td>
				<? $filed='oauth_type'?>
				<? echo tryGetData($filed,$edit_data)?>
				 <input type="hidden" name="<? echo $filed?>" value="<? echo tryGetData($filed, $edit_data)?>" />
				
				
			</td>
		</tr>
		<tr>
			<td class="left">mail： </td>
			<td>
				<? $filed='mail'?>
				<? echo tryGetData($filed,$edit_data)?>
				 <input type="hidden" name="<? echo $filed?>" value="<? echo tryGetData($filed, $edit_data)?>" />
				
			
			</td>
		</tr>		
		<tr>
			<td class="left">啟用： </td>
			<td>
				<? $filed='launch'?>
				<? echo tryGetData($filed,$edit_data)?>
				 <input type="hidden" name="<? echo $filed?>" value="<? echo tryGetData($filed, $edit_data)?>" />
				
			
			</td>
		</tr>
		<tr>
			<td class="left">建立時間： </td>
			<td>
				<? $filed='create_date'?>
				<? echo tryGetData($filed,$edit_data)?>
				 <input type="hidden" name="<? echo $filed?>" value="<? echo tryGetData($filed, $edit_data)?>" />
				
			
			</td>
		</tr>		
		<tr>
			<td colspan="2" class='center'>
				<button type="button" class='btn back' onclick="jUrl('<?php echo $url['index']?>')">返回</button>        	
				<!--<button type="submit" class='btn save'><?php echo $this->lang->line('common_save'); ?></button>-->
			</td>
		</tr>
    </table>
    
    <input type="hidden" name="sn" value="<? echo tryGetData('sn', $edit_data)?>" />
	<input type="hidden" name="content_type" value="news" />
	<input type="hidden" name="forever" value="1" />
</form>        