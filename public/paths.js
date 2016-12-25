$('#btn').click(function(){
	if($('#src').val()==$('dest').val())
		alert("Source and Destination is same..")
	else
	{
	$.ajax({
			type: 'get',
			headers: {
       			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
    		url: '/check_paths',
    		data: {
    			'src':$("#src").val(),
    			'dest':$("#dest").val(),
    		},
    		success: function(data){
    			data=JSON.parse(data);
    			adj=data.adj;
    			paths=data.paths;
    		
    		var str="";
    		var i=0;
    		for(dist in paths)
    		{
    			for(j in paths[dist])
    			{
    			i++;
    			str += "<b>Route "+i+":</b><br>";
    				for(k in paths[dist][j])
    				{

    				if(k>0)
    				str+="<hr style='display:inline-block; width:"+(adj[paths[dist][j][k-1]][paths[dist][j][k]]/7)*1000+"px;'>";
    				str+=paths[dist][j][k];
   					}
    			str+="<br><br>";
    			}
    		}
    		console.log(str);
    		$('.routes').html(str);

    		}
		});
}
})