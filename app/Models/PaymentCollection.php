<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentCollection extends Model
{
    protected $fillable = ['user_id', 'store_id', 'order_id', 'collection_amount', 'bank_name', 'cheque_number', 'cheque_date', 'payement_type', 'image', 'is_approve'];

    public function users() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function admins() {
        return $this->belongsTo('App\Models\Admin', 'admin_id', 'id');
    }
    public function stores() {
        return $this->belongsTo('App\Models\Store', 'store_id', 'id');
    }
}
