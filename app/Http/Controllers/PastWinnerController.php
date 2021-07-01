<?php

namespace App\Http\Controllers;

use App\PastWinner;
use App\Lottery;
use Illuminate\Http\Request;
use Auth;
use DB;
use Validator;
class PastWinnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$pastwinners = PastWinner::select('past_winners.*',DB::raw("lotteries.name as lottery_name"))
						->leftjoin("lotteries",function($join){
							$join->on("lotteries.id","=","past_winners.lottery_id");
						})
						->where(['past_winners.is_deleted'=>0])
						->orderBy('past_winners.id','desc')->get();
		return view('pastwinner.index',compact('pastwinners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$lotterys = Lottery::where(['is_deleted'=>0])->get();
		// echo "<pre>";
		// print_r($lotterys);exit;
		return view('pastwinner.create',compact('lotterys'));
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
				'lottery_id' => 'required',
				'draw_date' => 'required',
				'winning_no' => 'required',
				'powerball' => 'required',
				'winning_amount' => 'required',
				'winner_name' => 'required',
				]);
			
			if($validator->fails())
			{
				return back()
					->withInput()
					->withErrors($validator);
			}
		$pastwinner = new PastWinner;
		$pastwinner->user_id = Auth::user()->id;
		$pastwinner->lottery_id = $request->lottery_id ?? 0;
		$pastwinner->draw_date = date("Y-m-d",strtotime($request->draw_date));
		$pastwinner->winning_no = $request->winning_no ?? "";
		$pastwinner->powerball = $request->powerball ?? "";
		$pastwinner->winning_amount = $request->winning_amount ?? 0;
		$pastwinner->winner_name = $request->winner_name ?? "";
		if($pastwinner->save())
		{
			return redirect('pastwinner')->with('Past Winner Added Successfully');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PastWinner  $pastWinner
     * @return \Illuminate\Http\Response
     */
    public function show(PastWinner $pastWinner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PastWinner  $pastWinner
     * @return \Illuminate\Http\Response
     */
    public function edit(PastWinner $pastwinner)
    {
        //
		$lotterys = Lottery::where(['is_deleted'=>0])->get();
		return view('pastwinner.edit',compact('pastwinner','lotterys'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PastWinner  $pastWinner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PastWinner $pastwinner)
    {
        //
		$validator = Validator::make($request->all(),[
				'lottery_id' => 'required',
				'draw_date' => 'required',
				'winning_no' => 'required',
				'powerball' => 'required',
				'winning_amount' => 'required',
				'winner_name' => 'required',
				]);
			
			if($validator->fails())
			{
				return back()
					->withInput()
					->withErrors($validator);
			}
		
		$pastwinner->user_id = Auth::user()->id;
		$pastwinner->lottery_id = $request->lottery_id ?? 0;
		$pastwinner->draw_date = date("Y-m-d",strtotime($request->draw_date));
		$pastwinner->winning_no = $request->winning_no ?? "";
		$pastwinner->powerball = $request->powerball ?? "";
		$pastwinner->winning_amount = $request->winning_amount ?? 0;
		$pastwinner->winner_name = $request->winner_name ?? "";
		if($pastwinner->save())
		{
			return redirect('pastwinner')->with('Past Winner Updated Successfully');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PastWinner  $pastWinner
     * @return \Illuminate\Http\Response
     */
    public function destroy(PastWinner $pastwinner)
    {
        //
		$pastwinner->is_deleted = 1;
		if($pastwinner->save())
		{
			return redirect('pastwinner')->with('Past Winner Deleted Successfully');
		}
    }
}
