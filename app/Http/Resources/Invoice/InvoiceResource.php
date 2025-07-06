<?php

namespace App\Http\Resources\Invoice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=>$this->name,
            'customer_id'=>$this->customer_id,
            'payment_term'=>$this->payment_term,
            'invoice_total'=>$this->invoice_total,
            'paid_total'=>$this->paid_total,
            'previous_due'=>$this->previous_due,
            'remarks'=>$this->remarks,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }

    public function with ($request):array{
        return['status'=>'successful save'];
    }
}
