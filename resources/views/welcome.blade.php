@extends('app')

@section('content')

 <div class="container col-sm-12">

 	<div class="jumbotron">
 		<h1>Destination Routes</h1>
 	</div>
 
 	<!-- select input box using bootstrap -->
 	<div class="form-group col-sm-4">
  		<label for="src">Source:</label>
  		<select class="form-control" id="src">
    		@foreach($nodes as $node)
 				<option value="{{$node->name}}">{{$node->name}}</option>
 			@endforeach
  		</select>
	</div>
 
 	<!-- select input box using bootstrap -->
	<div class="form-group col-sm-4">
		<label for="dest">Destination:</label>
  		<select class="form-control" id="dest">
    		@foreach($nodes as $node)
 				<option value="{{$node->name}}">{{$node->name}}</option>
 			@endforeach
 		 </select>
	</div><br>
 
 	<button id="btn" class="form-group btn btn-info btn-lg col-sm-4">Check Paths.. </button>
 
 <!-- this div will contain the dynamically generated data.. -->
 	<div class="routes col-sm-12">
 	</div>

 </div>
 <!-- end of container div -->

@endsection


@section('js')
<script type="text/javascript" >

//creating the onclick event for button
$('#btn').click(function(){

	if($('#src').val()==$('#dest').val())
	{
		$('.routes').html("");
        alert("Source and Destination is same..")
	}
	else
	{
		//making ajax call to Homecontroller/check_path
	$.ajax({
			type: 'get',
			headers: {
       			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
    		url: '/check_paths',
    		data: {
    			//sending source and destination to controller
    			'src':$("#src").val(),
    			'dest':$("#dest").val(),
    		},
    		success: function(data){

    			data=JSON.parse(data);
    			adj=data.adj;
    			//adj contains the adjacency matrix for graph

    			paths=data.paths;
    			//paths contains all the paths in this format 
    			//where 2,5,9 represents the total distance need to travel therespective paths
    			//paths:
				// 2:[["S", "V"]]
				// 5:[["S", "X", "V"]]
				// 9:[["S", "T", "V"], ["S", "T", "X", "V"]]
    			if(paths.length==0)
    			{
    				$('.routes').html("");
                    alert("Sorry No path exists..");
    			}
    			else
    			{
    				//str contains the html code for the routes div
    				var str="";
    				//variable i contains the total number of paths..
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
    		
    				$('.routes').html(str);
    			}//end of else part
    		}//end of success function
		});//end of ajax call
	}//end of else part of src=dest condition
})//end of on click fucntion
</script>
@endsection('js')