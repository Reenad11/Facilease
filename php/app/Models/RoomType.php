<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $table = 'roomtype';

    protected $primaryKey = 'room_type_id';

    protected $fillable = [
        'type_name',
        'admin_id',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_type_id');
    }
    public $timestamps = false;

}
