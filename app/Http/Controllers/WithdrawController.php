<?php

namespace App\Http\Controllers;

use App\Withdraw;
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
    public function withdraw_request(Request $request,$type)
    {
        //
		if($type=='paypal')
		$withdraw_requests = Withdraw::where(['user_id'=>Auth::user()->id,'is_deleted'=>0,'type'=>'paypal'])->orderBy('id','desc')->get();
		else
		$withdraw_requests = Withdraw::where(['user_id'=>Auth::user()->id,'is_deleted'=>0,'type'=>'wire-transfer'])->orderBy('id','desc')->get();
		
		
		
		
		// print_r($diff_in_days); // Output: 1

		$output= '';
		$output.= '  
		<div  class="table-responsive">  
          <table align="center" class="table table-bordered">
		  <thead>
			<th>SrNo</th>
			<th>Amount</th>
			<th>Type</th>';
			if($type=='paypal')
			{
				$output.= '<th>Paypal Id</th>';
			}
			else
			{
				$output.= '<th>Ac Holder Name</th>
						   <th>Ac No</th>
						   <th>Phone No</th>
						   <th>Bank Name</th>
						   <th>Branch Name</th>
						   <th>Swit Code</th>
						   <th>Branch Address</th>
							';
			}
			$output.= '<th>Date</th>
			<th>Status</th>
		  </thead><tbody> 
		  ';  
			
		$i=1;
		foreach($withdraw_requests as $withdraw_request)
		{
			if($withdraw_request->status==1)
			$status ='<p class="text-success" ><i class="fas fa-check"></i> Approve</p>';
			else if($withdraw_request->status==2)
				$status ='<p class="text-danger" ><i class="fas fa-times"></i> Cancel</p>';
			else if($withdraw_request->status==0)
			$status ='<p class="text-warning" ><i class="fas fa-clock"></i> Pending</p>';
          $output .= ' 
               <tr>  
                     
                    <td>'.$i.'</td>  
                    <td>$'.($withdraw_request->amount).'</td>  
                    <td>'.ucfirst($withdraw_request->type).'</td>  
                    ';
					if($type=='paypal')
					{
						$output.= '<td>'.($withdraw_request->paypal_id).'</td>';
					}
					else
					{
						$output.= '<td>'.($withdraw_request->account_holder_name).'</td>';
						$output.= '<td>'.($withdraw_request->account_no).'</td>';
						$output.= '<td>'.($withdraw_request->phone_no).'</td>';
						$output.= '<td>'.($withdraw_request->bank_name).'</td>';
						$output.= '<td>'.($withdraw_request->branch_name).'</td>';
						$output.= '<td>'.($withdraw_request->swift_code).'</td>';
						$output.= '<td>'.($withdraw_request->branch_address).'</td>';
					}
                    $output.= '<td>'.date("d-M-Y",strtotime($withdraw_request->today_date)).'</td>  
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
    }
}
