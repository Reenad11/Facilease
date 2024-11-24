<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    // Specify the table name
    protected $table = 'reservation';

    // Specify the primary key
    protected $primaryKey = 'reservation_id';

    // Specify the fillable fields
    protected $fillable = [
        'faculty_id',
        'student_id',
        'room_id',
        'admin_id',
        'start_time',
        'end_time',
        'date',
        'status',
        'notest',
    ];

    // Relationships
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public $timestamps = false;
}
