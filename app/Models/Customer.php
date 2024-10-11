<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'reference', 'category_id', 'start_date', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
