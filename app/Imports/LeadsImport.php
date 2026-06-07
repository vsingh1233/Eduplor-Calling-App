<?php

namespace App\Imports;

use App\Models\Lead;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeadsImport implements ToCollection, WithHeadingRow
{
    protected $batchId;

    public function __construct($batchId)
    {
        $this->batchId = $batchId;
    }

    public function collection(Collection $rows)
    {
        // Validate that the required columns exist in the uploaded file
        Validator::make($rows->toArray(), [
            '*.name' => 'required|string',
            '*.phone' => 'required|string',
            '*.email' => 'required|email',
        ], [
            '*.name.required' => 'The name column is missing or empty in one or more rows.',
            '*.phone.required' => 'The phone column is missing or empty in one or more rows.',
            '*.email.required' => 'The email column is missing or empty in one or more rows.',
        ])->validate();

        // Extract only the required columns, ignoring any extra columns
        foreach ($rows as $row) {
            Lead::create([
                'lead_batch_id' => $this->batchId,
                'name'          => $row['name'],
                'phone'         => $row['phone'],
                'email'         => $row['email'],
            ]);
        }
    }
}