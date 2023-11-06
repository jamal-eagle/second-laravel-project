<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function product()
    {
      return $this->hasMany(Product::class);

    }
    use HasFactory;

    protected $fillable = ['name'];
    protected $hidden = [

      'created_at',
      'updated_at',
     
  ];
}
