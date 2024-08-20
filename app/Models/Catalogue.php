<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;
    protected $fillable = [
        'catalogue_name',
        'catalogue_file_url',
        'catalogue_pic_url',
        'store_id',
        'is_public',
        'starting_period',
        'ending_period'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
