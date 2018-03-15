<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests;
use App\meterinfo;
use App\metertype;
use App\params;
use App\tuser;
use App\trole;
use App\user_role;
use App\user_station;
use App\tstation;
use App\role_stationpower;
use App\tstationpower;
use App\libs\PageTool;

class CommonController extends Controller{
	
	
	/*根据路由参数重定向分配视图以及控制器*/
	public function common(Request $request,$Pid,$stationId){
		
		switch($Pid)
		{
			case 1:
			//执行程序
			break;
			case 2:
			
			break;
			case 3:
			
			break;
			case 4:
			
			break;
			case 5:
				return redirect('historyLine/'.$stationId);
			break;
			case 6:
			
			break;
			case 7:
				return redirect('powerredis/'.$stationId);
			break;
			case 8:
			
			break;
		}
		
	
	}
	
	/*历史曲线视图*/
	public function historyLine(Request $request,$stationId){
		$arr = explode('_',$stationId);
		$stationid = $arr[0];
		$stationSingle = $arr[1];
		$data = meterinfo::select('MeterID','MeterTypeID','MeterName')->where('StationID',"=",$stationid)->get();
		return view('web.blade.historyLine',
					[
						'stationSingle'=>$stationSingle,
						  'meterData'=>$data
					]);
		
		
	}
	/*历史曲线参数获取*/
	public function getParams(Request $request){
		$meterTypeId = $request->input()['MeterTypeID'];
		$data = metertype::select("MeterTypeName","paramsId")->where("MeterTypeID","=",$meterTypeId)->get()->toArray();
		foreach($data as $k=>$val){
			$names['MeterTypeName']=$val['MeterTypeName'];
			$Ids['paramsId'] = $val['paramsId'];
		}
		$idArr = explode(",",$Ids['paramsId']);
		$paramsName = params::select("paramsName","showName","Unit","isSingle")->whereIn('paramsId',$idArr)->where('real_show',"=",1)->get()->toJson();
		echo $paramsName;
	}
	/*历史曲线数据查询*/
	public function ajaxhistoryLine(Request $request){
		$data = $request->input();
		$stationSingle 	= $data['stationSingle'];	/*变电站标识*/
		$meterdata 		= $data['select_one'];		/*meterID 与 meterTypeID*/
		$startTime		= $data['startTime'];		/*开始时间*/
		$endTime 		= $data['endTime'];			/*结束时间*/
		$optionRadios 	= $data['optionRadios'];	/*最大,最小,平均值*/
		$radios 		= $data['radios'];			/*paramsName , Uint , isSingle , showName*/
		$paramName 		= explode("_",$radios)[0];
		$isSingle		= explode("_",$radios)[2];
		$showName		= explode("_",$radios)[3];
		$meterId 		= explode("_",$meterdata)[0];
		$meterTypeId 	= explode("_",$meterdata)[1];
		
		$three = ['a','b','c'];
		$four = ['ab','bc','ca'];
		if($isSingle ==1){
			$param[] = $paramName;
			$showNames[]=$showName;
		}else if($isSingle ==3){
			foreach($three as $val){
				$param[] = $paramName.$val;
				$showNames[] = $showName."-".$val.'相';
			}
		}else if($isSingle ==4){
			foreach($four as $v){
				$param[] =$paramName.$v;
				$showNames[] = $showName.'-'.$v.'线';
			}
		}
		$meterTypeName 	= metertype::select("MeterTypeName")->where("MeterTypeID",'=',$meterTypeId)->first();
		$baseTable = "App\\"."pd_".$stationSingle."_";
		
		if((strtolower($paramName) =='kwh' || strtolower($paramName)=='kvarh' || strtolower($paramName)=='kvah') && $meterTypeId ==1){
			$baseTable .='powerdegree';
		}elseif((strtolower($paramName) =='pst' || strtolower($paramName)=='plt') && $meterTypeId ==1){
			
				$baseTable .="pstandplt";
		}else{
			if($meterTypeId ==1){
			
				$baseTable .="meterbase";
				
			}else{
				$baseTable .=$meterTypeName['MeterTypeName'];
			}
			
			if($optionRadios !='avg'){
				$baseTable .=$optionRadios;
			}
		}
		
		/*查询数据*/
		$selData = $baseTable::select($param)->where('MeterID','=',$meterId)->whereBetween("RecTime",[$startTime,$endTime])->get()->toArray();
		/*查询时间*/
		$selTime = $baseTable::select('RecTime')->where('MeterID','=',$meterId)->whereBetween("RecTime",[$startTime,$endTime])->get()->toArray();
		$xAix = array_column($selTime,'RecTime');
		for($i=0 ; $i<count($param) ; $i++){
			
			$dataResult[$i]=array_column($selData,$param[$i]);
		}
		// dd($dataResult);
		for($i=0 ; $i<count($showNames) ; $i++){
			$series[$i]['name'] = $showNames[$i];
			$series[$i]['type'] = 'line';
			$series[$i]['data'] = $dataResult[$i];
		}
		$arr=[];
		$arr['xAix']   = $xAix;
		$arr['series'] = $series;
		$arr['legend'] = $showNames;
		$result=json_encode($arr);
		/*插入日志*/
		$admin = session()->get('Uname');
		$string = '用户:' . $admin . ',查询历史曲线';
		$addlog = new PageTool();
		$add = $addlog->addLog($admin, $string);
		echo $result;
	}
	
	/*人员管理*/
	public function powermanager(){
		
		$userData = tuser::select("tuser.UID","UName","Password","RealName","Telephone","Email","Rid")
					->leftJoin('user_role', 'tuser.UID', '=', 'user_role.UID')
					->get();
		$roleData = trole::select("Rid","RName")->get()->toArray();
		for($i=0 ; $i<count($userData) ; $i++){
			for($j=0 ;$j<count($roleData) ; $j++){
				if($userData[$i]['Rid'] == $roleData[$j]['Rid']){
					$userData[$i]['RName'] = $roleData[$j]['RName'];
				}
			}
		}
		return view('web.blade.powermanager',['userData'=>$userData]);
	}
	/*
	*编辑电站人员信息
	*@param UID
	*/
	function editormanager(Request $request,$UID){
		/*查询人员信息*/
		$userMsg = tuser::where('UID',"=",$UID)->get();
		/*查询角色信息*/
		$role = trole::get();
		$tstation = tstation::get();
		return view('web.blade.editormanager',[
			'userMsg'=>$userMsg,
			'role'	=>$role,
			'tstation'=>$tstation,
		]);
	}
	
	/*确认编辑人员信息*/
	function editorajax(Request $request){
		$admin = session()->get('Uname');
		$data = $request->input();
		$UID = $data['UID'];
		$uname = $data['uname'];
		$password = $data['password'];
		$realname = $data['realname'];
		$tel = $data['tel'];
		$email = $data['email'];
		$role = $data['role'];
		$stationArr = $data['station'];
		$stationstr = implode(",",$stationArr);
		
		$loginName = session()->get("Uname");
		$uid = tuser::select("UID")->where("Uname","=",$loginName)->first();
		$editorName = tuser::select("UName")->where("UID","=",$UID)->first();
		if($uid['UID'] ==$UID){
			session()->put('Uname',$uname);
			session()->get('Uname');
			
		}
		$result = tuser::where('UID',"=",$UID)
				->update([
				'UName' 	=> $uname,
				'Password' 	=>$password,
				'RealName' 	=> $realname,
				'Telephone' => $tel,
				'email' 	=>$email ,
				]);
			$roleresult = user_role::where("UID","=",$UID)
						->update([
							'Rid'=>$role,
						]);
			$stationult = user_station::where("UID","=",$UID)
						->update([
							'StationId'=>$stationstr,
						]);
						
			if($result =="1" || $roleresult =="1" || $stationult =="1"){
				/*插入日志*/
				$string = '用户:' . $admin . '编辑用户【'.$editorName['UName']."】成功";
				$addlog = new PageTool();
				$add = $addlog->addLog($admin, $string);
				session()->flash('ok',"成功!");
				echo "1";
			}else{
				session()->flash('no',"失败!");
				echo "0";
			}
		
	}
	
	/*
	 *删除变电站人员信息
	 *@param UID
	 */
	public function deletemanager(Request $request,$UID){
		
		$delName = tuser::select("UName")->where("UID","=",$UID)->first();
		$resulta = user_station::where("UID","=",$UID)->delete();
		$resultb = tuser::where("UID","=",$UID)->delete();
		$resultc = user_role::where("UID","=",$UID)->delete();
		if($resulta == 1 && $resultc ==1 &&$resultb ==1)
		{
			session()->flash('ok',"成功!");
			/*插入日志*/
				$admin = session()->get("Uname");
				$string = '用户:' . $admin . '删除用户【'.$delName['UName']."】成功";
				$addlog = new PageTool();
				$add = $addlog->addLog($admin, $string);
			return redirect("powermanager");
		}else{
				$admin = session()->get("Uname");
				$string = '用户:' . $admin . '删除用户【'.$delName['UName']."】失败";
				$addlog = new PageTool();
				$add = $addlog->addLog($admin, $string);
			session()->flash("no","失败!");
			return redirect('powermanager');
		}
		
		
	}

	
	/*
	*新增页面查询角色及变电站信息
	
	*/	
	function creatajax(Request $request){
		$role=trole::select("Rid","RName")->get()->toArray();
		$station = tstation::select("StationId","StationName","StationSingle")->get()->toArray();
		$resArr=['role'=>$role,"station"=>$station];
		$arr = json_encode($resArr);
		echo $arr;
	}	


	/*
	 *新增电站人员
	 @param Form
	*/
	function creatmanager(Request $request){
		$data = $request->input();
		$uname = $data['username'];
		$password = $data['password'];
		$realname = $data['realname'];
		$tel = $data['tel'];
		$email = $data['email'];
		$role = $data['role'];
		$station = $data['station'];  /* stationId_stationSingle*/
		$num = count($station);
		foreach($station as $k=>$val){
			$stationId[]=explode("_",$val)[0];
			$stationSingle[]=explode("_",$val)[1];
		}
		
		$checkname = tuser::where("UName","=",$uname)->first();
		if($checkname)
		{
			echo 2;
		}else{
			$idStr = implode(",",$stationId);
			$id = tuser::insertGetId(
				[
					'UName' => $uname,
					'Password' => $password,
					'RealName' => $realname,
					'Telephone' => $tel,
					'Email' => $email,
				],
				"UID"
			);
			// /*返回值 true or false*/
			$tuser_role = user_role::insert(
				[
					'UID'=>$id,
					'Rid'=>$role
				]
			);
			
			/*返回值 true  or  false*/
			$userStation = user_station::insert([
					'UID' => $id,
					'StationId'=>$idStr
			]);
			
			if($id && $tuser_role && $userStation){
				session()->flash('ok',"成功!");
				/*插入日志*/
				$admin = session()->get("Uname");
				$string = '用户:' . $admin . '新增用户【'.$uname."】成功";
				$addlog = new PageTool();
				$add = $addlog->addLog($admin, $string);
				echo 1;
			}else{
				session()->flash("no","失败!");
				$admin = session()->get("Uname");
				$string = '用户:' . $admin . '新增用户【'.$uname."】失败";
				$addlog = new PageTool();
				$add = $addlog->addLog($admin, $string);
				echo 0;
			}
		}
		
	}
	
	/*角色信息展示*/
	function rolemanager(Request $request){
		
		$roleArr = trole::get();
		$power = role_stationpower::get();
		for($i=0 ; $i<count($power) ; $i++)
		{
			$Pid[$i] = explode(",",$power[$i]['Pid']);
			$power[$i]['PName'] = tstationpower::whereIn("Pid",$Pid[$i])->get()->toArray(); 
			if($roleArr[$i]['Rid'] ==$power[$i]['Rid'])
			{
				$roleArr[$i]['PName'] = $power[$i]['PName'];
			}
		}
		
		// dd($roleArr);
		return view("web.blade.role",[
			'roleArr'=>$roleArr
		]);
	}
	
	function editorrole(Request $request,$Rid){
		$roleArr = trole::where('Rid',"=",$Rid)->get();
		$power=[1,2,3,4,5,6,7];
		$stationpower =tstationpower::whereIn("Pid",$power)->get();
		return view('web.blade.editorrole',[
			'roleArr'=>$roleArr,
			'stationpower'=>$stationpower
		]);
	}
	
	/*
	编辑角色信息
	param $request
	*/
	function ajaxrole(Request $request){
		$data = $request->input();
		$Rid = $data['Rid'];
		$rname = $data['rname'];
		$des = $data['des'];
		$rolePower = $data['rolePower'];
		
		/**
			$msg =0  无修改
			$msg =1  有修改成功
		**/
		$msg = trole::where("Rid","=",$Rid)->update([
			'RName'=>$rname,
			'description'=>$des,
		]);
		$powerstr  = implode(",",$rolePower);
		$result = role_stationpower::where("Rid","=",$Rid)->update([
			'Pid'=>$powerstr,
		]);
		
		if($result =="1" || $msg =="1"){
				/*插入日志*/
				$admin = session()->get('Uname');
				$string = '用户:' . $admin . '编辑角色【'.$rname.'】成功';
				$addlog = new PageTool();
				$add = $addlog->addLog($admin, $string);
				session()->flash('roleok',"成功!");
				echo "1";
			}else{
				session()->flash('roleno',"失败!");
				echo "0";
			}
	}
	
	/*
	*新增角色信息页面
	*/
	function creatrole(Request $request ){
		$powerstation = tstationpower::limit(7)->get();
		return view('web.blade.creatrole',[
		'power'=>$powerstation,
		]);
	}
	
	/*
	*新增角色信息提交处理方法
	@param form
	*/	
	function creatroleAjax(Request $request){
		$data = $request->input();
		$rolename = $data['rolename'];
		$roledes = $data['roledes'];
		$rolepower = $data['power'];
		
		$check = trole::where("RName","=",$rolename)->first();
		if($check){
			echo 2;
		}else{
			$powerstr = implode(",",$rolepower);
			$id = trole::insertGetId(['RName' => $rolename,'description' => $roledes],"Rid");
			
			// /*返回值 true or false*/
			$role_stationpower = role_stationpower::insert(
				[
					'Rid'=>$id,
					'Pid'=>$powerstr
				]
			);
			
			
			if($id && $role_stationpower){
				session()->flash('roleok',"成功!");
				/*插入日志*/
				$admin = session()->get("Uname");
				$string = '用户:' . $admin . '新增角色【'.$rolename."】成功";
				$addlog = new PageTool();
				$add = $addlog->addLog($admin, $string);
				echo 1;
			}else{
				session()->flash("roleok","失败!");
				$admin = session()->get("Uname");
				$string = '用户:' . $admin . '新增角色【'.$rolename."】失败";
				$addlog = new PageTool();
				$add = $addlog->addLog($admin, $string);
				echo 0;
			}
			
		}
		
	}
	
	function deleterole(Request $request,$Rid){
		
		
		$msg = user_role::where('Rid',"=",$Rid)->first();
		if($msg !=null){
			session()->flash("have","角色不能删除,已有用户使用此角色!!");
			return redirect("rolemanager");
			exit;
		}
		$rolename = trole::select("RName")->where("Rid","=",$Rid)->first()->toArray();
		$msg = trole::where("Rid","=",$Rid)->delete();
		$msgtwo = role_stationpower::where("Rid","=",$Rid)->delete();
		if($msg ==1 && $msgtwo==1){
			session()->flash("roleok","成功!");
			$admin = session()->get("Uname");
			$string = '用户:' . $admin . '删除角色【'.$rolename['RName']."】成功";
			$addlog = new PageTool();
			$add = $addlog->addLog($admin, $string);
			return redirect("rolemanager");
		}else{
			
			session()->flash("roleno","失败!");
			$admin = session()->get("Uname");
			$string = '用户:' . $admin . '删除角色【'.$rolename['RName']."】失败";
			$addlog = new PageTool();
			$add = $addlog->addLog($admin, $string);
			return redirect("rolemanager");
		}
		
	}
	
	/*实时数据*/
	function powerredis(Request $request ,$stationId){
		$arr= explode("_",$stationId);
		$stationId = $arr[0];
		$stationsingle= $arr[1];
		$data = meterinfo::select("StationID","MeterID","MeterTypeID","MeterName","MeterIP")
							->where("StationID","=",$stationId)
							->paginate(10);
		$admin = session()->get("Uname");
		$string = '用户:' . $admin . '查看实时数据';
		$addlog = new PageTool();
		$add = $addlog->addLog($admin, $string);
		return view('web.blade.redis',['data'=>$data,
										'single'=>$stationsingle
		]);
	}
	
	/*获取实时数据*/
	function getredis(Request $request){
	
		$arr 	= $request->input("param");
		$count 	= count($arr);
		for($i=0 ; $i<$count ; $i++){
			$starr[$i]=explode("_",$arr[$i]);
			$meter[$i]= metertype::select("MeterTypeName","paramsId")->where("MeterTypeID","=",$starr[$i][2])->first()->toArray();
			$meter[$i]["paramsId"] = explode(",",$meter[$i]['paramsId']);
			if($starr[$i][2] ==1){
				$key[$i] = $starr[$i][0]."_"."ION_Base"."_".$starr[$i][1];
			}else{
				$key[$i] = $starr[$i][0]."_".$meter[$i]['MeterTypeName']."_".$starr[$i][1];
			}
			
			$redis = Redis::connection("default");
			/*存入假的电压值*/
			$val=['Va'=>rand(210,240),'Vb'=>rand(210,240),'Vc'=>rand(210,240),'Vab'=>rand(210,240),'Vbc'=>rand(210,240),'Vca'=>rand(210,240),'P'=>rand(10,20)];
			$jval = json_encode($val);
			$redis->set($key[$i],$jval);
			$value[] = $redis->get($key[$i]);
			
			
			// $redis = Redis::connection($starr[$i][3]);
			// $value[]=$redis->get($key[$i]);
		}
		$result =json_encode($value);
		echo $result;
	}
	
	
	/*
		详细实时数据
		@param data
	*/
	function redis(request $request,$data){
		$msg = explode("_",$data);
		$single = $msg[0];
		$meterId = $msg[1];
		$meterTypeId = $msg[2];
		$meterIp = $msg[3];
		$meterName= meterinfo::select("MeterName")->where("MeterID","=",$meterId)->first()->toArray();
		
		
		return view("web.blade.redisinfo",['data'=>$data,'meterName'=>$meterName['MeterName']]);
		
	}
	
	function getredisdata(request $request){
		$json = $request->input('data');
		$jsonArr = explode("_",$json);
		$single = $jsonArr[0];
		$meterId = $jsonArr[1];
		$meterTypeId = $jsonArr[2];
		$meterIp = $jsonArr[3];
		$meterData= metertype::select("MeterTypeName")->where("MeterTypeID","=",$meterTypeId)->first()->toArray();
	
		$key = $single."_".$meterData['MeterTypeName']."_".$meterId;	
	
		// /*连接redis*/
		// /*假数据*/
		$val=[
				'Va'=>rand(210,240),'Vb'=>rand(210,240),'Vc'=>rand(210,240),'Vab'=>rand(210,240),'Vbc'=>rand(210,240),
				'Vca'=>rand(210,240),'P'=>rand(10,20),"Q"=>rand(10,20),'Va'=>rand(210,240),'Vs'=>rand(210,240),'Vss'=>rand(210,240),
				'Vav'=>rand(210,240),'Vaz'=>rand(210,240),'Vaq'=>rand(210,240),'Var'=>rand(210,240),'Vat'=>rand(210,240),'Vsss'=>rand(210,240),
				'Vabb'=>rand(210,240),'Van'=>rand(210,240),'Vam'=>rand(210,240),'Vak'=>rand(210,240),
			  ];
		$jval = json_encode($val);
		$redis = Redis::connection("default");
		$redis->set($key,$jval);
		$redisJSON = $redis->get($key);
		echo $redisJSON;
		
	}
}
   
   
   
   
    
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   