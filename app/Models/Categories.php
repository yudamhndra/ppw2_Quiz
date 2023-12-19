<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['name', 'book_id'];

    public function book()
    {
        return $this->belongsTo(Buku::class);
    }
}
