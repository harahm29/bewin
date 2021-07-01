<?php

namespace App\Http\Controllers;

use App\SocialLink;
use Illuminate\Http\Request;
use Auth;
class SocialLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$contents = SocialLink::where(['is_deleted'=>0])->get();
		return view("sociallink.index",compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view("sociallink.create");
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
		$sociallink = new SocialLink;
		$sociallink->user_id = Auth::user()->id;
		$sociallink->facebook = $request->facebook ?? "";
		$sociallink->instagram = $request->instagram ?? "";
		if($sociallink->save())
		{
			return redirect("sociallink")->with("Data Inseted Successfully");
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SocialLink  $socialLink
     * @return \Illuminate\Http\Response
     */
    public function show(SocialLink $sociallink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SocialLink  $socialLink
     * @return \Illuminate\Http\Response
     */
    public function edit(SocialLink $sociallink)
    {
        //
			return view("sociallink.edit",compact('sociallink'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SocialLink  $socialLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SocialLink $sociallink)
    {
        //
		$sociallink->user_id = Auth::user()->id;
		$sociallink->user_id = Auth::user()->id;
		$sociallink->facebook = $request->facebook ?? "";
		$sociallink->instagram = $request->instagram ?? "";
		if($sociallink->save())
		{
			return redirect("sociallink")->with("Data Updated Successfully");
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SocialLink  $socialLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialLink $sociallink)
    {
        //
    }
}
