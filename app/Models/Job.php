<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    // Specify the table name
    protected $table = 'Jobs';

    // Optionally, specify the primary key if it's not the default 'id'
    protected $primaryKey = 'ID';

    // If your primary key is not auto-incrementing
    // public $incrementing = false;

    // If your primary key is not an integer
    protected $keyType = 'string';

    // If the table does not have the default timestamp columns
    public $timestamps = false;

    // Scope to get only active jobs
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
