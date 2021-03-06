<?php

namespace App\Http\ViewComposers;

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
use Illuminate\Contracts\View\View;
use Illuminate\Users\Repository as UserRepository;

class adminComposer
{
    /**
     * 用户仓库实现.
     *
     * @var UserRepository
     */
    protected $stationPower=null;
    protected $stationDate=null;

    /**
     * 创建一个新的属性composer.
     *
     * @param UserRepository $users
     * @return void
     */
    public function __construct(Request $request)
    {
					/*
					**根据用户UID查询角色权限及用户关联变电站
					*/
					//查询用户角色权限信息	
		
					$name = session()->get('Uname');
					$roleData = tuser::select('Rid')
								->leftJoin('user_role','tuser.UID','=','user_role.UID')
								->where('tuser.UName',"=",$name)
								->get()
								->toArray();
					$role_stationPower = role_stationpower::select('Pid')
										->where('Rid','=',$roleData[0]['Rid'])
										->get()
										->toArray();
					if(stripos($role_stationPower[0]['Pid'],',') ==false){
						$Power = tstationpower::select('Pid','PName')
									->where('Pid',"=",$role_stationPower[0]['Pid'])
									->get();
					}else{
						$PidArr = explode(',',$role_stationPower[0]['Pid']);
						$Power = tstationpower::select("Pid","PName")
													->whereIn('Pid',$PidArr)
													->get();
					}
					
					
					
					/*查询用户关联变电站信息*/
					$station =tuser::select('StationId')
					->leftJoin('user_station','tuser.UID',"=",'user_station.UID')
					->where('tuser.UName',"=",$name)
					->get()
					->toarray();
					foreach($station as $val){
						$id= $val;
					}
					if(stripos($id['StationId'],',') == false){
						$stationDate = tstation::select('StationId','StationName','StationSingle')
										->where('StationId','=',$id['StationId'])
										->get();
					}else{
						$idArray = explode(',',$id['StationId']);
						$stationDate = tstation::select('StationId','StationName','StationSingle')
							->whereIn('StationId',$idArray)
							->get();
					}
		$this->stationPower=$Power;
		$this->stationDate=$stationDate;
		
        // $this->users = $users;
    }

    /**
     * 绑定数据到视图.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
			'stationPower'=>$this->stationPower,
			'stationDate' =>$this->stationDate
		
		]);
    }
}





















