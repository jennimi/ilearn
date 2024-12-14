<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Carbon\Carbon;

class Assignment extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentFactory> */
    use HasFactory;

    protected $casts = [
        'deadline' => 'datetime',
    ];
    
    protected $fillable = ['module_id', 'title', 'description', 'deadline'];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    // Salah
    public function submission(): HasMany
    {
        return $this->hasMany(Submission::class, 'assignment_id', 'id');
    }

    public function isDeadlinePassed()
    {
        return $this->deadline && Carbon::now()->greaterThan($this->deadline);
    }
}
