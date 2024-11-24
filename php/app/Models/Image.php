<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'Image';

    // Specify the fillable fields
    protected $fillable = [
        'room_id',
        'image_url',
    ];

    // Define the relationship with the Room model
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }


    public $timestamps = false;

}
