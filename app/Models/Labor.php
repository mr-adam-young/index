<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labor extends Model
{
    protected $table = 'LaborNew'; // Assuming this is the table name
    protected $primaryKey = 'LaborID'; // Assuming 'LaborID' is the primary key
    public $timestamps = false; // Since there are no created_at/updated_at fields

    protected $fillable = [
        'Hours', 
        'LaborTypeID', 
        'Timestamp', 
        'Date', 
        'EmployeeID', 
        'JobID', 
        'Migrated', 
        'description'
    ];
}