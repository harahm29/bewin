<?php

namespace App\Http\Controllers;

use App\Home;
use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$homes = Home::where(['is_deleted'=>0])->get();
		return view("home.index",compact('homes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view("home.create");
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
		if($request->hasFile('banner_image') && $request->banner_image->isValid())
		{
			$extension = $request->banner_image->extension();
			$banner_image  = "banner_image".time().".$extension";
			$request->banner_image->move(public_path('images'),$banner_image);
						
						
		}
		else
		{
			$banner_image  ='default.jpg';
		}
		if($request->hasFile('how_to_start1_image') && $request->how_to_start1_image->isValid())
		{
			$extension = $request->how_to_start1_image->extension();
			$how_to_start1_image  = "image1".time().".$extension";
			$request->how_to_start1_image->move(public_path('images'),$how_to_start1_image);
						
						
		}
		else
		{
			$how_to_start1_image  ='default.jpg';
		}
		if($request->hasFile('how_to_start2_image') && $request->how_to_start2_image->isValid())
		{
			$extension = $request->how_to_start2_image->extension();
			$how_to_start2_image  = "image2".time().".$extension";
			$request->how_to_start2_image->move(public_path('images'),$how_to_start2_image);
						
						
		}
		else
		{
			$how_to_start2_image  ='default.jpg';
		}
		if($request->hasFile('how_to_start3_image') && $request->how_to_start3_image->isValid())
		{
			$extension = $request->how_to_start3_image->extension();
			$how_to_start3_image  = "image3".time().".$extension";
			$request->how_to_start3_image->move(public_path('images'),$how_to_start3_image);
						
						
		}
		else
		{
			$how_to_start3_image  ='default.jpg';
		}
		
		$home = new Home;
		$home->user_id = Auth::user()->id;
		$home->banner_text = $request->banner_text ?? "";
		$home->banner_image = $banner_image;
		$home->how_to_start1_image = $how_to_start1_image;
		$home->how_to_start2_image = $how_to_start2_image;
		$home->how_to_start3_image = $how_to_start3_image;
		$home->how_to_start1 = $request->how_to_start1 ?? "";
		$home->how_to_start2 = $request->how_to_start2 ?? "";
		$home->how_to_start3 = $request->how_to_start3 ?? "";
		$home->why_choose = $request->why_choose ?? "";
		$home->why_choose_des = $request->why_choose_des ?? "";
		$home->why_choose1 = $request->why_choose1 ?? "";
		$home->why_choose_des1 = $request->why_choosedes ?? "";
		$home->why_choose2 = $request->why_choose2 ?? "";
		$home->why_choose_des2 = $request->why_choose_des1 ?? "";
		$home->why_choose3 = $request->why_choose3 ?? "";
		$home->why_choose_des3 = $request->why_choose_des2 ?? "";
		if($home->save())
		{
			return redirect("home")->with("Data Inseted Successfully");
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function show(Home $home)
    {
        //
		$banner_image = url('public/images/'.$home->banner_image);
		$how_to_start1_image = url('public/images/'.$home->how_to_start1_image);
		$how_to_start2_image = url('public/images/'.$home->how_to_start2_image);
		$how_to_start3_image = url('public/images/'.$home->how_to_start3_image);
		$output='';
      $output.= '  
      <div style="overflow-y: height:300px;" class="table-responsive">  
          <table align="center" class="table table-bordered">'; 
        
        
      $output .= '  
        
               <tr>  
                    <td width="30%"><label>Banner Text</label></td>  
                    <td width="70%">'.$home->banner_text.'</td>  
               </tr>
			   <tr>  
                    <td width="30%"><label>Banner Image</label></td>  
                    <td width="70%"><a target="_blank" href="'.$banner_image.'"><img src="'.$banner_image.'" width="70" /></a></td>  
               </tr> 
			   
			   <tr>  
                    <td width="30%"><label>How to Start Image1</label></td>  
                    <td width="70%"><a target="_blank" href="'.$how_to_start1_image.'"><img src="'.$how_to_start1_image.'" width="70" /></a></td>  
               </tr> 
			   <tr>  
                    <td width="30%"><label>How to Start Image2</label></td>  
                    <td width="70%"><a target="_blank" href="'.$how_to_start2_image.'"><img src="'.$how_to_start2_image.'" width="70" /></a></td>  
               </tr> 
			   <tr>  
                    <td width="30%"><label>How to Start Image3</label></td>  
                    <td width="70%"><a target="_blank" href="'.$how_to_start3_image.'"><img src="'.$how_to_start3_image.'" width="70" /></a></td>  
               </tr> 
			   
			    <tr>  
                    <td width="30%"><label>How To Start 1</label></td>  
                    <td width="70%">'.$home->how_to_start1.'</td>  
               </tr>
				<tr>  
                    <td width="30%"><label>How To Start 2</label></td>  
                    <td width="70%">'.$home->how_to_start2.'</td>  
               </tr>
				<tr>  
                    <td width="30%"><label>How To Start 3</label></td>  
                    <td width="70%">'.$home->how_to_start3.'</td>  
               </tr>
        <tr>  
                    <td width="30%"><label>Why Choose</label></td>  
                    <td width="70%">'.$home->why_choose.'</td>  
               </tr>
        <tr>  
                    <td width="30%"><label>Why Choose Description</label></td>  
                    <td width="70%">'.$home->why_choose1.'</td>  
               </tr>
        
          
        
  
         ';
  
       
       
     $output .= "</table></div>";  
     echo $output;   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function edit(Home $home)
    {
        //
		return view("home.edit",compact('home'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Home $home)
    {
        //
		if($request->hasFile('banner_image') && $request->banner_image->isValid())
		{
			$extension = $request->banner_image->extension();
			$banner_image  = "banner_image".time().".$extension";
			$request->banner_image->move(public_path('images'),$banner_image);
						
						
		}
		else
		{
			$banner_image  = $home->banner_image;
		}
		if($request->hasFile('how_to_start1_image') && $request->how_to_start1_image->isValid())
		{
			$extension = $request->how_to_start1_image->extension();
			$how_to_start1_image  = "image1".time().".$extension";
			$request->how_to_start1_image->move(public_path('images'),$how_to_start1_image);
						
						
		}
		else
		{
			$how_to_start1_image  =  $home->how_to_start1_image;
		}
		if($request->hasFile('how_to_start2_image') && $request->how_to_start2_image->isValid())
		{
			$extension = $request->how_to_start2_image->extension();
			$how_to_start2_image  = "image2".time().".$extension";
			$request->how_to_start2_image->move(public_path('images'),$how_to_start2_image);
						
						
		}
		else
		{
			$how_to_start2_image  =  $home->how_to_start2_image;
		}
		if($request->hasFile('how_to_start3_image') && $request->how_to_start3_image->isValid())
		{
			$extension = $request->how_to_start3_image->extension();
			$how_to_start3_image  = "image3".time().".$extension";
			$request->how_to_start3_image->move(public_path('images'),$how_to_start3_image);
						
						
		}
		else
		{
			$how_to_start3_image  = $home->how_to_start3_image;
		}
		
		
		$home->user_id = Auth::user()->id;
		$home->banner_text = $request->banner_text ?? "";
		$home->banner_image = $banner_image;
		$home->how_to_start1_image = $how_to_start1_image;
		$home->how_to_start2_image = $how_to_start2_image;
		$home->how_to_start3_image = $how_to_start3_image;
		$home->how_to_start1 = $request->how_to_start1 ?? "";
		$home->how_to_start2 = $request->how_to_start2 ?? "";
		$home->how_to_start3 = $request->how_to_start3 ?? "";
		$home->why_choose = $request->why_choose ?? "";
		$home->why_choose_des = $request->why_choose_des ?? "";
		$home->why_choose1 = $request->why_choose1 ?? "";
		$home->why_choose_des1 = $request->why_choose_des1 ?? "";
		$home->why_choose2 = $request->why_choose2 ?? "";
		$home->why_choose_des2 = $request->why_choose_des2 ?? "";
		$home->why_choose3 = $request->why_choose3 ?? "";
		$home->why_choose_des3 = $request->why_choose_des3 ?? "";
		$home->why_choose4 = $request->why_choose4 ?? "";
		$home->why_choose_des4 = $request->why_choose_des4 ?? "";
		
		if($home->save())
		{
			return redirect("home")->with("Data Updated Successfully");
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function destroy(Home $home)
    {
        //
    }
}
