<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Author;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'price',
        'isbn',
        'year'
    ];

    public function author(){
        return $this->belongsTo(Author::class);
    }
}
