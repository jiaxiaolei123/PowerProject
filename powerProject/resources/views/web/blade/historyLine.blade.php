@extends('web.index')
@section('content')
<!DCOTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" name="_token" content="{{ csrf_token() }}"  />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
		<title>历史曲线</title>
	</head>
	<style>
		select option{
			line-height:60px;
			height:25px;
		}
		div .table{
			border-bottom:2px solid #e3e3e3;
		}
		.table_Param{
			margin:auto;
		}
		.table_Param td{
			border-bottom:1px solid #d5d5d5;
			line-height:30px;
		}
		div .chart{
			height:700px;
		}
		
		.errMsg{
			color:#484891;
			font-size:2em;
			font-family: Monospace;
		}
	</style>

<script type="text/javascript" src="{{asset('echarts/echarts.js')}}"></script>
<script>
$(function(){
	
	getParam();
	date_fuzhi();
})
//获取回路仪表的参数
function getParam(){
	var MeterTypeID = $("#huilu option:selected").val().split("_")[1];
		$.ajax({
				url:"getParams", //提交给当前控制器的方法
				type:'post',
				async: true, //异步执行
				data:{MeterTypeID:MeterTypeID},
				dataType:'json',
				headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content'),charset:'gb2312'},
				success:function(result){
					var msg = '';
					var num = Math.ceil((result.length)/3);
					msg +="<table id=\"tableparam\" class=\"table_Param\">";
					for(var j=0;j<num;j++){
						
						msg+="<tr>";
							for(var td=0; td<3 ; td++){
								
								msg+="<td></td>";
							}
						msg+="</tr>";
					}
					msg+="</table>";
					$("#box").html(msg);
					var td=$("#tableparam").find("td");
					var txt='';	
					for(var i = 0 ; i < result.length ; i++)
					{
						txt="<label class=\"checkbox-inline\"><input type=\"radio\" name=\"radios\"  value="+result[i].paramsName+"_"+result[i].Unit+"_"+result[i].isSingle+"_"+result[i].showName+" />"+result[i].showName+"</label>";
						td.eq(i).html(txt);
					}
				},
				error:function(){
					alert("获取回路仪表参数失败");
				}
			
		});
}
	//日期显示当前时间
function date_fuzhi(){
		//定义一个时间
		var date = new Date();

        //年月日连接符 
		var seperator1 = "-"; 

        //时分秒连接符
		var seperator2 = ":";

		//获取月份
		var month = date.getMonth() + 1;

		//获取日期
		var strDate = date.getDate();

		 
		var strDate_1 = date.getDate()-1;


		//当月份大于一小于九的时候 前面连接一个零
		if (month >= 1 && month <= 9) {
			month = "0" + month;
		}

		//当日期大于一小于九的时候 前面也要连接一个零
		if (strDate >= 0 && strDate <= 9) {
			strDate = "0" + strDate;
		}

        //获取当前时间
		var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
				+ " " + date.getHours() + seperator2 + date.getMinutes()
				+ seperator2 + date.getSeconds();
        
        //获取当前时间-1  的时间
		var startDate = date.getFullYear() + seperator1 + month + seperator1 + strDate_1
				+ " " + date.getHours() + seperator2 + date.getMinutes()
				+ seperator2 + date.getSeconds();
				
		$("#txt_endTime").val(currentdate);
		$("#txt_startTime").val(startDate);
	}
//点击提交按钮获取数据
function ajaxhistoryLine(){
		var myChart = echarts.init(document.getElementById('myChartDom'));
        myChart.showLoading();
		var option = { 
			
				//标题
				title: {
					text: $("#single").text()+'号变电站--'+$("#huilu option:selected").text(),
					left: '20px',
				},
				
				//工具组件
				toolbox:{
					show:true,
					showTitle:true,
					left:'20%',
					feature:{
						
						//保存为图片
						saveAsImage:{type: 'png',show:true,title: '保存为图片',},
						//还原
						restore:{show:true},
						dataView:{show:true},
						dataZoom:{show:true},
						magicType:{show:true,type:['line','bar']}
						
					}
				},

				tooltip: {trigger: 'axis'},
				//图例组件
				legend: {left: '40%',data: []},
					
				dataZoom: [{
				}, {
					type: 'inside'
				}],
				
				//横坐标
				xAxis: [
					{
						type: 'category',
						name: '时间',
						splitLine: {show: false},
						data:[]
					}
				],
			yAxis:[
				{
					type: 'value',
					name: '单位('+$("#tableparam input[name='radios']:checked").val().split("_")[1]+')',
					scale:true,
				}
			],
				//直角坐标系绘图网格
				grid: {show:false,left: '5%',right: '4%',bottom: '5%',containLabel: true},
				//y轴

				series: [],
			};

		    myChart.showLoading();
			window.onresize = myChart.resize;
			// myChart.setOption(option);
			myChart.hideLoading();	
	
		var param = $("input[name='radios']:checked").val();
		var Single = $("#single").text();
		$.ajax({
			url:'ajaxhistoryLine',
			type:'POST',
			async:true,
			data:$('#form').serialize()+'&stationSingle='+Single,
			dataType:'json',
			headers:{'X-CSRF-TOKEN':$('mete[name="_token"]').attr('content'),charset:'gb2312'},
			success:function(result){
				if(result.xAix.length ==0){
					var Msg = '<center><span class="errMsg">您查询此时间段无数据!请选择正确的查询时间段</span></center>';
					$("#myChartDom").html(Msg);
				}else{
					option.xAxis[0].data=result.xAix.map(function (str) {
						return str.replace(' ', '\n')
					});

					option.legend.data = result.legend;
					option.series = result.series;
					myChart.setOption(option);
				}
			},
			error:function(){
				alert("获取查询数据失败,请重新查询");
			}
		})
}	
	
//检测是否符合查询条件
function check(){
	var startTime = $("#txt_startTime").val();
		var endTime = $("#txt_endTime").val();
		var start = new Date(startTime.replace("-", "/").replace("-", "/"));
		var end = new Date(endTime.replace("-", "/").replace("-", "/"));
		var choice=$('#box input:radio[name="radios"]:checked').val();
			if(!choice){
				alert("请选择查询条件");
			}else{
				if(start>end){
					alert("请选择正确的时间范围");
				}else{
					ajaxhistoryLine();
				}
			}
}	
</script>
	<body>
		<form role="form" class="form-inline" id="form" action="#" method="POST">
			{{csrf_field()}}
			<div class='table-responsive tab-pane fade in active'>
				<table class='table' id='table'>
					<tr>
						<td>
							<label>变电站标识&nbsp;:&nbsp;</label>
							<span style="color:black" id="single">{{$stationSingle}}</span>
						</td>
						<td>
							<label for="huilu">监测回路&nbsp;:&nbsp;</label>
							<select name="select_one" id="huilu" onchange="getParam()" >
								@foreach($meterData as $k)
								<option value="{{$k->MeterID}}_{{$k->MeterTypeID}}">{{$k->MeterName}}</option>
								@endforeach
							</select>
						</td>
						<td>
							<label for='txt_startTime'>开始时间&nbsp;:&nbsp;</label>
							<input class="form-control" name="startTime" type="text" value="" id="txt_startTime"
							   onfocus="new WdatePicker({maxDate:'%y-%M-%d'})" style="width:170px; height:30px;" />
						</td>
						<td>
							<label for='txt_endTime'>结束时间&nbsp;:&nbsp;</label>
							<input class="form-control" name="endTime" type="text" value="" id="txt_endTime"
							   onfocus="new WdatePicker({maxDate:'%y-%M-%d'})" style="width:170px; height:30px;" />
						</td>
					</tr>
					<tr>
						<td>
							<label class="radio-inline">
								<input type="radio" name="optionRadios" id="max" value="max" checked>最大值
							</label>
							<label class="radio-inline">
								<input type="radio" name="optionRadios" id="min" value="min" >最小值
							</label>
							<label class="radio-inline">
								<input type="radio" name="optionRadios" id="avg" value="avg" >平均值
							</label>
						</td>
						<td>
							<input style='margin-left:15px;' type='button' value='条件选择' class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" />
							
						</td>
						<td colspan="2">
							<input style='margin-left:15px; width: 60px;' onclick="check()" id='sel' type='button' value='查询' class='btn btn-success btn-sm' />
						</td>
					</tr>
				</table>
				<!-- 模态框（Modal） -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title" id="myModalLabel">
									请选择条件
								</h4>
							</div>
							<div class="modal-body" id="box">
							
							
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">关闭
								</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal -->
				</div>
			</div>
			<div class="chart" id="myChartDom">
			</div>
		</form>
		
	</body>
</html>

@endsection