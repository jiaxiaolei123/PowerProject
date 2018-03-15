@extends('web.index')
@section('content')
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-Type" name="_token" content="{{ csrf_token() }}"  />
		<script src="{{asset('js/jquery-2.1.1.min.js')}}" type="text/javascript" ></script>
	</head>
	<style>
		.rolemain{
			width:90%;
		}
		
	</style>
	<body>
	<ul id="myTab" class="nav nav-tabs">
		<li class="active">
			<a href="#home">
				 <b>角色信息</b>
			</a>
		</li>
		<li>
			<a href="{{url('creatrole')}}">
				 <b>新增角色</b>
			</a>
		</li>

	</ul>
		<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="home">
			<center>
				<div class="rolemain">
				@if(Session::has('roleok'))
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">
						&times;
					</a>
					<strong>{{Session::get('roleok')}}</strong>
				</div>
				@endif
				@if(Session::has('roleno'))
				<div class="alert alert-warning">
					<a href="#" class="close" data-dismiss="alert">
						&times;
					</a>
					<strong>{{Session::get('roleno')}}</strong>
				</div>
				@endif
				@if(Session::has('have'))
					<div class="alert alert-warning">
					<a href="#" class="close" data-dismiss="alert">
						&times;
					</a>
					<strong>{{Session::get('have')}}</strong>
				</div>
				@endif
					<table class="table table-hover">
						<thead>
							<th>角色ID</th>
							<th>角色名称</th>
							<th>角色描述</th>
							<th>角色权限</th>
							<th>操作</th>
						</thead>
						<tbody>
						@foreach($roleArr as $key)
							<tr>
								<td>{{$key->Rid}}</td>
								<td>{{$key->RName}}</td>
								<td>{{$key->description}}</td>
								<td>
								@foreach($key->PName as $k)
									{{$k['PName']}}&nbsp;&nbsp;
								@endforeach
								</td>
								<td>
								@if($key->Rid == 2)
									<a href="{{url('editorrole')}}/{{$key->Rid}}"><input type="button"  disabled="disabled" value="编辑" class="btn btn-info btn-xs" /></a>
									&nbsp;&nbsp;
									<a href="{{url('deleterole')}}/{{$key->Rid}}" onClick="return confirm('确定删除?');">
										<input type="button"  disabled="disabled" value="删除" class="btn btn-danger btn-xs" />
									</a>
								@elseif($key->Rid !=2)
									<a href="{{url('editorrole')}}/{{$key->Rid}}"><input type="button"   value="编辑" class="btn btn-info btn-xs" /></a>
									&nbsp;&nbsp;
									<a href="{{url('deleterole')}}/{{$key->Rid}}" onClick="return confirm('确定删除?');">
										<input type="button"  value="删除"  class="btn btn-danger btn-xs" />
									</a>
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