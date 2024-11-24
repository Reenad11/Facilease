<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Faculty extends Authenticatable
{
    // Specify the table name
    protected $table = 'faculty';

    // Specify the primary key
    protected $primaryKey = 'faculty_id';

    // Specify the fillable fields
    protected $fillable = [
        'fullname', // Full name of the faculty member
        'EXT',
        'email',
        'password',
        'department',
    ];
    // Constants for faculty names
    public const FACULTY_NAMES = [
        'Engineering & Computer Science',
        'Electrical Engineering',
        'Mechanical Engineering',
        'Civil Engineering',
        'Business Administration',
        'Information Technology',
        'Chemical Engineering',
        'Architecture',
        'Mathematics',
        'Physics',
        'Chemistry',
        'Biology',
        'Environmental Science',
        'Economics',
        'Psychology',
        'Sociology',
        'Human Resources',
        'Finance',
        'Accounting',
        'Marketing',
        'Management',
    ];

    public const DEPARTMENTS = [
        'Engineering & Computer Science',
        'Electrical Engineering',
        'Mechanical Engineering',
        'Civil Engineering',
        'Business Administration',
        'Information Technology',
        'Chemical Engineering',
        'Architecture',
        'Mathematics',
        'Physics',
        'Chemistry',
        'Biology',
        'Environmental Science',
        'Economics',
        'Psychology',
        'Sociology',
        'Human Resources',
        'Finance',
        'Accounting',
        'Marketing',
        'Management',
    ];
    public const POSITIONS = [
        'Professor',
        'Associate Professor',
        'Assistant Professor',
        'Lecturer',
        'Researcher',
        'Instructor',
        'Teaching Assistant',
    ];
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'faculty_id');
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'faculty_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'faculty_id');
    }

    public $timestamps = false;

}
