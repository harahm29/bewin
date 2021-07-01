<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Http\Request;
use Auth;
class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$contents = Content::where(['is_deleted'=>0])->get();
		return view("content.index",compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view("content.create");
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
		$content = new Content;
		$content->user_id = Auth::user()->id;
		$content->about = $request->about ?? "";
		$content->faqs = $request->faqs ?? "";
		$content->contact = $request->contact ?? "";
		if($content->save())
		{
			return redirect("content")->with("Data Inseted Successfully");
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        //
		
      $output='';
      $output.= '  
      <div style="overflow-y: height:300px;" class="table-responsive">  
          <table align="center" class="table table-bordered">'; 
        
        
      $output .= '  
        
         <tr>  
                    <td width="30%"><label>About Us</label></td>  
                    <td width="70%">'.$content->about.'</td>  
               </tr>
         <tr>  
                    <td width="30%"><label>FAQs</label></td>  
                    <td width="70%">'.$content->faqs.'</td>  
               </tr> 
			   <tr>  
                    <td width="30%"><label>Contact</label></td>  
                    <td width="70%">'.$content->contact.'</td>  
               </tr>
        
          
        
  
         ';
  
       
       
     $output .= "</table></div>";  
     echo $output;   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        //
		return view("content.edit",compact('content'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        //
		
		$content->user_id = Auth::user()->id;
		$content->about = $request->about ?? "";
		$content->faqs = $request->faqs ?? "";
		$content->contact = $request->contact ?? "";
		if($content->save())
		{
			return redirect("content")->with("Data Updated Successfully");
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        //
    }
}
