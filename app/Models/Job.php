<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'Jobs';
    protected $primaryKey = 'ID';
    protected $keyType = 'string';
    public $timestamps = false;

    // Relationship to get the current status code details
    public function status()
    {
        return $this->hasOne(JobStatus::class, 'status_code');
    }

    // Relationship to get the history of status changes
    public function statusHistory()
    {
        return $this->hasMany(JobStatusEvent::class, 'StatusJobID');
    }

    // Scope to get only active jobs
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeInProduction($query)
    {
        return $query->where('status', '>=', 25);
    }
}
