@extends('web.index')
@section('content')
<!DCOTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-Type" name="_token" content="{{ csrf_token() }}"  />
	<script src="{{asset('js/jquery-2.1.1.min.js')}}" type="text/javascript" ></script>
	</head>
	<style>
		.log{
			width:80%;
			min-width:40%;
		}
		.log table,table th{
			text-align:center;
		}
	</style>
	<body>
	<center>
	<div class="log">
		<table class="table table-hover ">
			<thead>
				<tr>
					<th>用户</th>
					<th>操作</th>
					<th>时间</th>
				</tr>
			</thead>
			<tbody>
				@foreach($Log as $k=>$v)
				<tr>
					<td>{{$v->AdminName}}</td>
					<td>{{$v->Operation}}</td>
					<td>{{$v->Rectime}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		</div>
		</center>
		<center>{{ $Log->links() }}</center>
	</body>
</html>

@endsection