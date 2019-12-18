<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class DSEController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('permission:get_dse_data');
//         $this->middleware('permission:update_dse_data');
    }
    
    public function getDSEdata(){
        return view('dse_user.cutomer_detail');
    }
    
    public function updateDetails(Request $request){
        $requestData = $request->all();
        $prev_arr = $arr = array();
//        echo "<pre>";print_r($requestData);exit;
//        $requestData['data'] = date('Y-m-d');
        $requestData['assign_telle_caller_id'] = Auth::user()->id;
        $requestData['tellecaller_status_update_date'] = date('Y-m-d');
        $cust_detail = \App\BPODetail::where(['id'=>$requestData['id']])->first();
        $arr['status'] = $cust_detail->telle_caller_status;
        $arr['bop_user_remark'] = $cust_detail->telle_caller_remark;
        $arr['assign_bpo_user_id'] = $cust_detail->assign_telle_caller_id;
//        echo "<pre>";print_r($arr);exit;
        if($cust_detail->prev_telle_caller_user_detail != "" && ($cust_detail->telle_caller_status != ""  || $cust_detail->telle_caller_remark != "")){
            $prev_arr = json_decode($cust_detail->prev_telle_caller_user_detail,true);
            array_push($prev_arr,$arr);
            $requestData['prev_telle_caller_user_detail'] = json_encode($prev_arr);
        }else{
            array_push($prev_arr,$arr);
            $requestData['prev_telle_caller_user_detail'] = json_encode($prev_arr);
        }
        
//        if($requestData['bop_user_status'] != "Callback"){
//            $requestData['show_branch_admin'] = 1;
//        }
//        echo "<pre>";
//        print_r($requestData);
//        exit;
//        else{
//          //  echo "2";
//            $prev_arr = $arr;
//        }
//        exit;
//        echo "<pre>";print_r($requestData);exit;
        $cust_detail->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('get_dse_data');
//        echo "<pre>";print_r($requestData);exit;
    }
    
}