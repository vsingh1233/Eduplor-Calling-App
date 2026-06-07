<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeadBatch extends Model
{
    protected $fillable = [
        'user_id', 
        'uploader_id', 
        'name'
    ];

    /**
     * The Caller assigned to this batch.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The Admin or Caller who performed the upload.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    /**
     * The leads belonging to this batch.
     */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }
}