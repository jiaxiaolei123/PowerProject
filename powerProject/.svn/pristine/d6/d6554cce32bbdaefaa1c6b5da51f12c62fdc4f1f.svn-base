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
		.editor{
			width:80%;
		}
		.editor a{
			text-decoration:none;
		}
		.table span{
			color:red;
			display:none;
		}
	</style>
	<script type="text/javascript">
	function roleForm(){
			if(check()){
				ajax();
			}
		}
		function check(){
			var name=$("#rname").val().trim();
			var des=$("#des").val().trim();
			var num = $("input:checkbox[name='rolePower[]']:checked");
			
			if(name.length ==0){
				alert("角色名称不能为空!!!");
				return false;
			}else if(des.length ==0){
				alert("角色描述不能为空!!!")
				return false;
			}else if(num.length ==0){
				alert("角色权限不能为空!!");
				return false;
			}else{
				return true;
			}
			
		}
		
		function ajax(){
			$.ajax({
				url:'{{url("ajaxrole")}}',
				type:'POST',
				async: false, //同步执行
				data:$("#roleform").serialize(),
				dataType:'json', //转换成json对象
				headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
				success:function(result){
					if(result==1){
						window.location.href="{{url('rolemanager')}}";
					}else if(result==0){
						alert("角色信息无修改");
						window.location.href="{{url('rolemanager')}}";
					}
					
				},
				error:function(){
					alert("编辑角色信息失败哦");
				}
			})
		}
	</script>
	<body>
		<center>
			<div class="editor">
				<form action="#" method="POST" id="roleform">
					<table class="table table-hover">
						@foreach($roleArr as $k)
							<tr>
								<td><b>角色ID</b></td>
								<td><input type="text"  name="Rid" id="Rid" readonly value="{{$k->Rid}}" /></td>
							</tr>
							<tr>
								<td><b>角色名称</b></td>
								<td><input type="text"  name="rname" ID="rname"  value="{{$k->RName}}" /></td>
							</tr>
							<tr>
								<td><b>角色描述</b></td>
								<td> 
									<textarea class="form-control" name="des" id="des" rows="2">{{$k->description}}</textarea>
								</td>
							</tr>
							<tr>
								<td><b>角色权限分配</b></td>
								<td>
								@foreach($stationpower as $power)
									<label class="checkbox-inline">
										<input type="checkbox" name="rolePower[]" id="{{$power->Pid}}" checked value="{{$power->Pid}}" >{{$power->PName}}
									</label>
								@endforeach
								</td>
							</tr>
						@endforeach
						<tr>
							<td colspan="2">
								<a href="{{url('rolemanager')}}"><input type="button" value="取消" class="btn btn-info btn-sm" /></a>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" value="确认" class="btn btn-warning btn-sm" onclick="roleForm()" />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</center>
	</body>
</html>
@endsection