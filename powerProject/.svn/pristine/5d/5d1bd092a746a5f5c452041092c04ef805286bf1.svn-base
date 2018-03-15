@extends('web.index')
@section('content')
<!DOCTYPE>
<html>
	<head>
		<meta charset="utf-8" />
		<meta charset='utf-8' />
		<meta http-equiv="Content-Type" name="_token" content="{{ csrf_token() }}"  />
		<script src="{{asset('js/jquery-2.1.1.min.js')}}" type="text/javascript" ></script>
	</head>
		<style>
		.creatUser{
				width:90%;
			}
		.creatUser .right{
			text-align:right;
			width:200px;
		}
		.table span{
			color:red;
			display:none;
		}
		
		.show{
			display:block;
		}
		.hidden{
			display:none;
		}
		.error{
			display:block;
		}
		</style>
		
	<body>
		<script type="text/javascript">
		
			
			/*验证角色名*/	
			function checkname(){
				var uname = $("input[name='rolename']").val();
				/*用户名正则*/
				var unameret=/^[\u4e00-\u9fa5]{0,}$/;
				if((unameret.test(uname) ==false) || uname.length ==0){
					$("table span").eq(0).addClass("show");
					return false;
				}else{
					$("table span").eq(0).addClass("hidden");
					return true;
				} 
			}
			
			/*验证角色描述*/
			function checkrole(){
				var des=$("#roledes").val().trim();
				if(des.length ==0){
					$("table span").eq(1).addClass("show");
					return false
				}else{		
					$("table span").eq(1).addClass("hidden");
					return true;
				}
			}
			
			/*验证汇总*/
			function checkUname(){
				if(checkname() ==true && checkrole()==true ){
					return true;
				}else{
					return false;
				}
			}
			
			/*验证权限分配**/
			function checkpower(){
				var num = $("input:checkbox[name='power[]']:checked");
				if(num.length==0){
					$("table span").eq(2).addClass("show");
					return false
				}else{
					$("table span").eq(2).addClass("hidden");
					return true;
				}
			}
			
		function createFormajax(){
				
				if(checkUname() && checkpower()){
					$.ajax({
						url:'creatroleAjax',
						type:'POST',
						async: false, //同步执行
						data:$("#creatroleform").serialize(),
						dataType:'json', //转换成json对象
						headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
						success:function(result){
							if(result ==2){
								alert("角色名已存在");
							}else{
								window.location.href="{{url('rolemanager')}}";
							}
							
						},
						error:function(){
							alert("新增角色信息失败哦!!");
						}
					})
				}
			}
		</script>
		<ul id="myTab" class="nav nav-tabs">
			<li>
				<a href="{{url('rolemanager')}}">
					 <b>角色信息</b>
				</a>
			</li>
			<li class="active">
				<a href="#creat" onclick="ajaxcreat()" >
				<b>新增角色</b>
				</a>
			</li>

		</ul>
		<div id="myTabContent" class="tab-content">
			<form action="{{url('creatmanager')}}" role="form" id="creatroleform" method="POST">
				{!! csrf_field() !!}
				
				<center>
					<div class="creatUser">
						<table class="table table-hover" style="margin-top:10px;">
							<tr>
								<td class="right"><b>角色名:</b></td>
								<td>
								<input type="text" name="rolename"  value="" />
								<span>(*角色名称为汉字)</span>
								</td>
							</tr>
							
							<tr>
								<td class="right"><b>角色描述:</b></td>
								<td>
								<textarea class="form-control" name="roledes" id="roledes" rows="2"></textarea>
								<span>(*角色描述不能为空)</span>
								</td>
							</tr>
							<tr>
								<td class="right"><b>角色权限分配:</b></td>
								<td id="rolepower">
									@foreach($power as $k)
									<label class="checkbox-inline">
									<input type="checkbox" id="box1" name="power[]" value="{{$k->Pid}}">{{$k->PName}}
									</label>
									@endforeach
									<span>(*角色权限不能为空)</span>
								</td>
							</tr>
							<tr>
								<td></td>
								<td><input type="button" value="确认"  onclick="createFormajax()" class="btn btn-success btn-sm" /></td>
							</tr>
						</table>
				
					</div>
				</center>
			</form>
		</div>
	</body>
</html>
@endsection