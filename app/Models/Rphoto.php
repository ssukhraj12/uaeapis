<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rphoto extends Model
{
    use HasFactory;
    protected $primaryKey = 'rphoto_id';
    protected $fillable = [
        'rphoto_url',
        'photo_id',
    ];
}
