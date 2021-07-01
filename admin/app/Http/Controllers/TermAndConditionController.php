<?php

namespace App\Http\Controllers;

use App\TermAndCondition;
use Illuminate\Http\Request;
use Auth;
class TermAndConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$contents = TermAndCondition::where(['is_deleted'=>0])->get();
		return view("termandcondition.index",compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view("termandcondition.create");
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
		$termandcondition = new TermAndCondition;
		$termandcondition->user_id = Auth::user()->id;
		$termandcondition->content = $request->content ?? "";
		if($termandcondition->save())
		{
			return redirect("termandcondition")->with("Data Inseted Successfully");
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TermAndCondition  $termAndCondition
     * @return \Illuminate\Http\Response
     */
    public function show(TermAndCondition $termAndCondition)
    {
        //
		$output='';
      $output.= '  
      <div style="overflow-y: height:300px;" class="table-responsive">  
          <table align="center" class="table table-bordered">'; 
        
        
      $output .= '  
        
         <tr>  
                    <td width="30%"><label>About Us</label></td>  
                    <td width="70%">'.$termandcondition->content.'</td>  
               </tr>
        
        
          
        
  
         ';
  
       
       
     $output .= "</table></div>";  
     echo $output; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TermAndCondition  $termAndCondition
     * @return \Illuminate\Http\Response
     */
    public function edit(TermAndCondition $termandcondition)
    {
        //
		return view("termandcondition.edit",compact('termandcondition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TermAndCondition  $termAndCondition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TermAndCondition $termandcondition)
    {
        //
		$termandcondition->user_id = Auth::user()->id;
		$termandcondition->content = $request->content ?? "";
		if($termandcondition->save())
		{
			return redirect("termandcondition")->with("Data Updated Successfully");
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TermAndCondition  $termAndCondition
     * @return \Illuminate\Http\Response
     */
    public function destroy(TermAndCondition $termandcondition)
    {
        //
    }
}
