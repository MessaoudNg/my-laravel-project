<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 🟢 حدد الأعمدة المسموح بتعبئتها
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];
}
