<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Session;

class LocationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
       // $this->middleware('auth');
        $this->middleware('permission:enq_location_list|enq_location_add|enq-location-edit|enq-location-delete');
        $this->middleware('permission:enq_location_add', ['only' => ['create','store']]);
        $this->middleware('permission:enq-location-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:enq-location-delete', ['only' => ['destroy']]);
    }
    
     
    public function listLocation(){
        $location = \App\Location::where(['is_active'=>0])->get();
        return view('enq_location.enq_location',['location'=>$location]);
    }
  
    public function addLocation(){
        return view('enq_location.add_location');
    }
    
    public function saveLocation(Request $request){
        $requestData = $request->all();
        $requestData['user_id'] = Auth::user()->id;
        
        \App\Location::create($requestData);
        Session::flash('alert-success', 'Added Successfully.');
        return redirect('enq_location_list');
    }
   
    public function editLocation(){
        $id = $_GET['id'];
        $location = \App\Location::where(['loc_id'=>$id])->first();
        return view('enq_location.edit_location',['location'=>$location]);
    }
    
    public function updateLocation(Request $request){
        $requestData = $request->all();
        $id = $requestData['loc_id'];
        $location = \App\Location::where(['loc_id'=>$id])->first();
        $location->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('enq_location_list');
    }
    
    public function deleteLocation($id){
        $query= \App\Location::where('loc_id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('enq_location_list');
    }
    
}