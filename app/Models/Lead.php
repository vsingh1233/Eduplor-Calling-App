<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

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
    /**
     * Automatically clean and format mixed phone number styles
     */
    protected function phone(): Attribute
    {
        return Attribute::make(
            get: function (?string $value) {
                if (!$value) {
                    return null;
                }

                // Count only the raw numbers to determine the true format length
                $digitsOnly = preg_replace('/[^0-9]/', '', $value);

                // Case 1: Pure 10-digit number (e.g., 9993608977)
                if (strlen($digitsOnly) === 10) {
                    return '+91-' . ltrim($value, ' ');
                }

                // Case 2: 12-digit country code number missing the plus (e.g., 91-9993608977 or 919993608977)
                if (strlen($digitsOnly) === 12 && !Str::startsWith($value, '+')) {
                    return '+' . ltrim($value, ' ');
                }

                // Case 3: Already perfectly formatted (e.g., +91-9993608977)
                return $value;
            }
        );
    }
}