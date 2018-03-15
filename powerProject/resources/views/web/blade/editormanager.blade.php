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
		function ajaxForm(){
			if(check()){
				ajax()
			}
		}
		/*检查表单提交项目*/
		function check(){
			var uname = $("input[name='uname']").val();
			var password = $("input[name='password']").val();
			var realname = $("input[name='realname']").val();
			var tel = $("input[name='tel']").val();
			var email = $("input[name='email']").val();
			/*用户名正则*/
			var unameret=/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/;
			var unamerett=/^[\u4e00-\u9fa5]{0,}$/;
			/*密码正则*/
			var passwordret = /^[a-zA-Z]\w{4,17}$/;
			/*用户真实姓名*/
			var realnameret = /^[\u4e00-\u9fa5]{0,}$/;
			/*手机号正则*/
			var telret = /^1[3|4|5|7|8][0-9]{9}$/;
			/*邮箱正则*/
			var emailret=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
			var num = $("input:checkbox[name='station[]']:checked");
			
			if((unameret.test(uname) ==false && unamerett.test(uname) ==false) || uname.length ==0){
				$("table span").eq(0).css("display",'inline-block');
				return;
			}else if(passwordret.test(password) ==false){
				$("table span").eq(1).css("display",'inline-block');
				return;
			}else if(realnameret.test(realname) ==false || realname.length ==0){
				$("table span").eq(2).css("display",'inline-block');
				return;
			}else if(telret.test(tel) ==false){
				$("table span").eq(3).css("display",'inline-block');
				return;
			}else if(emailret.test(email) ==false){
				$("table span").eq(4).css("display",'inline-block');
				return;
			}else if(num.length ==0){
				$("table span").eq(5).css("display",'inline-block');
				return;
			}
			return true;
			
		}
		
		/*ajax提交表单*/
		function ajax(){
			$.ajax({
				url:'{{url("editormanager")}}',
				type:'POST',
				async: false, //同步执行
				data:$("#form").serialize(),
				dataType:'json', //转换成json对象
				headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
				success:function(result){
					if(result==1){
						window.location.href="{{url('powermanager')}}";
					}else if(result==0){
						alert("人员信息无修改");
						window.location.href="{{url('powermanager')}}";
					}
					
				},
				error:function(){
					alert("编辑人员信息失败哦");
				}
			})
		}
		
	</script>
	<body>
		<center>
		<div class="editor">
			<form action="#" method="POST" id="form">
				<table class="table table-hover">
					@foreach($userMsg as $user)
					<tr>
						<td><b>用户ID</b></td>
						<td><input type="text"  name="UID" readonly value="{{$user->UID}}" /></td>
					</tr>
					<tr>
						<td><b>用户名</b></td>
						<td>
						<input type="text" name="uname" value="{{$user->UName}}" />
						<span>*字母开头，允许5-16字节，允许字母数字下划线或纯汉字</span>
						</td>
					</tr>
					<tr>
						<td><b>密码</b></td>
						<td>
						<input type="text" name="password" value="{{$user->Password}}" />
						<span>*字母开头，允许5-16字节，允许字母数字下划线</span>
						</td>
					</tr>
					<tr>
						<td><b>用户姓名</b></td>
						<td>
							<input type="text" name="realname" value="{{$user->RealName}}" />
							<span>*用户真实姓名不符合条件(汉字姓名)</span>
						</td>
					</tr>
					<tr>
						<td><b>电话</b></td>
						<td>
							<input type="twxt" name="tel" value="{{$user->Telephone}}" />
							<span>*电话号码不符合条件(11位手机号)</span>
						</td>
					</tr>
					<tr>
						<td><b>邮箱</b></td>
						<td>
						<input type="text" name="email" value="{{$user->Email}}" />
						<span>*邮箱格式不符合要求</span>
						</td>
					</tr>
					@endforeach
					<tr>
						<td style="width:150px;"><b>角色分配</b></td>
						<td>
							<select name="role" id="userRole" >
								@foreach($role as $Urole)
									<option value="{{$Urole->Rid}}">{{$Urole->RName}}</option>
								@endforeach
							</select>
						</td>
					</tr>
					<tr>
						<td><b>变电站分配</b></td>
						<td>
								@foreach($tstation as $station)
									<label class="checkbox-inline">
										<input type="checkbox" name="station[]" id="{{$station->StationId}}" value="{{$station->StationId}}">{{$station->StationName}}
										<span>*变电站不能为空</span>
									</label>
								@endforeach
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<a href="{{url('powermanager')}}"><input type="button" value="取消" class="btn btn-info btn-sm" /></a>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" value="确认" class="btn btn-warning btn-sm" onclick="ajaxForm()" />
						</td>
					</tr>
				</table>
			</form>
		</div>
		</center>
	</body>
	
</html>
@endsection