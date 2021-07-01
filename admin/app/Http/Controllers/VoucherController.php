<?php

namespace App\Http\Controllers;

use App\Voucher;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DB;
class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$vouchers = Voucher::where(['is_deleted'=>0])->orderBy('id','desc')->get();
		return view('voucher.index',compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view('voucher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// echo "<pre>";
		// print_r($_POST);
		// exit;
        //
		 $validator = Validator::make($request->all(),[
            'name' => 'required',
            'amount' => 'required',
            'validity' => 'required',
            
        ]);
		
        if($validator->fails())
        {
            return back()
            ->withInput()
            ->withErrors($validator);
        }
		$voucher = new Voucher;
		$voucher->user_id = Auth::user()->id;
		$voucher->name = ucwords($request->name) ?? "";
		$voucher->amount = $request->amount ?? 0;
		$voucher->validity = $request->validity ?? 0;
		if($voucher->save())
		{
			return redirect('voucher')->with('message','Voucher Added Successfully');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        //
		 if($voucher->status==1)
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
                    <td width="70%">'.$voucher->name.'</td>  
				</tr>
				<tr>  
                    <td width="30%"><label>Amount</label></td>  
                    <td width="70%">$'.$voucher->amount.'</td>  
				</tr>
			   <tr>  
                    <td width="30%"><label>Validity</label></td>  
                    <td width="70%">'.$voucher->validity.' Day</td>  
				</tr>
			 
			   <tr>  
                    <td width="30%"><label>Created Date</label></td>  
                    <td width="70%">'.date("d-M-Y",strtotime($voucher->created_at)).'</td>  
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
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher $voucher)
    {
        //
		return view('voucher.edit',compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        //
		 $validator = Validator::make($request->all(),[
            'name' => 'required',
            'amount' => 'required',
            'validity' => 'required',
            
        ]);
		
        if($validator->fails())
        {
            return back()
            ->withInput()
            ->withErrors($validator);
        }
		
		$voucher->name = ucwords($request->name) ?? "";
		$voucher->amount = $request->amount ?? 0;
		$voucher->validity = $request->validity ?? 0;
		if($voucher->save())
		{
			return redirect('voucher')->with('message','Voucher Updated Successfully');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        //
		$voucher->is_deleted = 1;
		if($voucher->save())
		{
			return back()->with('message','Voucher Deleted Successfully');
		}
    }
}
