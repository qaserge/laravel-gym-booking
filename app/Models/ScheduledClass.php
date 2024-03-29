<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledClass extends Model
{
    use HasFactory;

    protected $guarded = null; //When $guarded is set to null, it means that all attributes can be bulk filled.

    protected $casts = [ //The $casts property in Laravel is used to define the data types of model attributes when retrieving them from the database and saving them to the database.
        'date_time' => 'datetime'
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function classType()
    {
        return $this->belongsTo(ClassType::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'bookings');
    }

    public function scopeUpcoming(Builder $query)
    {
        return $query->where('date_time', '>', now());
    }

    public function scopeNotBooked(Builder $query)
    {
        return $query->whereDoesntHave('members', function ($query) {
            $query->where('user_id', auth()->user()->id);
        });
    }
}
