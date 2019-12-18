<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class BranchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:branch_list|branch_add|branch_edit|branch_delete');
        $this->middleware('permission:branch_add', ['only' => ['create','store']]);
        $this->middleware('permission:branch_edit', ['only' => ['edit','update']]);
        $this->middleware('permission:branch_delete', ['only' => ['destroy']]);
    }
    
     
    public function listBranch(){
        $branch = \DB::table("tbl_branch")
                    ->select("tbl_branch.*",'users.name',\DB::raw("GROUP_CONCAT(tbl_location.loc_name) as location"))
                    ->leftjoin("tbl_location",\DB::raw("FIND_IN_SET(tbl_location.loc_id,tbl_branch.loc_id)"),">",\DB::raw("'0'"))
                    ->leftjoin('users','users.id','=','tbl_branch.brand_head_id')
                    ->groupBy("tbl_branch.branch_id")
                    ->where(['tbl_branch.is_active'=>0])
                    ->get();
//                  echo "<pre>";print_r($data);exit;
        return view('branch.branch',['branch'=>$branch]);
    }
  
    public function addBranch(){
        $location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0])->get();
        $users = \App\User::select('id','name')->whereHas('roles', function($q){
                    $q->where('role_id', '6');
                 })->get();
//        echo "<pre>";print_r($users);exit;
        return view('branch.add_branch',['location'=>$location,'users'=>$users]);
    }
    
    public function saveBranch(Request $request){
        $requestData = $request->all();
        $last_branch = \App\Branch::select('branch_code')->orderBy('branch_id','DESC')->first();
        if(!empty($last_branch)){
        if($last_branch->branch_code != ""){
            $bid = $last_branch->branch_code;
            $bid++;
            $requestData['branch_code'] = $bid;
        }}else{
            $requestData['branch_code'] = 'B-001';
        }
//        echo "<pre>";print_r($requestData);exit;
        $requestData['user_id'] = Auth::user()->id;
        if(isset($requestData['loc_id'])){
            $requestData['loc_id'] = implode(",",$requestData['loc_id']);
        }
        \App\Branch::create($requestData);
        Session::flash('alert-success', 'Added Successfully.');
        return redirect('branch_list');
    }
   
    public function editBranch(){
        $id = $_GET['id'];
        $location = \App\Location::select('loc_id','loc_name')->where(['is_active'=>0])->get();
        $users = \App\User::select('id','name')->whereHas('roles', function($q){
                    $q->where('role_id', '6');
                 })->get();
        $branch = \App\Branch::where(['branch_id'=>$id])->first();
        return view('branch.edit_branch',['branch'=>$branch,'location'=>$location,'users'=>$users]);
    }
    
    public function updateBranch(Request $request){
        $requestData = $request->all();
//        echo "<pre>";print_r($requestData);exit;
        $id = $requestData['branch_id'];
        $location = \App\Branch::where(['branch_id'=>$id])->first();
         if(isset($requestData['loc_id'])){
            $requestData['loc_id'] = implode(",",$requestData['loc_id']);
        }
        $location->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('branch_list');
    }
    
    public function deleteBranch($id){
        $query= \App\Branch::where('branch_id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('branch_list');
    }
    
}