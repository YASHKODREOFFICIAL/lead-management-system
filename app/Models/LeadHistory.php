<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadHistory extends Model
{
    public $timestamps = false;   // <-- IMPORTANT

    protected $fillable = [
        'lead_id',
        'previous_status',
        'new_status',
        'previous_assigned_user',
        'new_assigned_user',
        'changed_by',
        'created_at'
    ];
}
