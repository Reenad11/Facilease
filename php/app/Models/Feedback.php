<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'feedback';

    // Specify the primary key
    protected $primaryKey = 'feedback_id';

    // Specify the fillable fields
    protected $fillable = [
        'faculty_id',
        'student_id',
        'room_id',
        'rating',
        'feedback_text',
        'date_time',
    ];

    // Relationships
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public $timestamps = false;

}
