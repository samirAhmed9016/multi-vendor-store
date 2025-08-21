<?php

namespace App\Listeners;

use App\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmptyCart
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        // Initialization code if needed
        // This listener can be used to handle the event of emptying the cart
        // For example, you can log the event or perform additional actions
        // when the cart is emptied.
        // Currently, it does not perform any specific action.

    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {

        Cart::empty();
    }
}
