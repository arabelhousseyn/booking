<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, UUID;


    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'full_name',
        'username',
        'email',
        'password',
    ];


    /**
     * hidden attributes
     */
    protected $hidden = [
        'password',
    ];


    /**
     * cast attributes
     */
    protected $casts = [];

    /**
     * relationships
     */


    /**
     * functions
     */
}
