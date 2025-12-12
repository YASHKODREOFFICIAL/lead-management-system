<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\LeadHistory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;

class LeadController extends Controller
{


    // ---------------------------------------
    // LIST / FILTER / SEARCH LEADS
    // ---------------------------------------
    public function index(Request $request)
    {
        $query = Lead::query()->with('assignedUser');

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Search by name, email or phone
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }

        // Counsellor can ONLY see leads assigned to them
        if (Auth::user()->hasRole('Counsellor')) {
            $query->where('assigned_to', Auth::id());
        }

        $leads = $query->orderBy('created_at', 'desc')->paginate(10);
        $users = User::role('Counsellor')->get();

        return view('leads.index', compact('leads', 'users'));
    }

    // ---------------------------------------
    // CREATE FORM
    // ---------------------------------------
    public function create()
    {
        $users = User::role('Counsellor')->get();
        return view('leads.create', compact('users'));
    }

    // ---------------------------------------
    // STORE LEAD
    // ---------------------------------------
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'phone'  => 'nullable|string|max:20',
            'email'  => 'required|email|unique:leads,email',
            'source' => ['required', Rule::in(['Facebook','Google','Referral','Website'])],
            'status' => ['required', Rule::in(['New','In-Progress','Closed'])],
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        // Counsellor cannot assign leads
        if (Auth::user()->hasRole('Counsellor')) {
            $data['assigned_to'] = null;
        }

        $lead = Lead::create($data);

        // Create history entry
        LeadHistory::create([
            'lead_id' => $lead->id,
            'previous_status' => null,
            'new_status' => $lead->status,
            'previous_assigned_user' => null,
            'new_assigned_user' => $lead->assigned_to,
            'changed_by' => Auth::id(),
            'created_at' => now()
        ]);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    // ---------------------------------------
    // SHOW LEAD + HISTORY
    // ---------------------------------------
    public function show(Lead $lead)
    {
        // Counsellor can only view their assigned leads
        if (Auth::user()->hasRole('Counsellor') && $lead->assigned_to !== Auth::id()) {
            abort(403);
        }

        $lead->load('assignedUser', 'histories');

        return view('leads.show', compact('lead'));
    }

    // ---------------------------------------
    // EDIT FORM
    // ---------------------------------------
    public function edit(Lead $lead)
    {
        // Counsellor can only edit leads assigned to them
        if (Auth::user()->hasRole('Counsellor') && $lead->assigned_to !== Auth::id()) {
            abort(403);
        }

        $users = User::role('Counsellor')->get();

        return view('leads.edit', compact('lead', 'users'));
    }

    // ---------------------------------------
    // UPDATE LEAD + LOG HISTORY
    // ---------------------------------------
    // public function update(Request $request, Lead $lead)
    // {
    //     $data = $request->validate([
    //         'name'   => 'required|string|max:255',
    //         'phone'  => 'nullable|string|max:20',
    //         'email'  => ['required','email', Rule::unique('leads')->ignore($lead->id)],
    //         'source' => ['required', Rule::in(['Facebook','Google','Referral','Website'])],
    //         'status' => ['required', Rule::in(['New','In-Progress','Closed'])],
    //         'assigned_to' => 'nullable|exists:users,id',
    //     ]);

    //     $previous_status = $lead->status;
    //     $previous_assigned = $lead->assigned_to;

    //     // Counsellor CANNOT reassign leads
    //     if (Auth::user()->hasRole('Counsellor')) {
    //         $data['assigned_to'] = $lead->assigned_to;
    //     }

    //     $lead->update($data);

    //     // Log history if something changed
    //     if ($previous_status !== $lead->status || $previous_assigned !== $lead->assigned_to) {
    //         LeadHistory::create([
    //             'lead_id' => $lead->id,
    //             'previous_status' => $previous_status,
    //             'new_status' => $lead->status,
    //             'previous_assigned_user' => $previous_assigned,
    //             'new_assigned_user' => $lead->assigned_to,
    //             'changed_by' => Auth::id(),
    //             'created_at' => now()
    //         ]);
    //     }

    //     return redirect()->route('leads.show', $lead)->with('success', 'Lead updated successfully.');
    // }





public function update(Request $request, Lead $lead)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:leads,email,' . $lead->id,
        'phone' => 'nullable|string|max:20',
        'source' => ['required', Rule::in(['Facebook','Google','Referral','Website'])],
        'status' => ['required', Rule::in(['New','In-Progress','Closed'])],
        'assigned_to' => 'nullable|exists:users,id',
    ]);

    $oldStatus = $lead->status;
    $oldAssignedUser = $lead->assigned_to;

    $lead->update($validated);

    // History log (optional, keep your existing logic)
    
    return redirect()
        ->route('leads.index')
        ->with('success', 'Lead updated successfully!');
}

    // ---------------------------------------
    // DELETE LEAD
    // ---------------------------------------
    public function destroy(Lead $lead)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403);
        }

        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }
}
