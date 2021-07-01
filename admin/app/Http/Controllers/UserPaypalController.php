<?php

namespace App\Http\Controllers;

use App\UserPaypal;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DB;

class UserPaypalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
		// echo "<pre>";
		// print_r($_POST);
		// exit;
		$validator = Validator::make($request->all(),[
				'paypal_id' => 'required|unique:user_paypals,paypal_id',
				]);
			
		if($validator->fails())
		{
			$data['status'] = 0;
			$data['message'] = $validator->errors()->first('paypal_id');
			return json_encode($data);
		}
		// echo "check";
		// exit;
		$userpaypal = new UserPaypal;
		$userpaypal->user_id = Auth::user()->id;
		$userpaypal->paypal_id = $request->paypal_id;
		if($userpaypal->save())
		{
			$data['status'] = 1;
			$data['message'] = "Paypal id added successfully";
			return json_encode($data);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserPaypal  $userPaypal
     * @return \Illuminate\Http\Response
     */
    public function show(UserPaypal $userpaypal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserPaypal  $userPaypal
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPaypal $userpaypal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserPaypal  $userPaypal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPaypal $userpaypal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserPaypal  $userPaypal
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPaypal $userpaypal)
    {
        //
    }
}
