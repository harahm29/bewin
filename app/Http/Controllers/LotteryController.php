<?php

namespace App\Http\Controllers;

use App\LotteryContent;
use App\Lottery;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DB;
use Session;
use App\Voucher;
use App\Commission;

class LotteryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//dd('hi');
        
		if(Auth::check())
			$user_id = Auth::user()->id;
		else
			$user_id = 0;
		// $lotterys = Lottery::select('lotteries.*',DB::raw("IFNULL((SELECT status FROM `add_lottery_tickets` as lt WHERE lt.user_id=$user_id and lt.lottery_id=lotteries.id and lt.status=1 and lt.is_deleted=0),0) as user_status"))->where(['lotteries.is_deleted'=>0])
					// ->leftjoin("add_lottery_tickets as alt",function($join){
						// $join->on("lotteries.id","=","alt.lottery_id");
					// })
					// ->groupBy('lotteries.id')
					// ->orderBy('lotteries.id','desc')->get();
		$lotterys = Lottery::where(['is_deleted'=>0])->orderBy('id','desc')->paginate(3);
		
		//dd($lotterys);
		return view ('lottery.lottery2',compact('lotterys'));
    }
    public function lottery2()
    {
        //
		
		if(Auth::check() && Auth::user()->type=='agent')
		{
			return redirect('/');
		}
		else
		{
		// $lotterys = Lottery::select('lotteries.*',DB::raw("IFNULL((SELECT status FROM `add_lottery_tickets` as lt WHERE lt.user_id=$user_id and lt.lottery_id=lotteries.id and lt.status=1 and lt.is_deleted=0),0) as user_status"))->where(['lotteries.is_deleted'=>0])
					// ->leftjoin("add_lottery_tickets as alt",function($join){
						// $join->on("lotteries.id","=","alt.lottery_id");
					// })
					// ->groupBy('lotteries.id')
					// ->orderBy('lotteries.id','desc')->get();
		$lotterys = Lottery::select('lotteries.*',DB::raw("time_slots.name as draw_timing"),DB::raw("(select ts.name  from time_slots as ts where ts.id=lotteries.end_lottery_time) as end_time"))
		->leftjoin("time_slots",function($join){
			$join->on("time_slots.id","=","lotteries.draw_timing");
		})
		->where(['lotteries.is_deleted'=>0])
		->where('lotteries.validity','>=',date("Y-m-d"))
		->orderBy('lotteries.id','desc')
		->paginate(3);
		$lotterycontent = LotteryContent::first();
					// echo "<pre>";
					// print_r($lotterys);exit;
		return view ('lottery.lottery2',compact('lotterys','lotterycontent'));
		}
    }
	public function lottery_detail()
    {
        //
		
		if(Auth::check() && Auth::user()->type=='agent')
		{
			return redirect('/');
		}
		else
		{
		// $lotterys = Lottery::select('lotteries.*',DB::raw("IFNULL((SELECT status FROM `add_lottery_tickets` as lt WHERE lt.user_id=$user_id and lt.lottery_id=lotteries.id and lt.status=1 and lt.is_deleted=0),0) as user_status"))->where(['lotteries.is_deleted'=>0])
					// ->leftjoin("add_lottery_tickets as alt",function($join){
						// $join->on("lotteries.id","=","alt.lottery_id");
					// })
					// ->groupBy('lotteries.id')
					// ->orderBy('lotteries.id','desc')->get();
		$lotterys = Lottery::select('lotteries.*',DB::raw("time_slots.name as draw_timing"),DB::raw("(select ts.name  from time_slots as ts where ts.id=lotteries.end_lottery_time) as end_time"))
		->leftjoin("time_slots",function($join){
			$join->on("time_slots.id","=","lotteries.draw_timing");
		})
		->where(['lotteries.is_deleted'=>0])
		->where('lotteries.validity','>=',date("Y-m-d"))
		->orderBy('lotteries.id','desc')
		->paginate(3);
					// echo "<pre>";
					// print_r($lotterys);exit;
		return view ('lottery.lottery-detail',compact('lotterys'));
		}
    }
    public function lottery1()
    {
        //
		$lotterys = Lottery::where(['is_deleted'=>0])->orderBy('id','desc')->get();
		return view ('lottery.lottery',compact('lotterys'));
    }
	public function lottery_signin()
    {
        //
		 $url = url()->previous();
		session(["back_url"=>$url]);
		return redirect('signin');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view ('lottery.create');
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
		$validator = Validator::make($request->all(), [
				'name' => 'required|max:255',
		]);
		
		
          if ($validator->fails()) 
		  {
           return back()
               ->withInput()
               ->withErrors($validator);
		  }
			if($request->hasFile('image') && $request->image->isValid())
           {
                $extension = $request->image->extension();
				$fileName  = time().".$extension";
				$request->image->move(public_path('images'),$fileName);
           } else{
				$fileName  ='default.jpg';
		   }
         $lottery = new Lottery;
         $lottery->user_id  			= Auth::user()->id;
		 $lottery->name  				= ucwords($request->name);
		 $lottery->image  			= $fileName;
		 $lottery->cat1_val  			= $request->cat1_val ?? "";
		 $lottery->cat1_max_winner  	= $request->cat1_max_winner ?? "";
		 $lottery->cat2_val  			= $request->cat2_val ?? "";
		 $lottery->cat2_max_winner  	= $request->cat2_max_winner ?? "";
		 $lottery->cat3_val  			= $request->cat3_val ?? "";
		 $lottery->cat3_max_winner  	= $request->cat3_max_winner ?? "";
		 $lottery->cat4_val  			= $request->cat4_val ?? "";
		 $lottery->cat4_max_winner  	= $request->cat4_max_winner ?? "";
		 $lottery->cat5_val  			= $request->cat5_val ?? "";
		 $lottery->cat5_max_winner  	= $request->cat5_max_winner ?? "";
		 $lottery->cat6_val  			= $request->cat6_val ?? "";
		 $lottery->cat6_max_winner  	= $request->cat6_max_winner ?? "";
		 $lottery->cat7_val  			= $request->cat7_val ?? "";
		 $lottery->cat7_max_winner  	= $request->cat7_max_winner ?? "";
		 $lottery->cat8_val  			= $request->cat8_val ?? "";
		 $lottery->cat8_max_winner  	= $request->cat8_max_winner ?? "";
	    
		if( $lottery->save())
		{
			return redirect('lottery')->with('message','Lottery Added Successfully.');
		}
	
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
	 
    public function show(Lottery $lottery)
    {
        //
		if(Auth::check() && Auth::user()->type=='agent')
		{
			return redirect('/');
		}
		else
		{
			$id = $lottery->id;
		$lottery = Lottery::select('lotteries.*',DB::raw("time_slots.name as draw_timing"),DB::raw("(select ts.name  from time_slots as ts where ts.id=lotteries.end_lottery_time) as end_time"))
		->leftjoin("time_slots",function($join){
			$join->on("time_slots.id","=","lotteries.draw_timing");
		})
		->where(['lotteries.is_deleted'=>0,'lotteries.id'=>$id])
		->where('lotteries.validity','>=',date("Y-m-d"))
		->first();
        return view ('lottery.show',compact('lottery'));
		}
		
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function edit(Lottery $lottery)
    {
        //
		return view ('lottery.edit',compact('lottery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lottery $lottery)
    {
        //
		$validator = Validator::make($request->all(), [
				'name' => 'required|max:255',
		]);
		
		
          if ($validator->fails()) 
		  {
           return back()
               ->withInput()
               ->withErrors($validator);
		  }
			if($request->hasFile('image') && $request->image->isValid())
           {
                $extension = $request->image->extension();
				$fileName  = time().".$extension";
				$request->image->move(public_path('images'),$fileName);
           } else{
				$fileName  =$lottery->image;
		   }
         // echo $request->cat1_max_winner;exit;
         $lottery->user_id  			= Auth::user()->id;
		 $lottery->name  				= ucwords($request->name);
		 $lottery->image  			= $fileName;
		 $lottery->cat1_val  			= $request->cat1_val ?? "";
		 $lottery->cat1_max_winner  	= $request->cat1_max_winner ?? "";
		 $lottery->cat2_val  			= $request->cat2_val ?? "";
		 $lottery->cat2_max_winner  	= $request->cat2_max_winner ?? "";
		 $lottery->cat3_val  			= $request->cat3_val ?? "";
		 $lottery->cat3_max_winner  	= $request->cat3_max_winner ?? "";
		 $lottery->cat4_val  			= $request->cat4_val ?? "";
		 $lottery->cat4_max_winner  	= $request->cat4_max_winner ?? "";
		 $lottery->cat5_val  			= $request->cat5_val ?? "";
		 $lottery->cat5_max_winner  	= $request->cat5_max_winner ?? "";
		 $lottery->cat6_val  			= $request->cat6_val ?? "";
		 $lottery->cat6_max_winner  	= $request->cat6_max_winner ?? "";
		 $lottery->cat7_val  			= $request->cat7_val ?? "";
		 $lottery->cat7_max_winner  	= $request->cat7_max_winner ?? "";
		 $lottery->cat8_val  			= $request->cat8_val ?? "";
		 $lottery->cat8_max_winner  	= $request->cat8_max_winner ?? "";
	    
		if($lottery->save())
		{
			return redirect('lottery')->with('message','Lottery Updated Successfully.');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lottery $lottery)
    {
        //
		$lottery->is_deleted  	= 1;
		if($lottery->save())
		{
			return back()->with('Lottery Deleted Successfully.');
		}
    }


	public function showinfo()
	{
		dd('hi');
	}


}
