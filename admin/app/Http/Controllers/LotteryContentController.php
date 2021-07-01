<?php

namespace App\Http\Controllers;

use App\LotteryContent;
use Illuminate\Http\Request;
use Auth;
class LotteryContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $lotteryContent =LotteryContent::get();
        return view('lotterycontent.index',compact('lotteryContent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('lotterycontent.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
	   $lotteryContent = New LotteryContent;
       $lotteryContent->user_id= Auth::user()->id;
       $lotteryContent->lottery_content= $request->lottery_content;
       $lotteryContent->lottery_content_des= $request->lottery_content_des;
       $lotteryContent->save();
	   return redirect('lottery-Content')->with('message','Lottery Content Store Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LotteryContent  $lotteryContent
     * @return \Illuminate\Http\Response
     */
    public function show(LotteryContent $lotteryContent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LotteryContent  $lotteryContent
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $lotteryContent =LotteryContent::find($id);
        return view('lotterycontent.edit',compact('lotteryContent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LotteryContent  $lotteryContent
     * @return \Illuminate\Http\Response
     */
	public function update(Request $request,$id)
    {
       $lotteryContent = LotteryContent::find($id);
	  
       $lotteryContent->user_id= Auth::user()->id;
       $lotteryContent->lottery_content= $request->lottery_content;
       $lotteryContent->lottery_content_des= $request->lottery_content_des;
       $lotteryContent->save();
	   return redirect('/lottery-Content')->with('message','Lottery Content Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LotteryContent  $lotteryContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(LotteryContent $lotteryContent)
    {
        //
    }
}
