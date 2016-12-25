@extends('app')

@section('content')
 <div class="container col-sm-12">

 <div class="jumbotron">
 	<h1>Destination Routes</h1>
 </div>
 
 <div class="form-group col-sm-4">
  <label for="src">Source:</label>
  <select class="form-control" id="src">
    @foreach($nodes as $node)
 		<option value="{{$node}}">{{$node}}</option>
 	@endforeach
  </select>
</div>
 
<div class="form-group col-sm-4">
  <label for="dest">Destination:</label>
  <select class="form-control" id="dest">
    @foreach($nodes as $node)
 		<option value="{{$node}}">{{$node}}</option>
 	@endforeach
  </select>
</div>
 <br>
 <button id="btn" class="form-group btn btn-info btn-lg col-sm-4">Check Paths.. </button>
 
 <div class="routes col-sm-12">
 </div>

 </div>
 
@endsection


@section('js')
<script type="text/javascript" >
$('#btn').click(function(){
	if($('#src').val()==$('#dest').val())
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
    		if(paths.length==0)
    			alert("Sorry No path exists..");
    		var str="";
    		var i=0;
    		for(dist in paths)
    		{
    			for(j in paths[dist])
    			{
    			i++;
    			str += "<b><h4>Route "+i+" which takes "+dist+" time units:</h4></b>";
    				for(k in paths[dist][j])
    				{

    				if(k>0)
    				str+="<hr style='display:inline-block; width:"+(adj[paths[dist][j][k-1]][paths[dist][j][k]]/7)*1000+"px;'>";
    				str+="<b>"+paths[dist][j][k]+"</b>";
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
</script>
@endsection('js')