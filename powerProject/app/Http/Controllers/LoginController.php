<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\tuser;
use App\user_station;
use App\role_stationpower;
use App\tstation;
use App\tstationpower;
use App\user_role;
use Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\libs\PageTool;

class LoginController extends Controller{
      //加载登录模板
      public function login(){
  		  if(session()->has("Uname")){
  		  	  session()->pull("Uname");
  			  return redirect("/");

  		  }else{
  		     return view('login/login');
  		  }
      }


      //执行登录的方法
      public function dologin(Request $request){
           $user=DB::table('tuser')->where('UName','=',$request->input('UserName'))->first();
			
			if($user == null){
			          session()->put('error',"账号或密码错误");
                return redirect('/login');
           }else{
                $password = $user->Password;
                if($request->input('UserPwd') == $password){ 
				
					session()->put('Uname',$request->input('UserName'));
					$admin = session()->get('Uname');
					$string = '用户:' . $admin . ',登录成功';
					$addlog = new PageTool();
					$add = $addlog->addLog($admin, $string);
					return view("web.index"); 
                }else{     
            		session()->put('pwdErroe',"密码错误");
            		return redirect('/login');
                }

           }
         
      }
	  
	/**退出登录操作**/ 
	public function outlogin(Request $request){
		
		$admin = session()->get('Uname');
		$string = '用户:' . $admin . ',退出成功';
		$addlog = new PageTool();
		$name = $request->session()->pull('Uname');
		if($name){
			$add = $addlog->addLog($admin, $string);
			return redirect('/login');
		}else{
			echo '退出失败请刷新浏览器';
		}
	 }





	  

}

