<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class,'users_id','id');
    }

    public function ordersItems(){
        return $this->hasMany(OrderItem::class,'orders_id','id');
    }

}
