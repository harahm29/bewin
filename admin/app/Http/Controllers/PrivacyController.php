<?php

namespace App\Http\Controllers;

use App\Privacy;
use Illuminate\Http\Request;
use Auth;
class PrivacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$contents = Privacy::where(['is_deleted'=>0])->get();
		return view("privacy.index",compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view("privacy.create");
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
		$privacy = new Privacy;
		$privacy->user_id = Auth::user()->id;
		$privacy->content = $request->content ?? "";
		if($privacy->save())
		{
			return redirect("privacy")->with("Data Inseted Successfully");
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function show(Privacy $privacy)
    {
        //
		$output='';
      $output.= '  
      <div style="overflow-y: height:300px;" class="table-responsive">  
          <table align="center" class="table table-bordered">'; 
        
        
      $output .= '  
        
         <tr>  
                    <td width="30%"><label>About Us</label></td>  
                    <td width="70%">'.$privacy->content.'</td>  
               </tr>
        
        
          
        
  
         ';
  
       
       
     $output .= "</table></div>";  
     echo $output; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function edit(Privacy $privacy)
    {
        //
		return view("privacy.edit",compact('privacy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Privacy $privacy)
    {
        //
		$privacy->user_id = Auth::user()->id;
		$privacy->content = $request->content ?? "";
		if($privacy->save())
		{
			return redirect("privacy")->with("Data Updated Successfully");
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Privacy $privacy)
    {
        //
    }
}
