<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    public $timestamps=false;
    protected $fillable=['id', 'name', 'customer_id', 'payment_term', 'invoice_total', 'paid_total', 'previous_due', 'remarks', 'created_at', 'updated_at'];
}
