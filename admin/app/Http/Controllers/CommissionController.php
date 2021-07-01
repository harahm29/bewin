<?php

namespace App\Http\Controllers;

use App\Commission;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DB;
class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$commissions = Commission::where(['is_deleted'=>0])->orderBy('id','desc')->get();
		return view('commission.index',compact('commissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view('commission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		 $validator = Validator::make($request->all(),[
            'name' => 'required',
            'min_val' => 'required',
            'max_val' => 'required',
            'percentage' => 'required',
            
        ]);
		
        if($validator->fails())
        {
            return back()
            ->withInput()
            ->withErrors($validator);
        }
		$commission = new Commission;
		$commission->user_id = Auth::user()->id;
		$commission->name = $request->name ?? "";
		$commission->min_val = $request->min_val ?? 0;
		$commission->max_val = $request->max_val ?? 0;
		$commission->percentage = $request->percentage ?? 0;
		if($commission->save())
		{
			return redirect('commission')->with('message','Commission Added Successfully');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function show(Commission $commission)
    {
        //
		 if($commission->status==1)
			$status ='<p class="text-success" >Active</p>';
		else
			$status ='<p class="text-danger" >Inactive</p>';
		
      $output='';
      $output.= '  
      <div style="overflow-y: height:300px;" class="table-responsive">  
          <table align="center" border="0" class="table" width="100%"> '; 
        
        
      $output .= '  
				<tr>  
                    <td width="30%"><label>Name</label></td>  
                    <td width="70%">'.$commission->name.'</td>  
				</tr>
				<tr>  
                    <td width="30%"><label>Min Price</label></td>  
                    <td width="70%">$'.$commission->min_val.'</td>  
				</tr>
			   <tr>  
                    <td width="30%"><label>Max Price</label></td>  
                    <td width="70%">$'.$commission->max_val.'</td>  
				</tr>
			   <tr>  
                    <td width="30%"><label>Percentage</label></td>  
                    <td width="70%">'.$commission->percentage.'%</td>  
				</tr>
			   <tr>  
                    <td width="30%"><label>Created Date</label></td>  
                    <td width="70%">'.date("d-M-Y",strtotime($commission->created_at)).'</td>  
               </tr>
			    <tr>  
                    <td width="30%"><label>Status</label></td>  
                    <td width="70%">'.$status.'</td>  
               </tr>
         ';
  
       
       
     $output .= "</table></div>";  
     echo $output;     
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit(Commission $commission)
    {
        //
		return view('commission.edit',compact('commission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commission $commission)
    {
        //
		$validator = Validator::make($request->all(),[
            'name' => 'required',
            'min_val' => 'required',
            'max_val' => 'required',
            'percentage' => 'required',
            
        ]);
		
        if($validator->fails())
        {
            return back()
            ->withInput()
            ->withErrors($validator);
        }
		
		$commission->name = $request->name ?? "";
		$commission->min_val = $request->min_val ?? 0;
		$commission->max_val = $request->max_val ?? 0;
		$commission->percentage = $request->percentage ?? 0;
		if($commission->save())
		{
			return redirect('commission')->with('message','Commission Updated Successfully');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        //
		$commission->is_deleted = 1;
		if($commission->save())
		{
			return back()->with('message','Commission Deleted Successfully');
		}
    }
}
