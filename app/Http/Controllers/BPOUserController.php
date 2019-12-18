<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class BPOUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('permission:data_set_list|customer_detail');
    }
    
    public function getDetail(){
        return view('bpo_user.cutomer_detail');
    }
    
    public function updateDetails(Request $request){
        $requestData = $request->all();
        $prev_arr = $arr = array();
//        echo "<pre>";print_r($requestData);exit;
//        $requestData['data'] = date('Y-m-d');
        $requestData['assign_bpo_user_id'] = Auth::user()->id;
        $requestData['bop_status_update_date'] = date('Y-m-d');
        $cust_detail = \App\BPODetail::where(['id'=>$requestData['id']])->first();
        $arr['status'] = $cust_detail->bop_user_status;
        $arr['bop_user_remark'] = $cust_detail->bop_user_remark;
        $arr['assign_bpo_user_id'] = $cust_detail->assign_bpo_user_id;
//        echo "<pre>";print_r($arr);exit;
        if($cust_detail->prev_bpo_user_detail != "" && ($cust_detail->bop_user_status != ""  || $cust_detail->bop_user_remark != "")){
            $prev_arr = json_decode($cust_detail->prev_bpo_user_detail,true);
            array_push($prev_arr,$arr);
            $requestData['prev_bpo_user_detail'] = json_encode($prev_arr);
        }else{
            array_push($prev_arr,$arr);
            $requestData['prev_bpo_user_detail'] = json_encode($prev_arr);
        }
        
        if($requestData['bop_user_status'] != "Callback"){
            $requestData['show_branch_admin'] = 1;
        }
//        echo "<pre>";
//        print_r($requestData);
//        exit;
//        else{
//          //  echo "2";
//            $prev_arr = $arr;
//        }
//        exit;
        
        $cust_detail->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('customer_detail');
//        echo "<pre>";print_r($requestData);exit;
    }
    
}