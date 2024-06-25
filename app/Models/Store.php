<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['user_id', 'store_name', 'contact','whatsapp','email','address','state','city','pin'];

    // public function user() {
    //     return $this->belongsTo('App\User', 'user_id', 'id');
    // }

    // public function ProductDetails() {
    //     return $this->HasMany('App\Models\Product', 'store_id', 'id')->where('status', 1);
    // }
}
