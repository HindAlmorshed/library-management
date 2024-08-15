<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrowing_Record extends Model
{
    use HasFactory;

    protected $table = 'borrowing_record';
    protected $guarded = [];


    public function book(): BelongsTo
    {
      return $this->belongsTo(Book::class, 'book_id');
    }

    public function patron(): BelongsTo
    {
      return $this->belongsTo(Patron::class, 'patron_id');
    }

}
