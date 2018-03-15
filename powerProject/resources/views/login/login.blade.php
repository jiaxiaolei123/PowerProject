<html>
	<head>
		<meta charset="utf-8">
		<title>系统登录</title>
		<style>
			*{margin:0;padding:0;font-family: 微软雅黑;}
			.yu-div{background-image:url(image/yu-1.jpg);width:100%;height:100%;repeat:no-repeat;position:relative;background-size:100%;}   /*background-size:规定背景图像的尺寸*/
		    .yu-denglu-shadow{width:300px;height:300px;background-color:rgba(225,225,225,.2);position:absolute;top:50%;left:50%;margin-top:-150px;margin-left:-150px;}
		    .yu-delu-limian{width:96%;height:96%;background-color: rgba(255,255,255,.3);margin-left: 2%;margin-top:2%;}
		    .yu-text{text-align:center;font-weight:bold;color:#fff;padding:18px 0;font-size:10;}
		    .yu-zhanghao{position:relative;}
		    .yu-input-1,.yu-input-2{background-color:#fff;border:none;width:70%;margin:0 15%;padding:5px 0;font-size:12px;border-radius: 3px;text-indent:10px;}   /*text-indent: 首行文本缩进*/
		    .yu-mima{position:relative;margin-top:30px;}
		    .yu-login{width:70%;margin:0 auto;padding:5px 0;text-align:center;color:#fff;background-color:#337ab7;border-radius:3px;font-weight:bold;margin-top:30px;margin-left:43px;}
		    .yu-error-1,.yu-error-2{position:absolute;top:30px;left:40px;color:#fff;font-size:12px;display:none;}
		</style>
	</head>

	<body>
			<div class="yu-div">
				<form method="post" action="{{url('dologin')}}"> 
				     <div class="yu-denglu-shadow">
				     	  <div class="yu-delu-limian">
				     	  	    <div class="yu-text"><h1>系统登录</h1></div>
		                        <div class="yu-zhanghao">
		                        	 <input type="text" required="required" class="yu-input-1" placeholder="账号" name="UserName" ></input>
		                        	<!--  <div class="yu-error-1">账号不能为空</div> -->

		                        	 @if(Session::has('error'))
		                        	 	   <div class="yu-error-1">{{Session::pull('error')}}</div>
		                        	 @endif
		                        </div>

		                        <div class="yu-mima">
		                        	 <input type="password" required="required" class="yu-input-2" placeholder="密码" name="UserPwd" ></input>
		                        	 <!-- <div class="yu-error-2">密码不能为空</div> -->

		                        	 @if(Session::has('pwdErroe'))
		                        	 	   <div class="yu-error-2">{{Session::pull('pwdErroe')}}</div>
		                        	 @endif
		                        </div>
	                            
	                            {{csrf_field()}}
		                        <button class="yu-login" type="submit">登录</button>
				     	  </div>
				     </div> 
			     </form>
			</div>
	</body>


	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script>
		$('.yu-login').click(function(){
			if($('.yu-input-1').val()==''){
				$('.yu-error-1').show();
			}else{
				$('.yu-error-1').hide();
			}

			if($('.yu-input-2').val()==''){
				$('.yu-error-2').show();
			}else{
				$('.yu-error-2').hide();
			}
		})
	</script>
</html>