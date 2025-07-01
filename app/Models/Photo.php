<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $primaryKey = 'photo_id';
    protected $fillable = [
        'photo_title',
        'photo_description',
        'photo_url',
        'photo_status',
    ];

    public function rphotos()
    {
       return $this->hasMany(Rphoto::class,'photo_id','photo_id');
    }
}
