<?php

namespace App\Http\Controllers;

use App\Faq;
use Illuminate\Http\Request;
use Auth;
class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$contents = Faq::where(['is_deleted'=>0])->get();
		return view("faqs.index",compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view("faqs.create");
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
		$faq = new Faq;
		$faq->user_id = Auth::user()->id;
		$faq->content = $request->content ?? "";
		if($faq->save())
		{
			return redirect("faq")->with("Data Inseted Successfully");
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
		 $output='';
      $output.= '  
      <div style="overflow-y: height:300px;" class="table-responsive">  
          <table align="center" class="table table-bordered">'; 
        
        
      $output .= '  
        
         <tr>  
                    <td width="30%"><label>Content</label></td>  
                    <td width="70%">'.$faq->content.'</td>  
               </tr>
        
        
          
        
  
         ';
  
       
       
     $output .= "</table></div>";  
     echo $output; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        //
		return view("faqs.edit",compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        //
		
		$faq->user_id = Auth::user()->id;
		$faq->content = $request->content ?? "";
		if($faq->save())
		{
			return redirect("faq")->with("Data Updated Successfully");
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        //
    }
}
