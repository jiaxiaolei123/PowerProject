<?php
namespace App\libs;
use DB;
use App\tuserlog;

class PageTool {
	public function addLog($admin,$string){
		//当前操作的时间
		 date_default_timezone_set('PRC');
		$date = date('Y-m-d H:i:s',time());
		
		if (isset($_SERVER)) {
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$realip = $_SERVER['HTTP_CLIENT_IP'];
			} else {
			$realip = $_SERVER['REMOTE_ADDR'];
			}
		} else {
			if (getenv("HTTP_X_FORWARDED_FOR")) {
			$realip = getenv( "HTTP_X_FORWARDED_FOR");
			} elseif (getenv("HTTP_CLIENT_IP")) {
			$realip = getenv("HTTP_CLIENT_IP");
			} else {
			$realip = getenv("REMOTE_ADDR");
			}
		}
		//当前电脑IP
		
		$insert = DB::table('tuserlog')->insert(
							[ 'RecTime'    =>$date,
							  'Operation'  =>$string,
							  'AdminName'  =>$admin,
							  'IPAddress'  =>$realip,
							]
						);
		if($insert){
			return true;
		}else{
			return false;
		}
		
	}
	
}