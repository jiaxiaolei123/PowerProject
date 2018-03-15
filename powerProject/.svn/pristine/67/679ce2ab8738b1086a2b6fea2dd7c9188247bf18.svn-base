<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\tuser;
use App\user_station;
use App\role_stationpower;
use App\tstation;
use App\tstationpower;
use App\user_role;
use App\tuserlog;
use Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class LogController extends Controller{
	
	public function powerlog(){
		$Uname = session()->get('Uname');
		$Uid = tuser::select('UID')->where('UName',"=",$Uname)->first();
		$Rid = user_role::select('Rid')->where('UID',"=",$Uid['UID'])->first()->toArray();
		if($Rid['Rid'] !=2){
			return redirect('/');
		}else{
			$logData = tuserlog::select('Rectime','Operation','AdminName')->orderBy('Rectime', 'desc')->paginate(10);
			// dd($logData);
			return view('web.blade.log',['Log'=>$logData]);
		}
		
	}
	
}
   