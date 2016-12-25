@extends('app')

@section('content')
 <select id="src" class="title">
 	@foreach($nodes as $node)
 		<option value="{{$node}}">{{$node}}</option>
 	@endforeach
 </select>
 <select id="dest" class="title">
 	@foreach($nodes as $node)
 		<option value="{{$node}}">{{$node}}</option>
 	@endforeach
 </select>
 <button id="btn" >Check Paths.. </button>
@endsection


@section('js')
<script type="text/javascript">
$('#btn').click(function(){
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
    			alert(data);
    			alert("done")
    		}
		});
})
</script>
@endsection('js')