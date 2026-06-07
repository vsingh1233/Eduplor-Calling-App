<?php

namespace App\Http\Controllers;

use App\Imports\LeadsImport;
use App\Models\LeadBatch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class LeadBatchController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $batches = LeadBatch::with(['user', 'uploader'])->latest()->get();
            $callers = User::where('role', 'caller')->get();
        } else {
            $batches = LeadBatch::where('user_id', $user->id)->latest()->get();
            $callers = collect([$user]); // Callers can only assign data to themselves
        }

        return view('batches.index', compact('batches', 'callers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
            'user_id' => 'required|exists:users,id',
        ]);

        $uploader = auth()->user();
        $targetUser = User::findOrFail($request->user_id);

        // Security check: Callers can only upload data for themselves
        if ($uploader->isCaller() && $uploader->id !== $targetUser->id) {
            abort(403, 'You can only upload data for yourself.');
        }

        // Custom Batch Naming Logic with suffix for collisions
        $baseName = Str::slug($targetUser->name) . '-' . now()->format('Y-m-d');
        $batchName = $baseName;
        $counter = 2;

        while (LeadBatch::where('user_id', $targetUser->id)->where('name', $batchName)->exists()) {
            $batchName = $baseName . '-' . $counter;
            $counter++;
        }

        // Use a transaction so if the Excel import fails, the batch is removed
        DB::beginTransaction();

        try {
            $batch = LeadBatch::create([
                'user_id' => $targetUser->id,
                'uploader_id' => $uploader->id,
                'name' => $batchName,
            ]);

            Excel::import(new LeadsImport($batch->id), $request->file('file'));
            
            DB::commit();
            return back()->with('status', 'Leads uploaded successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['file' => 'Upload failed. Check if name, phone, and email columns exist. Error: ' . $e->getMessage()]);
        }
    }

    public function show(LeadBatch $batch)
    {
        // Authorization check: Callers cannot peek at other callers' batches
        if (auth()->user()->isCaller() && auth()->user()->id !== $batch->user_id) {
            abort(403, 'Unauthorized access to this batch.');
        }

        $leads = $batch->leads()->get();
        return view('batches.show', compact('batch', 'leads'));
    }
}