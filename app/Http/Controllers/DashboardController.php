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
use App\Home;
use App\Content;
use App\About;
use App\Faq;
use App\Contact;
use App\Winner;
use App\Privacy;
use App\TermAndCondition;
use App\PastWinner;

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
			
		$users_count = User::where(['is_deleted'=>0])->where('id','!=',1)->count();
		$users = User::where(['is_deleted'=>0])->where('id','!=',1)->get();
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
			return view('dashboard.index',compact('users_count','lotterys','users','lottery_count'));
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
	public function about()
	{
		$content = About::where(['is_deleted'=>0])->first();
		return view('dashboard.about',compact('content'));
	}
	public function contact()
	{
		$content = Contact::where(['is_deleted'=>0])->first();
		return view('dashboard.contact',compact('content'));
	}
	public function faqs()
	{
		$content = Faq::where(['is_deleted'=>0])->first();
		return view('dashboard.faqs',compact('content'));
	}
	public function privacy()
	{
		$content = Privacy::where(['is_deleted'=>0])->first();
		return view('dashboard.privacy',compact('content'));
	}
	public function term_and_condition()
	{
		$content = TermAndCondition::where(['is_deleted'=>0])->first();
		return view('dashboard.term-and-condition',compact('content'));
	}
	public function past_winners(Request $request)
	{
		if($request->lottery_id)
			$lottery_id = $request->lottery_id;
		else
			$lottery_id = 0;
		$lotterys = Lottery::where(['is_deleted'=>0])->orderBy('id','desc')->get();				
		$winners = Winner::select("winners.*",DB::raw("concat(users.first_name,users.last_name) as name"),DB::raw("lotteries.name as lottery_name"),DB::raw("lotteries.image as lottery_image"),DB::raw("lotteries.cat1_val as lottery_amount"))
					->leftjoin("users",function($join){
						$join->on("users.id","=","winners.user_id");
					})
					->leftjoin("lotteries",function($join){
						$join->on("lotteries.id","=","winners.lottery_id");
					})
					->where(['winners.is_deleted'=>0])
					->when($request->lottery_id,function($q) use ($lottery_id){
						return $q->where("winners.lottery_id",$lottery_id);
					})
					->groupBy('winners.today_date','winners.lottery_id')
					->orderBy("winners.id","desc")->limit(10)->paginate(10);
					// echo "<pre>";
					// print_r($winners);exit;
		return view('dashboard.past-winners',compact('winners','lotterys','lottery_id'));
	}
	
	
	
	
	//////////////////////////////////////////////////////////////////////////////////////
}
?>
