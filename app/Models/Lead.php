<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'lead_batch_id', 
        'name', 
        'phone', 
        'email'
    ];

    /**
     * The batch this lead belongs to.
     */
    public function batch(): BelongsTo
    {
        return $this->belongsTo(LeadBatch::class, 'lead_batch_id');
    }
}