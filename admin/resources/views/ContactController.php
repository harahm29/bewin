<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$data = Contact::where(['is_deleted'=>'0'])->get();
        return view('contact.index',compact('data'));
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
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
      $contact;
 $output='';
    $output.= '  
    <div style="overflow-y: height:300px; width:100px;" class="table-responsive">  
          <table align="center" class="table table-bordered">'; 
        
        
      $output .= '  
        <tr>  
                    <td width="30%"><label>Name</label></td>  
                    <td width="70%">'.$contact->name.'</td>  
               </tr>

               <tr>  
                    <td width="30%"><label>email</label></td>  
                    <td width="70%">'.$contact->email.'</td>  
               </tr>
               <tr>  
                    <td width="30%"><label>mobile_number</label></td>  
                    <td width="70%">'.$contact->mobile_number.'</td>  
               </tr>
               <tr>  
                    <td width="30%"><label>city</label></td>  
                    <td width="70%">'.$contact->city.'</td>  
               </tr>
                <tr>  
                    <td width="10%"><label>message</label></td>  
                    <td width="10%">'.$contact->message.'</td>  
               </tr>
       
  
         ';
  
       
       
     $output .= "</table></div>";  
     echo $output;      
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $user = Contact::find($id);
        if($user)
    {
      $user->delete();
      return back()->with('message','User delete successfully');
    }
    else
    {
      return back()->with('message','somthing wrong');
    }
    }
}