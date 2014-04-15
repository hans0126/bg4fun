<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<META content="Orista" name="Author"> 
<meta name="keywords" lang="zh-TW" content="<? echo tryGetData("meta_keyword",$webSetting);?>"/>
<meta name="description" content="<? echo tryGetData("meta_description",$webSetting);?>">
<title><? echo tryGetData("website_title",$webSetting);?></title>
<link href="<?php echo base_url().$templateUrl;?>css/reset.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url().$templateUrl;?>css/unreset.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url().$templateUrl;?>css/default.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url().$templateUrl;?>js/jquery-1.8.3.min.js"></script>
<script>
$(function(){
		$("#sub_navi a > span").click(function(){
			var target_obj=$(this).parent().siblings('ul');
			if(target_obj.is(":hidden")){
				target_obj.show();
				$(this).parents('li').eq(0).addClass('this');
			}else{
				target_obj.hide();
				$(this).parents('li').eq(0).removeClass('this');
			}
		})
	})

</script>


<!-- 本頁使用-->
<?php echo $style_css;?>
<!-- 本頁使用-->
<?php echo $style_js;?>
</head>


<body>

<?php echo $header;?>

<?php echo $content;?>

<?php echo $footer;?>



</body>
</html>

