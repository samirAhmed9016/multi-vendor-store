<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Store extends Model
{
    use HasFactory, Notifiable;
    protected $connection = 'mysql';
    protected $table = 'stores';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [];


    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }
}
