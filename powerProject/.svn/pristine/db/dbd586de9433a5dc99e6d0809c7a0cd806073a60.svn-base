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
			width:90%;
			min-width:40%;
		}
		.log table,table th{
			text-align:center;
		}
		.top{
			
			margin:10px 0px 10px 10px;
		}
	</style>
	<script>
	
		$(function(){
			redistimeout();
		})
		
		function redistimeout(){
				getredisdata();
				/*定时器*/
				setTimeout(function(){
					redistimeout();
				},2000);
			
			
		}
		
		/*计算一维json对象的长度*/
		function getJsonLength(jsonData) {  
		var length=0;  
		for(var ever in jsonData) {  
			length++;  
		}  
		return length;  
		}  
		
		
		function getredisdata(){
			var data = $("#data").text();
			$.ajax({
				url:'{{url("getredisdata")}}', //提交给当前控制器的方法
				type:'post',
				async: true, //异步执行
				data:{data:data},
				dataType:'json',
				headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content'),charset:'gb2312'},
				success:function(result){
					var length=getJsonLength(result);
					var num = Math.ceil(length/8);
					var msg='';
					msg +='<table class=\"table table-hover \" id=\"table\">';
					
					
					for(var j=0 ; j<num ; j++){
						msg +='<tr>';
							for(var i=0 ;i<8 ;i++){
								msg +='<td></td>';
							}
						msg +='</tr>';
						msg +='<tr>';
							for(var i=0 ;i<8 ;i++){
								msg +='<td></td>';
							}
						msg +='</tr>';
					}
					
					msg +='</table>';
					
					$("#redisTable").html(msg);
					/*分开保存json的key 与 value*/
					var karr = new Array(); //json 的 key
					var valarr = new Array(); //json key对应的value
					for(var key in result) {
						
						karr.push(key);
						valarr.push(result[key]);
					}
					
					
					/*像表格中添加数据*/
					var tdeven=$("#table tr:even").find("td");
					var tdodd=$("#table tr:odd").find("td");
					for(var i = 0 ; i < karr.length ; i++)
					{
						tdeven.eq(i).html("<b>"+karr[i]+"<b/>");
						tdodd.eq(i).html("<b><span style='color:#00688B;'>"+valarr[i]+"</span></b>");
					}
					
				},
				error:function(){
					// alert("获取数据失败,请刷新重试");
				}
				
			})
		}
		
		function back(){
			javascript:history.go(-1);
		}
	</script>
	<body>
		<div class="top">
			<b style="font-size:18px;color:#ff7d55;">&nbsp;&nbsp;&nbsp; {{$meterName}}&nbsp;&nbsp;---&nbsp;&nbsp;实时监测数据</b>
			<p id="data" hidden>{{$data}}</p>
		</div>
	<center>
		<div class="log" id="redisTable">
		
		</div>
		
		<div>
		<input type="button" onclick="back()" id='sel' type='button' value='返回' class='btn btn-info btn-sm top' />
		<div>
	</center>
	</body>
</html>

@endsection