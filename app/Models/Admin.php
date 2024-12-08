<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function delegate(): HasMany
    {
        return $this->hasMany(Teacher::class, 'admin_id', 'id');
    }

    public function assign(): HasMany
    {
        return $this->hasMany(Student::class, 'admin_id', 'id');
    }

    public function creates(): HasMany
    {
        return $this->hasMany(Classroom::class, 'admin_id', 'id');
    }
}
