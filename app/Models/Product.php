<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'expiry_date',
        'price',
        'quantity',
        'image',

        'contact_info',
        'user_id',
        'category',
        'discount_1',
        'date_1',
        'discount_2',
        'date_2',
        'discount_3',
        'date_3',
    ];
    protected $hidden = [

      'created_at',
      'updated_at',
      'discount_1',
      'date_1',
      'discount_2',
      'date_2',
      'discount_3',
      'date_3',
    ];

    public function user()
    {
      return $this->belongsTo(User::class);

    }
    // public function category()
    // {
    //   return $this->belongsTo(Category::class);

    // }
    public function comment()
    {
      return $this->hasMany(Comment::class);

    }
    public function view()
    {
      return $this->hasMany(View::class);

    }

    public function like()
    {

      return $this->hasMany(Like::class);

    }

}
