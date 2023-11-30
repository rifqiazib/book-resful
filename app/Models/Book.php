<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = [
        'title',
        'publisher',
        'publish_year',
        'language',
        'author_id'
    ];


    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
