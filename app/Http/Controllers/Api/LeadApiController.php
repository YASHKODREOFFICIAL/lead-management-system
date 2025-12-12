<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadHistory;
use Illuminate\Validation\Rule;

class LeadApiController extends Controller
{


    /**
     * Create Lead via API
     * POST /api/leads/create
     */
    public function store(Request $request)
    {
        // Validate API input
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'phone'  => 'nullable|string|max:20',
            'email'  => 'required|email|unique:leads,email',
            'source' => ['required', Rule::in(['Facebook','Google','Referral','Website'])],
            'status' => ['nullable', Rule::in(['New','In-Progress','Closed'])],
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        // Default status
        $validated['status'] = $validated['status'] ?? 'New';

        // If user is not Admin → they cannot assign leads
        if (!$request->user()->hasRole('Admin')) {
            $validated['assigned_to'] = null;
        }

        // Create Lead
        $lead = Lead::create($validated);

        // Create Lead History log
        LeadHistory::create([
            'lead_id' => $lead->id,
            'previous_status' => null,
            'new_status' => $lead->status,
            'previous_assigned_user' => null,
            'new_assigned_user' => $lead->assigned_to,
            'changed_by' => $request->user()->id,
            'created_at' => now(),
        ]);

        // Return successful JSON
        return response()->json([
            'success' => true,
            'lead_id' => $lead->id,
            'message' => 'Lead created successfully'
        ], 201);
    }
}
