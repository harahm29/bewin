<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use Auth;
use DB;
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        // print_r($request->query()); EXIT;
	$teachers = User::where(['is_deleted'=>0])->where('id','!=',1)->get();
		if($request->query())
        {
		if($request->from!="")
		{
		  $from_date = date("Y-m-d",strtotime($request->from)); 
		  $to_date  =  date("Y-m-d",strtotime($request->to));
		}
		else
		{
		  $from_date = date("Y-m-01"); 
		  $to_date  =  date("Y-m-d");
		}
		
		$old_date_data =DB::table('transactions')
		->select(DB::raw('SUM(dr) - SUM(cr) as total_dr_cr'))
		->whereBetween('transaction_date',[$from_date,$to_date])
		// ->groupBy('form_name')
		->orderBy('id', 'DESC')
		->get();
		
	
		$old_date_data =0;	
		if($request->name)
			$user_id = $request->name;
		else
			$user_id = Auth::user()->id;
		
		$transactions = DB::table('users')
		->leftjoin('transactions','users.id','transactions.user_id')
		->whereBetween('transactions.transaction_date', [$from_date,$to_date])
		->where(['transactions.user_id'=>$user_id])
		->where('cr','>',0)
		->orderBy('transactions.id','desc')->paginate(10);
		
		return view('transaction.index',compact('transactions','old_date_data','teachers'));
		
		}else{
		$transactions = Transaction::where(['user_id'=>Auth::user()->id])->where('cr','>',0)->orderBy('id','desc')->paginate(10);
		$search='';
		$old_date_data = 0;
		return view('transaction.index',compact('transactions','search','old_date_data','teachers'));	
		}
    }

    /**
     * Show the form for creating Statement.
     *
     * @return \Illuminate\Http\Response
     */ 
	 	public function statement_pdf($search,$from,$to)
	{
	      $teachername = User::select('first_name')->where(['is_deleted'=>0,'id'=>$search])->first();
		 $from_date = date("Y-m-d",strtotime($from)); 
		 $to_date  =  date("Y-m-d",strtotime($to));
	    
		
		$old_date_data =DB::table('transactions')
		->select(DB::raw('SUM(dr) - SUM(cr) as total_dr_cr'))
	    ->where('user_id',$search)
		->whereBetween('transaction_date',[$from_date,$to_date])
		->where('cr','>',0)
		->groupBy(['user_id'])
		->first();
		
		if($old_date_data)
	    $old_date_data  = $old_date_data->total_dr_cr;
		else
		$old_date_data =0;	

		$transactions = Transaction::where(function($q) use ($search) {  
		   $name=$search; 
			$q->orWhere('transactions.user_id','=', $search);
            })
		->whereBetween('transaction_date', [$from_date,$to_date])
		->where('cr','>',0)
		->orderBy('transactions.id','desc')->get();
		return view('transaction.teacherstatement',compact('transactions','search','old_date_data','from','to','teachername'));	
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
