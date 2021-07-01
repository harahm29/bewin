<?php

namespace App\Http\Controllers;

use App\Withdraw;
use App\User;
use App\Transaction;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DB;


class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function withdraw_request()
    {
        //
		$withdraw_requests = Withdraw::where(['user_id'=>Auth::user()->id,'is_deleted'=>0])->orderBy('id','desc')->get();
		
		
		
		
		// print_r($diff_in_days); // Output: 1

		$output= '';
		$output.= '  
		<div  class="table-responsive">  
          <table align="center" class="table table-bordered">
		  <thead>
			<th>SrNo</th>
			<th>Amount</th>
			<th>Type</th>
			<th>Paypal Id</th>
			<th>Date</th>
			<th>Status</th>
		  </thead><tbody> 
		  ';  
			
		$i=1;
		foreach($withdraw_requests as $withdraw_request)
		{
			if($withdraw_request->status==1)
			$status ='<p class="text-success" ><i class="fas fa-check"></i> Approved</p>';
			else if($withdraw_request->status==2)
				$status ='<p class="text-danger" ><i class="fas fa-times"></i> Canceled</p>';
			else if($withdraw_request->status==0)
			$status ='<p class="text-warning" ><i class="fas fa-clock"></i> Pending</p>';
          $output .= ' 
               <tr>  
                     
                    <td>'.$i.'</td>  
                    <td>$'.($withdraw_request->amount).'</td>  
                    <td>'.ucfirst($withdraw_request->type).'</td>  
                    <td>'.($withdraw_request->paypal_id).'</td>  
                    <td>'.date("d-M-Y",strtotime($withdraw_request->today_date)).'</td>  
                    <td>'.$status.'</td>  
               </tr>
			   ';
			   $i++;
		}
     $output .= "</tbody> </table></div>";  
     echo $output; 
    } 
	public function index()
    {
        //
		$withdraws = Withdraw::where(['is_deleted'=>0])->orderBy('id','desc')->get();
		return view("withdraw.index",compact("withdraws"));
    }
	public function approve_withdraw_request(Request $request,$id)
	{
		$withdraw = Withdraw::where(['id'=>$id,'is_deleted'=>0])->first();
		$withdraw->status = 1;
		if($withdraw->save())
		{
			$this->transaction_save_debit($withdraw->id,$withdraw->amount,$withdraw->id,$withdraw->user_id);
			return back()->with("Withdraw Request Approved Successfully");
		}
	}
	public function transaction_save_debit($order_id,$price,$rel_id,$user_id)
	{
		
		$transaction = New Transaction;
		$transaction->user_id = $user_id; 
		$transaction->party_name = Auth::user()->first_name." ".Auth::user()->last_name; 
		$transaction->sales_ledger = Auth::user()->first_name." ".Auth::user()->last_name; 
		$transaction->description = 'Amount Withdraw'; 
		$transaction->comment = 'Amount Withdraw Request Accepted By Admin'; 
		$transaction->lottery_id = 0; 
		$transaction->add_lottery_id = session('add_lottery_id') ?? 0;
		$transaction->form_name ="withdraw";	
		$transaction->order_id = $order_id; 
		$transaction->invoice_number = $order_id; 
		$transaction->transaction_date = date('Y-m-d'); 
		$transaction->today_date = date('Y-m-d'); 
		$transaction->dr = $price ;
		$transaction->rel_id = $rel_id;
		$transaction->p_type = "paid";
		$transaction->save();
		
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
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function show(Withdraw $withdraw)
    {
        //
		if($withdraw->status==1)
			$status ='<p class="text-success" ><i class="fas fa-check"></i> Approved</p>';
			else if($withdraw->status==2)
				$status ='<p class="text-danger" ><i class="fas fa-times"></i> Canceled</p>';
			else if($withdraw->status==0)
			$status ='<p class="text-warning" ><i class="fas fa-clock"></i> Pending</p>';
		
      $output='';
      $output.= '  
      <div style="overflow-y: height:300px;" class="table-responsive">  
          <table align="center" border="0" class="table" width="100%"> '; 
        
        
      $output .= '  
				<tr>  
                    <td width="30%"><label>Amount</label></td>  
                    <td width="70%">$'.$withdraw->amount.'</td>  
				</tr>
				<tr>  
                    <td width="30%"><label>Type</label></td>  
                    <td width="70%">'.ucwords($withdraw->type).'</td>  
				</tr>';
				if($withdraw->type=='paypal')
				{
				 $output .= '<tr>  
                    <td width="30%"><label>Paypal Id</label></td>  
                    <td width="70%">'.$withdraw->paypal_id.'</td>  
				</tr>'; 	
				}
				else
				{
					$output .= '
					
					<tr>  
                    <td width="30%"><label>Ac Holder Name</label></td>  
                    <td width="70%">'.$withdraw->account_holder_name.'</td>  
					</tr>
					<tr>  
                    <td width="30%"><label>Ac No</label></td>  
                    <td width="70%">'.$withdraw->account_no.'</td>  
					</tr>
					<tr>  
                    <td width="30%"><label>Phone No</label></td>  
                    <td width="70%">'.$withdraw->phone_no.'</td>  
					</tr>
					<tr>  
                    <td width="30%"><label>Bank Name</label></td>  
                    <td width="70%">'.$withdraw->bank_name.'</td>  
					</tr>
					<tr>  
                    <td width="30%"><label>Branch Name</label></td>  
                    <td width="70%">'.$withdraw->branch_name.'</td>  
					</tr>
					<tr>  
                    <td width="30%"><label>Swit Code</label></td>  
                    <td width="70%">'.$withdraw->swift_code.'</td>  
					</tr>
					<tr>  
                    <td width="30%"><label>Branch Address</label></td>  
                    <td width="70%">'.$withdraw->branch_address.'</td>  
					</tr>
				';
				}
						
			  $output .= ' 
			 
			   <tr>  
                    <td width="30%"><label>Created Date</label></td>  
                    <td width="70%">'.date("d-M-Y",strtotime($withdraw->today_date)).'</td>  
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
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function edit(Withdraw $withdraw)
    {
        //
			
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Withdraw $withdraw)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy(Withdraw $withdraw)
    {
        //
		$withdraw->status = 2;
		if($withdraw->save())
		{
			return back()->with("Withdraw Request Canceled Successfully");
		}
    }
}
