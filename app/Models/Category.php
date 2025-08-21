<?php

namespace App\Models;

use App\Rules\FilterRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'image',
        'status',
        'slug'
    ];
    protected $guarded = [
        'id'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')
            ->withDefault([
                'name' => '-'
            ]);
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }







    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }








    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    public function scopeStatus(Builder $builder, $status)
    {
        $builder->where('status', '=', $status);
    }
    public function scopeFilter(Builder $builder, $filters)
    {

        $builder->when($filters['name'] ?? false, function ($builder, $value) {

            $builder->where('name', 'LIKE', "%{$value}%");
        });
        $builder->when($filters['status'] ?? false, function ($builder, $value) {

            $builder->whereStatus($value);
        });

        // if ($filters['name'] ?? false) {

        //     $builder->where('name', 'LIKE', "%{$filters['name']}%");
        // }
        // if ($filters['status'] ?? false) {
        //     $builder->whereStatus($filters['status']);
        // }
    }



    public static function rules()
    {
        return [
            'name' => [
                new FilterRule(),
                'required',
                'string',
                'max:255',
                // function ($attribute, $value, $fails) {
                //     if ($value == 'samir') {
                //         $fails('forbidden');
                //     }
                // }
            ],
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,archived',
            'image' => 'nullable',
        ];
    }

    public static function messages()
    {
        return  [
            'name.required' => 'The name field is required samir.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least 3 characters.',
            'name.max' => 'The name must not be greater than 255 characters.',
            'parent_id.int' => 'The parent id must be an integer.',
            'parent_id.exists' => 'The parent id must exist in the categories table.',
            'description.string' => 'The description must be a string.',
            'image.image' => 'The image must be an image.',
            'status.in' => 'The status must be active or archived.',
        ];
    }

    // protected function upload_file(Request $request)
    // {
    //     if ($request->hasFile('image')) {
    //         return;
    //     }
    //     $file = $request->file('image');
    //     $imagePath = $file->store('uploads', 'public');
    //     return $imagePath;
    // }
}
