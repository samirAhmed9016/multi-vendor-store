<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'cookie_id',
        'user_id',
        'product_id',
        'quantity',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
        'quantity' => 'integer',
    ];

    // protected static function booted()
    // {
    //     static::creating(function ($cart) {
    //         if (empty($cart->id)) {
    //             $cart->id = Str::uuid();
    //         }
    //     });

    //     // Apply store scope if the cart is associated with a product that has store_id
    //     static::addGlobalScope('store', new StoreScope());
    // }

    /**
     * Get the user that owns the cart item.
     */
    public function user()
    {
        return $this->belongsTo(User::class)
            ->withDefault([
                'name' => 'Anonymous'
            ]);
    }

    /**
     * Get the product in the cart.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    protected static function booted()
    {
        static::observe(CartObserver::class);
        static::addGlobalScope('cookie_id', function (Builder $builder) {
            $builder->where('cookie_id', '=', Cart::getCookieID());
        });
    }


    public static function getCookieID()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60);
        }
        return $cookie_id;
    }


























    // /**
    //  * Get the store through the product.
    //  */
    // public function store()
    // {
    //     return $this->hasOneThrough(Store::class, Product::class, 'id', 'id', 'product_id', 'store_id');
    // }

    // /**
    //  * Scope a query to only include cart items for a specific user or cookie.
    //  */
    // public function scopeForUser(Builder $query, $user = null)
    // {
    //     if ($user) {
    //         return $query->where('user_id', $user->id);
    //     }

    //     return $query->whereNull('user_id');
    // }

    // /**
    //  * Scope a query to only include cart items for a specific cookie.
    //  */
    // public function scopeForCookie(Builder $query, $cookieId)
    // {
    //     return $query->where('cookie_id', $cookieId);
    // }

    // /**
    //  * Get the total price for this cart item.
    //  */
    // public function getTotalPriceAttribute()
    // {
    //     return $this->product->price * $this->quantity;
    // }

    // /**
    //  * Get the formatted total price.
    //  */
    // public function getFormattedTotalPriceAttribute()
    // {
    //     return number_format($this->total_price, 2);
    // }

    // /**
    //  * Check if the cart item is for a guest user.
    //  */
    // public function isGuest()
    // {
    //     return is_null($this->user_id);
    // }

    // /**
    //  * Check if the cart item is for an authenticated user.
    //  */
    // public function isAuthenticated()
    // {
    //     return !is_null($this->user_id);
    // }

    // /**
    //  * Update the quantity of the cart item.
    //  */
    // public function updateQuantity($quantity)
    // {
    //     if ($quantity <= 0) {
    //         return $this->delete();
    //     }

    //     $this->update(['quantity' => $quantity]);
    //     return $this;
    // }

    // /**
    //  * Increase the quantity of the cart item.
    //  */
    // public function incrementQuantity($amount = 1)
    // {
    //     return $this->updateQuantity($this->quantity + $amount);
    // }

    // /**
    //  * Decrease the quantity of the cart item.
    //  */
    // public function decrementQuantity($amount = 1)
    // {
    //     return $this->updateQuantity($this->quantity - $amount);
    // }

    // /**
    //  * Get cart items for the current user or guest.
    //  */
    // public static function getCurrentCart()
    // {
    //     $user = Auth::user();

    //     if ($user) {
    //         return static::forUser($user)->with('product');
    //     }

    //     $cookieId = request()->cookie('cart_id');
    //     if ($cookieId) {
    //         return static::forCookie($cookieId)->with('product');
    //     }

    //     return collect();
    // }

    // /**
    //  * Get the total number of items in the current cart.
    //  */
    // public static function getCurrentCartCount()
    // {
    //     return static::getCurrentCart()->sum('quantity');
    // }

    // /**
    //  * Get the total price of the current cart.
    //  */
    // public static function getCurrentCartTotal()
    // {
    //     return static::getCurrentCart()->sum(function ($item) {
    //         return $item->total_price;
    //     });
    // }

    // /**
    //  * Clear the current cart.
    //  */
    // public static function clearCurrentCart()
    // {
    //     $user = Auth::user();

    //     if ($user) {
    //         static::forUser($user)->delete();
    //     } else {
    //         $cookieId = request()->cookie('cart_id');
    //         if ($cookieId) {
    //             static::forCookie($cookieId)->delete();
    //         }
    //     }
    // }
}
