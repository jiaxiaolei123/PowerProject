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
	</style>
	<script type="text/javascript">
		$(function(){
			timeout();
		});
		function timeout(){
			
			test();
			/*定时器*/
			setTimeout(function(){
				timeout();
			},2000);
			
		}

		function test(){
			var paramArr=Array();
			var num = $("#table tbody tr").length;
			for(var i=0 ; i<num; i++){
				
				paramArr[i] = $("#table tbody tr").eq(i).find("td").eq(7).find("a").attr("value");
			}
			/*获取实时数据*/
			$.ajax({
				url: '{{url("getredis")}}',
				type:'POST',
				async: false, 
				data: {param:paramArr},
				dataType:'json',
				headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content'),charset:'utf-8'},
				success:function(result){
					
					for (var i=0 ;i<num ; i++){
						
						var matnNum=JSON.parse(result[i]);
						if(matnNum.Va ==null){
							matnNum.Va="-";
						}
						if(matnNum.Vb ==null){
							matnNum.Vb="-";
						}
						if(matnNum.Vc ==null){
							matnNum.Vc="-";
						}
						if(matnNum.Vab ==null){
							matnNum.Vab="-";
						}
						if(matnNum.Vbc ==null){
							matnNum.Vbc="-";
						}
						if(matnNum.Vca ==null){
							matnNum.Vca="-";
						}
						if(matnNum.Va>230 || matnNum.Va<220){
							var v=$("#table tbody tr").eq(i).find("td").eq(1).html('<span style="color:red;"><b>'+matnNum.Va+'</b></span>');
						
						}else{
							var v=$("#table tbody tr").eq(i).find("td").eq(1).html('<b>'+matnNum.Va+'</b>');
						}
						if(matnNum.Vb>230 || matnNum.Vb<220){
							var v=$("#table tbody tr").eq(i).find("td").eq(2).html('<span style="color:red;"><b>'+matnNum.Vb+'</b></span>');
						}else{
							var v=$("#table tbody tr").eq(i).find("td").eq(2).html('<b>'+matnNum.Vb+'</b>');	
						}
						if(matnNum.Vc>230 || matnNum.Vc<220){
							var v=$("#table tbody tr").eq(i).find("td").eq(3).html('<span style="color:red;"><b>'+matnNum.Vc+'</b></span>');
						}else{
							var v=$("#table tbody tr").eq(i).find("td").eq(3).html('<b>'+matnNum.Vc+'</b>');	
						}
						if(matnNum.Vab>230 || matnNum.Vab<220){
							var v=$("#table tbody tr").eq(i).find("td").eq(4).html('<span style="color:red;"><b>'+matnNum.Vab+'</b></span>');
						}else{
							var v=$("#table tbody tr").eq(i).find("td").eq(4).html('<b>'+matnNum.Vab+'</b>');	
						}
						if(matnNum.Vbc>230 || matnNum.Vbc<220){
							var v=$("#table tbody tr").eq(i).find("td").eq(5).html('<span style="color:red;"><b>'+matnNum.Vbc+'</b></span>');
						}else{
							var v=$("#table tbody tr").eq(i).find("td").eq(5).html('<b>'+matnNum.Vbc+'</b>');	
						}
						if(matnNum.Vca>230 || matnNum.Vca<220){
							var v=$("#table tbody tr").eq(i).find("td").eq(6).html('<span style="color:red;"><b>'+matnNum.Vca+'</b></span>');
						}else{
							var v=$("#table tbody tr").eq(i).find("td").eq(6).html('<b>'+matnNum.Vca+'</b>');	
						}
					
					}
					
				},
				error:function(){
					alert('请求数据失败啦,请刷新页面重新查询!');
				},
			});
		}
		
		
		
	</script>
	<body>
	<center>
		<div class="log">
			<table class="table table-hover " id="table">
				<thead>
					<tr>
						<th>线路名称</th>
						<th>Va</th>
						<th>Vb</th>
						<th>Vc</th>
						<th>Vab</th>
						<th>Vbc</th>
						<th>Vca</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data as $k=>$v)
					<tr>
						<td>{{$v->MeterName}}</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>
							<a value="{{$single}}_{{$v->MeterID}}_{{$v->MeterTypeID}}_{{$v->MeterIP}}" 
								href="{{url('redis')}}/{{$single}}_{{$v->MeterID}}_{{$v->MeterTypeID}}_{{$v->MeterIP}}">
								<input style='width:60px;' onclick="check()" id='sel' type='button' value="详细" class='btn btn-info btn-sm' />
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</center>
		<center>{{ $data->links() }}</center>
	</body>
</html>

@endsection