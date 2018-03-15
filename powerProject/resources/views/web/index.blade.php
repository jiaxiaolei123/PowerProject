<!DOCTYPE html>
<html margin="0">
<head>
	<title></title>
	<meta charset="utf-8">
	
   
	<link rel="stylesheet" type="text/css" href="{{asset('css/htmleaf-demo.css')}}">
	<link rel="stylesheet" href="{{asset('css/sidebar-menu.css')}}">
	<script type="text/javascript" src="{{asset('js/jquery-2.1.1.min.js')}}"></script>
	<link href="{{asset('js/My97DatePicker/skin/WdatePicker.css')}}" rel="stylesheet" />
    <script src="{{asset('js/My97DatePicker/WdatePicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.css')}}">
	
	
	<style>
	.topo{
		background:-webkit-gradient(linear, 0% 0%, 0% 100%,from(#555555), to(#232323));    /*-webkit-gradient属性  参数：linear线性渐变*/
		background-repeat:no-repeat;float:left;
		height:60px;
		width:100%;
	}
	.nav-top{float:left;margin-right:20px;}
	.nav-top img{float:left;margin:7px;}
	.nav-top a{font-size: 23px;color:#fff;text-decoration: none;float:left;margin-top:17px;font-family:宋体;}
	.time-date{width:350px;height:30px;float:right;margin-top: 20px;margin-right:60px;}
	#date1,#date2,#date3,#date4,#date5,#date6,#date7{display: inline-block;color:#fff;font-size: 12px;}
	span{color:#fff;font-size: 14px;}
	*{margin:0;padding:0;}
	.time-date span{font-size:12px;}
	.main-sidebar{
		float:left;
		min-width:150px;
	    min-height: 93.5%;
	    width: 12%;
	    /*z-index: 810;*/
	    background-color: #494949;
	    
	 }
	 
	#sidebar a{
		text-decoration:none;
	}
	.time-date a{
		display:inline-block;
		text-decoration:none;
		font-size:14px;
	}
	.right-pui{
		width:88%;
		float:right;
		min-height: 93.5%;
			
	}
	 .treeview{background-color: #494949;}
	 .treeview-menu{background-color: #343434;}
	 
		
	

	 .treeview img{width:20px;height:20px;margin-right:10px;}
	 .treeview-menu li:hover{background-color:#212429;}

	</style>
</head>
<body style='overflow:scroll;overflow-y:auto;overflow-x:auto '>
	@section('top')
	<!-- 头部 -->
	<div class="topo">
		<div class="nav-top"><img src="{{asset('image/logo.png')}}"><a href="#">电力品质检测与能效管理平台</a></div>
		<div class="time-date">
			<span>当前时间:</span>
			<span>20</span><span id="date1"></span><span>年</span>
			<span id="date2"></span><span>月</span>
			<span id="date3"></span><span>日</span>
			<span id="date4"></span><span>时</span>
			<span id="date5"></span><span>分</span>
			<span id="date6"></span><span>秒</span>
			<span id="date7"></span>&nbsp;&nbsp;&nbsp;&nbsp;
			<a id="identifier" data-toggle="tooltip" data-placement="bottom" title="退出登录" href="{{url('loginOut')}}"><span class="glyphicon glyphicon-off"></span></a>
		</div>
	</div>
	@show
	@section('left')
	<!-- 左边导航栏 -->
	 <aside class="main-sidebar">

		<section  class="sidebar">
		    <ul id="sidebar" class="sidebar-menu">
			      <li class="header">MAIN NAVIGATION</li>
				  @foreach($stationPower as $k)
					  <li class="treeview" style="display:block">
							<a  href="#">
								 <img src="{{asset('image/zhujiemian.png')}}">
								 <span >{{$k->PName}}</span>
							</a>
							<ul class="treeview-menu">
							@if($k->Pid ==8)
								<li><a href="{{url('log')}}">日志管理</a></li>
								<li><a href="{{url('powermanager')}}">人员管理</a></li>
								<li><a href="{{url('rolemanager')}}">角色权限管理</a></li>
							@endif
							@if($k->Pid !=8)
								@foreach($stationDate as $key)
									<li><a href="{{url('common')}}/{{$k->Pid}}/{{$key->StationId}}_{{$key->StationSingle}}">{{$key->StationName}}</a></li>
								@endforeach
							@endif
							</ul>
					  </li>
				 @endforeach
			    
		    </ul>
		</section>
	</aside>
	@show

     <!-- 右边主体 -->
	<div class="right-pui">
			@yield('content')	
	</div>
	

</body>
	<script>
			var myDate = new Date();
			var Y = myDate.getYear()%100;
			var M = myDate.getMonth()+1;
			var D = myDate.getDate()
			var H = myDate.getHours()
			var F = myDate.getMinutes()
			var S = myDate.getSeconds();
			var weekday = new Array(7)
				weekday[0]="星期日"
				weekday[1]="星期一"
				weekday[2]="星期二"
				weekday[3]="星期三"
				weekday[4]="星期四"
				weekday[5]="星期五"
				weekday[6]="星期六"
				// document.write()
			// var X= myDate.getMilliseconds()

			var y = Y;
			var m = M;
			var d = D;
			var h = H;
			var f = F;
			var s = S;
			// var x = X;


			var sool= document.getElementById('date6')
				sool.innerHTML=s;
			var fool= document.getElementById('date5')
				fool.innerHTML=f;
			var hool= document.getElementById('date4')
				hool.innerHTML=h;
			var dool= document.getElementById('date3')
				dool.innerHTML=d;
			var mool= document.getElementById('date2')
				mool.innerHTML=m;
			var yool= document.getElementById('date1')
				yool.innerHTML=y;
			var wool= document.getElementById('date7')
				wool.innerHTML=weekday[myDate.getDay()];

		setInterval(function fun(){

			s++;
			if(s>59){
				s=0;
				f=f+1;
				if(f>59){
					f=0;
					h=h+1
					if(h>24){
						h=0
						d=d+1;
						if(d>30){
							m+1;
							y=y+1
						}else{
							hool.innerHTML=h;
						}
					}else{
						hool.innerHTML=h;
					}
				}else{
					fool.innerHTML=f;
				}
			}else{
				sool.innerHTML=s;
			}

		},1000)

	</script>
	<script>window.jQuery || document.write('<script src="js/jquery-2.1.1.min.js"><\/script>')</script>
	<script type="text/javascript" src="{{asset('js/sidebar-menu.js')}}"></script>
	<script>
	    $.sidebarMenu($('.sidebar-menu'));
		
	</script>
</html>