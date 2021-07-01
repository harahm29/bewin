<?php

namespace App\Http\Controllers;

use App\Code;
use App\User;
use Illuminate\Http\Request;
use App\Voucher;
use App\Commission;
use App\Lottery;
use App\Order;
use App\Transaction;
use App\AddLotteryTicket;
use Auth;
use Validator;
use DB;
use Session;


class CodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
	public function index(Request $request)
    {
        //
		if($request->status)
		{
			$status = $request->status;
			$codes = Code::where(['user_id'=>Auth::user()->id,'is_deleted'=>0,'status'=>$request->status])->orderBy('id','desc')->paginate(10);
		}
		else
		{
			$status = "";
			$codes = Code::where(['user_id'=>Auth::user()->id,'is_deleted'=>0])->orderBy('id','desc')->paginate(10);
		}
		return view("code.index",compact('codes','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function show(Code $code)
    {
        //
		$id = $code->id;
		$code = DB::table("codes")->select("codes.*",DB::raw("vs.name as voucher_name"))
					->leftjoin("vouchers as vs",function($join){
						$join->on("vs.id","=","codes.voucher_id");
					})
					->where(['codes.is_deleted'=>0,'codes.id'=>$id])
					->first();
					
					// echo "<pre>";
					// print_r($codes);
					// exit;
						if($code->status==1)
							$order_stats_txt_new = "<span style='float:left;padding:1px 9px;font-size:16px;'  class='text-success'><i class='fa fa-check' aria-hidden='true'></i> Active</span>";
						elseif($code->status==0) 
							$order_stats_txt_new = "<span style='float:left;padding:1px 9px;font-size:16px;' class='text-warning'><i class='fa fa-clock-o' aria-hidden='true'></i> Pending</span>";
						elseif($code->status==2)
							$order_stats_txt_new = '<span style="float:left;padding:1px 13px;font-size:16px;" class="text-primary"><i class="fa fa-check" aria-hidden="true"></i> Used</span>';
						elseif($code->status==3)
							$order_stats_txt_new = '<span style="float:left;padding:1px 9px;font-size:16px;" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Expired</span>'; 
		
      $output='';
      $output.= '  
      <div style="overflow-y: height:300px;" class="table-responsive">  
          <table align="center" border="0" class="table" width="100%"> '; 
        
        
      $output .= '  
				<tr>  
                    <td width="30%"><label>Plan</label></td>  
                    <td width="70%">'.$code->voucher_name.'</td>  
				</tr>
				<tr>  
                    <td width="30%"><label>Code</label></td>  
                    <td width="70%">'.($code->code).'</td>  
				</tr>
			   <tr>  
                    <td width="30%"><label>Value</label></td>  
                    <td width="70%">$'.$code->value.'</td>  
				</tr>
			 
			   <tr>  
                    <td width="30%"><label>Date of Creation</label></td>  
                    <td width="70%">'.date("d-M-Y",strtotime($code->today_date)).'</td>  
               </tr>
			   <tr>  
                    <td width="30%"><label>Date of Expire</label></td>  
                    <td width="70%">'.date("d-M-Y",strtotime($code->expire_date)).'</td>  
               </tr>
			    <tr>  
                    <td width="30%"><label>Status</label></td>  
                    <td width="70%">'.$order_stats_txt_new.'</td>  
               </tr>
         ';
  
       
       
     $output .= "</table></div>";  
     echo $output; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function edit(Code $code)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Code $code)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Code $code)
    {
        //
		
    }
	
	
////////////////////////////////////////////////////
}
