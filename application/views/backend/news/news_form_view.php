<?php
showOutputBox("tinymce/tinymce_js_view", array('elements' => 'content'));
?>
<form action="<? echo bUrl("updateNews")?>" method="post"  id="update_form" enctype="multipart/form-data" class="contentEditForm">
	<div id="option_bar">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td >
					<button type="button" class='btn back' onclick="jUrl('<?php echo bUrl("newsList")?>')"><?php echo $this->lang->line('common_return'); ?></button>
				</td>
			</tr>
		</table>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
    	<tr>
			<td class="left"><span class="require">* </span>名稱： </td>
			<td>
				<input  name="title" type="text" class="inputs" value="<? echo tryGetData('title',$edit_data)?>" style="width:500px" /><?php echo form_error('title');?>
			</td>
		</tr>		
		<tr>
			<td class="left">內容： </td>
			<td colspan="2" class='center'>
				<textarea name="content" id="content"><? echo tryGetData('content',$edit_data,"")?></textarea>				
			</td>				
		</tr>
		<tr>
			<td class="left"><span class="require">* </span>代表圖： </td>
			<td>
				<input type="file" name="img_filename" size="20" /><br /><br />
				<input type="hidden" name="orig_img_filename" value="<?php echo tryGetData('orig_img_filename',$edit_data)?>"  />
				<?php if(isNotNull(tryGetData('img_filename',$edit_data))){ ?>
				<img  border="0" src="<?php echo tryGetData('img_filename',$edit_data); ?>"><br />		
				刪除<input type="checkbox" name="del_img_filename"	value="1" />
            	<?php } ?>
				<div>建議尺寸:194*120</div>		
			</td>
		</tr>
		
	  	<tr>
			<td class="left"><span class="require">* </span>排序： </td>
			<td>
				<input  name="sort" type="text" class="inputs" value="<? echo tryGetData('sort',$edit_data)?>" /><?php echo form_error('sort');?>
			</td>
		</tr>		
		<tr>
            <td class="left">
                <?php echo $this->lang->line("field_launch");?>：
            </td>
            <td>
                <input name="launch" id="launch" value="1" type="checkbox" <? echo tryGetData('launch',$edit_data)=='1'?"checked":"" ?> >
            </td>
        </tr>  
		<tr>
			<td colspan="2" class='center'>
				<button type="button" class='btn back' onclick="jUrl('<?php echo bUrl("newsList")?>')"><?php echo $this->lang->line('common_cancel'); ?></button>        	
				<button type="submit" class='btn save'><?php echo $this->lang->line('common_save'); ?></button>
			</td>
		</tr>
    </table>
    
    <input type="hidden" name="sn" value="<? echo tryGetData('sn', $edit_data)?>" />
	<input type="hidden" name="content_type" value="news" />
	<input type="hidden" name="forever" value="1" />
</form>        