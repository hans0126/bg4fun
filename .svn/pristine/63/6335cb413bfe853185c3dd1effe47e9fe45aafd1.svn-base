	
<form action="" id="update_form" method="post" class="contentForm">
	
		<div id="option_bar">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >
						<button type="button" class='btn add' onclick="jUrl('<?php echo bUrl($url['edit'],true);?>')"><?php echo $this -> lang -> line("common_insert"); ?></button>	
						<select id="type_select">
						<?php foreach($this->config->item('language_word_type') as $key=>$value){
								$selected='';
								if($language_word_type==$key){
									$selected="selected";	
								}
							
								echo "<option value='".$key."' ".$selected.">".$value."</option>";
							}?>
							
						</select>
					</td>
								
				</tr>
			</table>
		</div>
		
			<table>
				<tr>
					<td>快速新增</td>					
				</tr>
				<tr>
					<td>
						<textarea name="fast_insert"></textarea>
					</td>	
					<td>
						<button type="button" class='btn save' id="fast_add">快速新增</button>				
						<div>
							標題@key;標題2@key2........逐筆
						</div>
					</td>					
				</tr>			
			</table>
		
		
		<div class="list">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
				<tr class='first_row'>
					<td><?php echo $this -> lang -> line("field_serial_number"); ?></td>
					<td>單字名稱</td>
					<td>標籤</td>	
					<td>編輯</td>		
					<td width="10%">
						<button type="button" class='btn select_all'  onclick="SelectAll( 'del[]' )">
							<?php echo $this -> lang -> line("common_select_all"); ?>
						</button>
						<button type="button" class='btn select_revers'  onclick="ReverseSelect( 'del[]' )" >
							<?php echo $this -> lang -> line("common_reverse_select"); ?>
						</button>
					</td>
				</tr>
				<tbody>
				<? for($i=0;$i<sizeof($list);$i++){ ?>
				<tr>
					<td><?php echo $list[$i]["sn"]?></td>
					<td><?php echo $list[$i]["title"]?></td>
					<td><?php echo $list[$i]["value_name"]?></td>			
					<td>
						<button type="button" class='btn edit' onclick="jUrl('<?php echo bUrl($url['edit'],true,null,array("sn"=>$list[$i]["sn"]));?>')" > <?php echo $this -> lang -> line("common_handle"); ?> </button>
					</td>
					<td>
						<input name="del[]" id="del" value="<?php echo $list[$i]["sn"]?>" type="checkbox" >
					</td>
				</tr>
				<? } ?>
				</tbody>
				<tr>
					<td colspan="4"><?php echo bkPager($pager)?></td>				
					<td>
						<button type="button" class='btn del' onclick="listViewAction('#update_form','<? echo bUrl($url['del'],false) ?>','是否確定刪除')"> <?php echo $this -> lang -> line("common_delete"); ?> </button>
					</td>
				</tr>
			</table>
		</div>
	
</form>

<script>
	$(function(){
		
		$('#type_select').change(function(){
			self.location='<?php echo bUrl($url['index'],false)?>?language_word_type='+$(this).val();
		})
		
		$("#fast_add").click(function(){
			var content=$('textarea[name=fast_insert]').val();
			if(!content){
				return false;	
			}
			var thisObj=$(this);
			
			var sn=thisObj.attr('sn');
			$.ajax({
				url: "<?php echo bUrl($url['fast_add'],false)?>/<?php echo $language_word_type?>",
				type: "POST",
				cache:false,
				data: { content:content},
				dataType: "json",
				beforeSend:function(){
					thisObj.attr("disabled", true);
				},				
				complete:function(){
					//thisObj.attr("disabled", false);	
					window.location.reload(true);					
				}
			});			
			return false;
		})	
		
	})
	
	
</script>
