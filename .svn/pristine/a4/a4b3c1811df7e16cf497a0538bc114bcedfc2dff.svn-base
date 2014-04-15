
<script>
    $(function(){
      $('#search_start').click(function(){
         var keyword=$('input[name=keyword]').val();
         if(keyword){
              $.ajax({
                   type: "POST",
                   dataType:"json",
                   url: "<?php echo getFrontendUrl('search_result')?>",
                   data: { keyword: keyword},
                   success:function(data){
                        var insertText='';
                        for(i=0;i<data.length;i++){                            
                           insertText+="<tr><td><a href='#' g_id='"+data[i].game_id+"'>"+data[i].name+"</a></td></tr>";                          
                        }
                        
                        $('#result_list').html(insertText).find('a').on("click",load_detail);                        
                   }                
              })          
          }
      })        
    })
    
    function load_detail(){        
        var bgg_id=$(this).attr('g_id');
        if(bgg_id){
            $.ajax({
                   type: "POST",
                   dataType:"json",
                   url: "<?php echo getFrontendUrl('bg_detail')?>",
                   data: { bgg_id: bgg_id},
                   success:function(data){
                        var insertText='';
                        for(var k in data) {
                            insertText+="<tr><td>"+data[k]+"</td></tr>";
                        }
                          
                         $('#detail_table').html(insertText);                          
                   }                
              })     
            
        }
      
    }
    
</script>


<input type="text" name="keyword">
<button type="button" id="search_start">搜尋</button>
<table id="result_list">
    
    
</table>
<table id="detail_table">
    
    
</table>



<div id="text"></div>