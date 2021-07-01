<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Deliveryboy;
use App\MilkEntry;
use App\Order;
use App\OrderDetail;
use App\Referral;
use App\Productplan;
use App\Lottery;
use Auth;
use DB;
use Illuminate\Support\Facades\Redis;
use App\Events\WebsocketDemoEvent;
class DashboardController extends Controller
{
    //
	public function demo ()
	{
		return view('dashboard.index');
	}
	public function index()
    {
        //
		$auth_id = Auth::user()->id;
		if($auth_id == 1){
			
		$users_count = User::where(['is_deleted'=>0,'type'=>'user'])->where('id','!=',1)->count();
		$agent_count = User::where(['is_deleted'=>0,'type'=>'agent'])->where('id','!=',1)->count();
		$users = User::withCount('referrals')->where(['is_deleted'=>0,'type'=>'user'])->where('id','!=',1)->orderBy('id','desc')->get();
		$agents = User::withCount('referrals')->where(['is_deleted'=>0,'type'=>'agent'])->where('id','!=',1)->orderBy('id','desc')->get();
		
		//dd(Auth::user()->username);
		//dd($agents);
		// $total_order = Order::count();
		// $pending_order = Order::where(['status'=>'pending'])->count();
		// $complete_order = Order::where(['status'=>'complete'])->count();
		// $failed_order = Order::where(['status'=>'failed'])->count();
		// $teacher_incentive = Referral::where(['teacher_id'=>$auth_id])->sum('teacher_incentive');
		
		// return view('dashboard.index',compact('users','total_order','pending_order','complete_order','failed_order','auth_id','teacher_incentive'));
		// }else
		// {
		// $users = User::where(['is_deleted'=>0])->where(['teacher_id'=>$auth_id])->count();
		// $total_order = Order::where(['user_id'=>$auth_id])->count();
		// $teacher_incentive = Referral::where(['teacher_id'=>$auth_id])->sum('teacher_incentive');
		// $pending_order = Order::where(['status'=>'pending','user_id'=>$auth_id])->count();
		// $complete_order = Order::where(['status'=>'complete','user_id'=>$auth_id])->count();
		// $failed_order = Order::where(['status'=>'failed','user_id'=>$auth_id])->count();
		//	return view('dashboard.index',compact('users','total_order','pending_order','complete_order','failed_order','auth_id','teacher_incentive'));
		$lotterys = Lottery::where(['is_deleted'=>0])->orderBy('id','desc')->get();
		$lottery_count = Lottery::where(['is_deleted'=>0])->count();
			return view('dashboard.index',compact('users_count','lotterys','users','lottery_count','agents','agent_count'));
		}
    }
	
	public function user_order_details($user_id,$order_date)
		{
			return $order_details = OrderDetail::where(['user_id'=>$user_id,'order_date'=>$order_date])->get();
		}
	public function get_plan_details($user_plan_id)
		{
			
			return $plan = Productplan::select('id','product_name','weight','price')->whereIn('id',explode(",",$user_plan_id))->get();
			
		}
	public function get_plan_detail($user_plan_id)
		{
			
			return $plan = Productplan::select(DB::raw("sum(weight) as total_weight"),DB::raw("sum(price) as total_price"))->whereIn('id',explode(",",$user_plan_id))->first();
			
		}
	
	public function user_plans_details($id)
	{
		
		$user = User::find($id);
		$products = Productplan::select('id','product_name','weight','price')->whereIn('id',explode(",",$user->user_plan_id))->get();
		 $data='<div class="table-responsive">
	<table id="example" class="display table table-striped table-hover" >
		<thead>
		<tr>
			<th>Sr No</th>
			<th>Product Name</th>
			<th>Weight</th>
			<th>Price</th>
		</tr>
	   </thead>
	<tbody>';
	$i=1; 
	foreach($products as $product)
	{
	 $data.='<tr>
			<td>'.$i.'</td>
			<td>'.$product->product_name.'</td>
			<td>'.$product->weight.'</td>
			<td>'.$product->price.'</td>
		</tr>';
		$i++;
	}
	$data.='	
		</tr>
	</tbody>
		</table>
		</div>';
	return $data;
	
	
	}
	
	
	
	
	
	//////////////////////////////////////////////////////////////////////////////////////
}
?>
