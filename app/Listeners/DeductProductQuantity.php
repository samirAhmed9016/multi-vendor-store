<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Object $event): void
    {
        // // Assuming $event contains the order details
        // foreach ($event->order->items as $item) {
        //     $product = $item->product;
        //     if ($product && $product->quantity >= $item->quantity) {
        //         $product->quantity -= $item->quantity;
        //         $product->save();
        //     } else {
        //         // Handle insufficient stock, e.g., throw an exception or log a warning
        //     }
        // }
        $order = $event->order;
        try {
            foreach ($order->products  as $product) {
                $product->decrement('quantity', $product->pivot->quantity);
            }
        } catch (Throwable $e) {
            throw $e;
        }

        // Product::where('id', '=', $item->product_id)
        //     ->update([
        //         'quantity' => DB::raw("quantity - {$item->quantity}"),
        //     ]);
    }
}
