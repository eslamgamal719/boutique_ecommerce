<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    const NEW_ORDER = 0;
    const PAYMENT_COMPLETED = 1;
    const UNDER_PROCESS = 2;
    const FINISHED = 3;
    const REJECTED = 4;
    const CANCELED = 5;
    const REFUNDED_REQUEST = 6;
    const RETURNED = 7;
    const REFUNDED = 8;


    public function status()
    {
        switch($this->order_status) {
            case 0: $result = 'New order'; break;
            case 1: $result = 'Paid'; break;
            case 2: $result = 'Under process'; break;
            case 3: $result = 'Finished'; break;
            case 4: $result = 'Rejected'; break;
            case 5: $result = 'Canceled'; break;
            case 6: $result = 'Refund requested'; break;
            case 7: $result = 'Refunded'; break;
            case 8: $result = 'Returned order'; break;
        }
        return $result;
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
