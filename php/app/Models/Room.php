<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'Room';

    // Specify the primary key
    protected $primaryKey = 'room_id';

    // Specify the fillable fields
    protected $fillable = [
        'room_number',
        'location',
        'capacity',
        'equipment',
        'availability_status',
        'image',
        'admin_id',
        'room_type_id',
        'need_admin_approve',
    ];

    protected $appends = ['image_path'];

    // Relationships
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'room_id');
    }


    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'room_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function type()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }


    public function images()
    {
        return $this->hasMany(Image::class, 'room_id');
    }


    public function getDefImageAttribute(): string
    {
        return asset('def.png');
    }

    public $timestamps = false;
}
