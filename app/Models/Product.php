<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'price',
        'compare_price',
        'options',
        'rating',
        'featured',
        'status',
    ];

    protected $appends = [
        'image_url',
        'discount_percentage',
        'is_new',
    ];
    protected static function booted()
    {
        // static::addGlobalScope('store', function (Builder $builder) {

        //     $user = Auth::user();
        //     if ($user->store_id) {
        //         $builder->where('store_id', '=', $user->store_id);
        //     }
        // });

        static::addGlobalScope('store', new StoreScope());
        static::creating(function (Product $product) {
            if (! $product->slug) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, //Related model
            'product_tag', // pivot table
            'product_id', // FK in pivot table in current table
            'tag_id', // FK in pivot table in related table
            'id', // PK for current model
            'id' //PK for related model
        );
    }
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active')->where('store_id', '=', Auth::user()->store_id);
    }

    //Accessor
    public function getImageUrlAttribute()
    {
        // if (! $this->image) {
        //     return 'https://static.thenounproject.com/png/default-image-icon-4974686-512.png';
        // }
        // if (Str::startsWith($this->image, ['http', 'https'])) {
        //     return $this->image;
        // }
        // return asset('storage/' . $this->image);
        return 'https://static.thenounproject.com/png/default-image-icon-4974686-512.png';
    }

    // Accessor for discount percentage
    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_price && $this->compare_price > $this->price && $this->price > 0) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100, 2);
        }
        return 0;
    }

    // Scope for new products
    public function scopeNew(Builder $query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Accessor to check if product is new
    public function getIsNewAttribute()
    {
        return $this->created_at && $this->created_at >= now()->subDays(7);
    }


    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active'
        ], $filters);

        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });

        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });

        $builder->when($options['tag_id'], function ($builder, $value) {
            $builder->whereExists(function ($query) use ($value) {
                $query->select(1)
                    ->from('product_tag')
                    ->whereRaw('product_id = products.id')
                    ->where('tag_id', $value);
            });
        });

        $builder->when($options['status'], function ($query, $status) {
            $query->where('status', $status);
        });
    }
}
