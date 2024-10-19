<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStatusEvent extends Model
{
    // Specify the table name
    protected $table = 'JobStatus';

    // Optionally, specify the primary key if it's not the default 'id'
    protected $primaryKey = 'idJobStatus';

    // If the table does not have the default timestamp columns
    public $timestamps = false;

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function jobStatus()
    {
        return $this->belongsTo(JobStatus::class);
    }
}