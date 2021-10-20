<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory, SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'coupons.code' => 10,
            'coupons.description' => 10,
        ],
    ];

    protected $dates = [
        'start_date',
        'expire_date'
    ];



    public function status()
    {
        return $this->status == 1 ? "Active" : 'Inactive';
    }

    public function discount($total)
    {
        if(!$this->checkDate() || !$this->checkUsedTimes()) {
            return 0;
        }
        return $this->checkGreaterThan($total) ? $this->doProcess($total) : 0;
    }

    protected function checkDate()
    {
        return $this->expire_date != '' ? (Carbon::now()->between($this->start_date, $this->expire_date, true) ? true : false) : true;
    }

    protected function checkUsedTimes()
    {
        return $this->use_times != '' ? ( $this->use_times > $this->used_times  ? true : false) : true;
    }

    protected function checkGreaterThan($total)
    {
        return $this->greater_than != '' ? ($total >= $this->greater_than ? true : false) : true;
    }

    protected function doProcess($total)
    {
        switch($this->type) {
            case 'fixed':
                return $this->value;
                break;

            case 'percentage':
                return ($this->value / 100) * $total;
                break;

            default: 
                return 0;        
        }
    }  

}
