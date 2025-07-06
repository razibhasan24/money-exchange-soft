<?php

namespace App\Http\Controllers\api\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = DB::table('invoices as i')
            ->join('customers as c', 'c.id', '=', 'i.customer_id')
            ->select('i.id', 'i.created_at', 'i.invoice_total', 'i.payment_term', 'c.name as customer')
            ->get();

        return json_encode(['invoices' => $invoices]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $invoice = new Invoice();
        $invoice->customer_id = $request->customer_id;
        $invoice->invoice_total = $request->invoice_total;
        $invoice->payment_term = $request->payment_term;
        $invoice->paid_total = $request->paid_total;
        $invoice->created_at = date('Y-m-d H:i:s');
        $invoice->remarks = $request->remark;
        $invoice->discount = $request->discount;
        $invoice->previous_due = 0;
        $invoice->save();

        //     $products=$request->items;
        //     foreach($products as $product){
        //         $details=new InvoiceDetail();
        //         $details->invoice_id=$invoice->id;
        //         $details->product_id=$product['id'];
        //         $details->price=$product['price'];
        //         $details->qty=$product['qty'];
        //         $details->vat=$product['vat'];
        //         $details->discount['discount'];
        //         $details->save();

        //         return json_encode(['invoice'=>$invoice]);
        //     }
        // }

        $products = $request->items ?? [];

        if (!is_array($products)) {
            return response()->json(['error' => 'Items must be an array'], 400);
        }

        foreach ($products as $product) {
            if (is_array($product)) {
                $details = new InvoiceDetail();
                $details->invoice_id = $invoice->id;
                $details->product_id = $product["id"] ?? null;
                $details->price = $product["price"] ?? 0;
                $details->qty = $product["qty"] ?? 0;
                $details->vat = $product["vat"] ?? 0;
                $details->discount = $product["discount"] ?? 0;
                $details->save();
            }
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
