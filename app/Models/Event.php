<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
    'title',
    'description',
    'event_date',
    'end_time',
    'location',
    'capacity',
    'status',
    'user_id',
    'space_id',
    'image',
];
public function waitlists()
{
    return $this->hasMany(Waitlist::class);
}

public function registrations()
{
    return $this->hasMany(Registration::class);
}
public function categories()
{
    return $this->belongsToMany(Category::class);
}
public function space()
{
    return $this->belongsTo(Space::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
public function attendances()
{
    return $this->hasMany(Attendance::class);
}
}


