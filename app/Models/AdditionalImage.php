<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalImage extends Model
{
    use HasFactory;

    protected $fillable = ['image_id', 'additional_caption', 'additional_image_path'];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
