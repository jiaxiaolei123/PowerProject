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
			$(function(){
				ajaxcreat()
			})
			
			/*验证用户名*/	
			function checkname(){
				var uname = $("input[name='username']").val();
				/*用户名正则*/
				var unameret=/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/;
				var unamerett=/^[\u4e00-\u9fa5]{0,}$/;
				if((unameret.test(uname) ==false && unamerett.test(uname) ==false) || uname.length ==0){
					$("table span").eq(0).addClass("show");
					return false;
				}else{
					$("table span").eq(0).addClass("hidden");
					return true;
				} 
			}
			/*验证密码*/
			function checkpassword(){
				var password = $("input[name='password']").val();
				/*密码正则*/
				var passwordret = /^[a-zA-Z]\w{4,17}$/;
				if(passwordret.test(password) ==false){
					$("table span").eq(1).addClass("show");
					return false;
				}else{
					$("table span").eq(1).addClass("hidden");
					return true;
				}
			}
			/*验证真实姓名*/
			function checkrealname(){
				var realname = $("input[name='realname']").val();
				/*用户真实姓名*/
				var realnameret = /^[\u4e00-\u9fa5]{0,}$/;
				 if(realnameret.test(realname) ==false || realname.length ==0){
					$("table span").eq(2).addClass("show");
					return false;
				}else{
					$("table span").eq(2).addClass("hidden");
					return true;
				}
			}
			/*验证手机号*/
			function checktel(){
				var tel = $("input[name='tel']").val();
				/*手机号正则*/
				var telret = /^1[3|4|5|7|8][0-9]{9}$/;
				if(telret.test(tel) ==false){
					$("table span").eq(3).addClass("show");
					return false;
				}else{
					$("table span").eq(3).addClass("hidden");
					return true;
				}
			}
			/*验证邮箱*/
			function chenckemail(){
				var email = $("input[name='email']").val();
				/*邮箱正则*/
				var emailret=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
				if(emailret.test(email) ==false){
					$("table span").eq(4).addClass("show");
					return false;
				}else{
					$("table span").eq(4).addClass("hidden");
					return true;
				} 
			}
			
			/*验证角色权限分配*/
			function checkrole(){
				var numradio = $("input:radio[name='role']:checked").length;
				if(numradio ==0){
					$("table span").eq(5).addClass("show");
					return false
				}else{		
					$("table span").eq(5).addClass("hidden");
					return true;
				}
			}
			/*验证变电站分配*/
			function checkstation(){
				var num = $("input:checkbox[name='station[]']:checked");
				if(num.length ==0){
					$("table span").eq(6).addClass("show");
					return false;
				}else{
					$("table span").eq(6).addClass("hidden");
					return true;
				}
			}
			/*验证汇总*/
			function checkUname(){
				if(checkname() ==true && checkpassword()==true && checkrealname()==true && checktel()==true && chenckemail()==true && checkrole()==true && checkstation()==true){
					return true;
				}else{
					return false;
				}
			}
			
			function ajaxcreat(){
				$.ajax({
					url:'{{url("creatajax")}}',
					type:'POST',
					async: false, //同步执行
					data:{val:1},
					dataType:'json', //转换成json对象
					headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
					success:function(result){
						var role = $("#role");
						var station = $("#station");
						var userrole='';
						var userstation='';
						for(var i=0;i<result.role.length ; i++){
							userrole +="<label class=\"radio-inline\"><input type=\"radio\" name=\"role\" value="+result.role[i].Rid+" >"+result.role[i].RName+"</label>";
						}
						userrole+="<span>(角色权限位必选项)</span>";
						role.html(userrole);
						
						for(var j=0 ; j<result.station.length ; j++){
							userstation +="<label class=\"checkbox-inline\"><input type=\"checkbox\" id=\"box1\" name=\"station[]\" value="+result.station[j].StationId+"_"+result.station[j].StationSingle+">"+result.station[j].StationName+"</label>";
						}
						userstation +="    <span>(变电站位必选项)</span>";
						station.html(userstation);
						
						
					},
					error:function(){
						alert("查询角色或变电站信息失败!");
					}
				})
			}
			
			
			
			function createFormajax(){
				if(checkUname()){
					$.ajax({
						url:'{{url("creatmanager")}}',
						type:'POST',
						async: false, //同步执行
						data:$("#creatform").serialize(),
						dataType:'json', //转换成json对象
						headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
						success:function(result){
							if(result ==2){
								alert("用户名已存在!");
							}else{
								window.location.href="{{url('powermanager')}}";
							}
								
							
						},
						error:function(){
							alert("新增人员信息失败哦");
						}
					})
				}
			}
		</script>
		<ul id="myTab" class="nav nav-tabs">
			<li>
				<a href="{{url('powermanager')}}">
					 <b>人员信息</b>
				</a>
			</li>
			<li class="active">
				<a href="#creat" onclick="ajaxcreat()" >
				<b>新增人员</b>
				</a>
			</li>

		</ul>
		<div id="myTabContent" class="tab-content">
			<form action="{{url('creatmanager')}}" role="form" id="creatform" method="POST">
				{!! csrf_field() !!}
				
				<center>
					<div class="creatUser">
						<table class="table table-hover" style="margin-top:10px;">
							<tr>
								<td class="right"><b>用户名:</b></td>
								<td>
								<input type="text" name="username"  value="" />
								<span>(字母开头，允许5-16字节，允许字母数字下划线)</span>
								</td>
							</tr>
							<tr>
								<td class="right"><b>密码:</b></td>
								<td>
								<input type="text" name="password" value="" />
								<span>(以字母开头，长度在6~18之间，只能包含字母、数字和下划线)</span>
								</td>
							</tr>
							<tr>
								<td class="right"><b>真实姓名:</b></td>
								<td>
								<input type="text" name="realname" value="" />
								<span>(必须为汉字)</span>
								</td>
							</tr>
							<tr>
								<td class="right"><b>电话号码:</b></td>
								<td>
								<input type="text" name="tel" value="" />
								<span>(11位正确电话号码)</span>
								</td>
							</tr>
							<tr>
								<td class="right"><b>邮箱:</b></td>
								<td>
								<input type="text" name="email" value="" />
								<span>(符合正确邮箱格式)</span>
								</td>
							</tr>
							<tr>
								<td class="right"><b>角色分配:</b></td>
								<td id="role">
									
									
								</td>
							</tr>
							<tr>
								<td class="right"><b>变电站分配:</b></td>
								<td id="station">
									
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