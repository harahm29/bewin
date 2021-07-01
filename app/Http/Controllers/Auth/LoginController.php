<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Home;
use App\Lottery;
use App\Winner;
use App\AddLotteryTicket;
use App\PastWinner;
use Auth;
use DB;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	 
    public function showLoginForm ()
    {
		
		$home = Home::where(['is_deleted'=>0])->first();
		$lotterys = Lottery::select('lotteries.*',DB::raw("time_slots.name as draw_timing"),DB::raw("(select ts.name  from time_slots as ts where ts.id=lotteries.end_lottery_time) as end_time"))
		->leftjoin("time_slots",function($join){
			$join->on("time_slots.id","=","lotteries.draw_timing");
		})
		->where(['lotteries.is_deleted'=>0])
		->where('lotteries.validity','>=',date("Y-m-d"))
		->orderBy('lotteries.id','desc')
		->get();
		
		
// $users = User::select("*")->get();
// $query = DB::getQueryLog();
// $query = end($query);
// dd($query);
		
		
		$winners = AddLotteryTicket::select("add_lottery_tickets.*",DB::raw("concat(users.first_name,users.last_name) as name"),DB::raw("lotteries.name as lottery_name"),DB::raw("lotteries.image as lottery_image"),DB::raw("lotteries.image as lottery_image"),DB::raw("lotteries.cat1_val as cat1_val"))
					->leftjoin("users",function($join){
						$join->on("users.id","=","add_lottery_tickets.user_id");
					})
					->leftjoin("lotteries",function($join){
						$join->on("lotteries.id","=","add_lottery_tickets.lottery_id");
					})
					->groupBy('today_date','lottery_id')
					->where(['add_lottery_tickets.is_deleted'=>0])
					->orderBy("add_lottery_tickets.id","desc")->limit(10)->paginate(10);
				
		$pastwinners = PastWinner::select('past_winners.*',DB::raw("lotteries.name as lottery_name"),DB::raw("lotteries.image as lottery_image"))
						->leftjoin("lotteries",function($join){
							$join->on("lotteries.id","=","past_winners.lottery_id");
						})
						->where(['past_winners.is_deleted'=>0])
						->orderBy('past_winners.id','desc')->limit(10)->paginate(10);
					// echo "<pre>";
					// print_r($winners);exit;
		 return view('auth.login',compact('home','lotterys','winners','pastwinners'));
	}
	public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
