<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Exceptions\InvalidOrderException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartModelRepository $cart)
    {


        // Check if the cart is empty
        if ($cart->get()->count() == 0) {
            throw new InvalidOrderException('cart is empty.');
            // return redirect()->route('home')->with('error', 'Your cart is empty.');
        }



        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(Request $request, CartModelRepository $cart)
    {
        // Validate the request data
        $request->validate([
            'addr.billing.first_name' => 'required|string|max:255',
            'addr.billing.last_name' => 'required|string|max:255',
            'addr.billing.email' => 'required|email|max:255',
            'addr.billing.phone_number' => 'required|string|max:20',
            'addr.billing.city' => 'required|string|max:255',
            'addr.billing.postal_code' => 'required|max:20',
            'addr.billing.state' => 'required|string|max:255',
            'addr.billing.country' => 'required|string|max:255',
            'addr.shipping.first_name' => 'required|string|max:255',
            'addr.shipping.last_name' => 'required|string|max:255',
            'addr.shipping.email' => 'required|email|max:255',
            'addr.shipping.phone_number' => 'required|string|max:20',
            'addr.shipping.city' => 'required|string|max:255',
            'addr.shipping.postal_code' => 'required|max:20',
            'addr.shipping.state' => 'required|string|max:255',
            'addr.shipping.country' => 'required|string|max:255',
        ]);

        $items = $cart->get()->groupBy('product.store_id')->all();


        DB::beginTransaction();
        try {
            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',
                    // Add other necessary fields for the order
                ]);
                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,

                    ]);
                }
                foreach ($request->post('addr') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }
            // $cart->empty();
            DB::commit();
            // event('order.created', $order, Auth::user());
            event(new OrderCreated($order));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
            //return redirect()->back()->withErrors(['error' => 'Checkout failed: ' . $e->getMessage()]);
        };



        // Logic to handle the checkout process
        // Validate and process payment, create order, etc.

        // Redirect or return response after processing
        return redirect()->route('home')->with('success', 'Checkout completed successfully!');
    }
}
