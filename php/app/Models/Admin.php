<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';

    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'fullname',
        'id_number',
        'EXT',
        'email',
        'password',
    ];

    // Relationships
    public function rooms()
    {
        return $this->hasMany(Room::class, 'admin_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'admin_id');
    }
    public $timestamps = false;

}
