<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{
    // Specify the table name
    protected $table = 'StatusCodes';

    // Optionally, specify the primary key if it's not the default 'id'
    protected $primaryKey = 'idStatusCodes';

    // If the table does not have the default timestamp columns
    public $timestamps = false;

    // Relationship to Jobs with this status code
    public function jobs()
    {
        return $this->hasMany(Job::class, 'Status');
    }

    // Relationship to historical job status changes
    public function jobStatuses()
    {
        return $this->hasMany(JobStatusEvent::class, 'StatusCode');
    }
}