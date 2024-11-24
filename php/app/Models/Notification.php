<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'Notification';

    // Specify the primary key
    protected $primaryKey = 'notification_id';

    // Specify the fillable fields
    protected $fillable = [
        'faculty_id',
        'message',
        'date_time',
        'status',
    ];


    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public $timestamps = false;

}
