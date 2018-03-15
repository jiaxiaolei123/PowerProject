@extends('web.index')
@section('content')
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8' />
		<meta http-equiv="Content-Type" name="_token" content="{{ csrf_token() }}"  />
		<script src="{{asset('js/jquery-2.1.1.min.js')}}" type="text/javascript" ></script>
	</head>
	<style>
		.main{
			width:90%;
		}
		
	</style>
	
	<body>
	<ul id="myTab" class="nav nav-tabs">
		<li class="active">
			<a href="#home">
				 <b>人员信息</b>
			</a>
		</li>
		<li>
			<a href="{{url('createmanagerBlade')}}">
				 <b>新增人员</b>
			</a>
		</li>

	</ul>
	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="home">
			<center>
				<div class="main">
				@if(Session::has('ok'))
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">
						&times;
					</a>
					<strong>{{Session::get('ok')}}</strong>
				</div>
				@endif
				@if(Session::has('no'))
				<div class="alert alert-warning">
					<a href="#" class="close" data-dismiss="alert">
						&times;
					</a>
					<strong>{{Session::get('no')}}</strong>
				</div>
				@endif
					<table class="table table-hover">
						<thead>
							<th>用户名</th>
							<th>角色名</th>
							<th>密码</th>
							<th>用户姓名</th>
							<th>电话</th>
							<th>邮箱</th>
							<th>操作</th>
						</thead>
						<tbody>
							@foreach($userData as $key)
							<tr>
								<td>{{$key->UName}}</td>
								<td>{{$key->RName}}</td>
								<td>{{$key->Password}}</td>
								<td>{{$key->RealName}}</td>
								<td>{{$key->Telephone}}</td>
								<td>{{$key->Email}}</td>
								<td>
									@if($key->Rid ==2)
									<a href="{{url('editor')}}/{{$key->UID}}"><input type="button"  disabled="disabled" value="编辑" class="btn btn-info btn-xs" /></a>
									&nbsp;&nbsp;
									<a href="{{url('delete')}}/{{$key->UID}}" onClick="return confirm('确定删除?');"><input type="button"  disabled="disabled" value="删除" class="btn btn-danger btn-xs" /></a>
									@elseif($key->Rid !=2)
									
									<a href="{{url('editor')}}/{{$key->UID}}"><input type="button"  value="编辑" class="btn btn-info btn-xs" /></a>
									&nbsp;&nbsp;
									<a href="{{url('delete')}}/{{$key->UID}}" onClick="return confirm('确定删除?');"><input type="button"   value="删除" class="btn btn-danger btn-xs" /></a>
									
									@endif
								</td>
							</tr>
							@endforeach
							
						</tbody>
					</table>
				</div>
			</center>		
		</div>
		

	</div>
	</body>
</html>
@endsection