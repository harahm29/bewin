<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddLotteryTicket extends Model
{
     public function LotteryTicket()
    {
        return $this->hasMany('App\Lottery','lottery_id');
    }
}
