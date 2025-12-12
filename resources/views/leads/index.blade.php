@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-4">Leads</h1>

    {{-- Filter + Search Form --}}
    <form method="GET" class="flex gap-3 mb-6 items-center">
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Search name, email, phone"
               class="border rounded p-2 w-60">

        <select name="status" class="border rounded p-2">
            <option value="">Status</option>
            <option value="New" {{ request('status')=='New' ? 'selected':'' }}>New</option>
            <option value="In-Progress" {{ request('status')=='In-Progress' ? 'selected':'' }}>In-Progress</option>
            <option value="Closed" {{ request('status')=='Closed' ? 'selected':'' }}>Closed</option>
        </select>

        <select name="source" class="border rounded p-2">
            <option value="">Source</option>
            <option value="Facebook" {{ request('source')=='Facebook' ? 'selected':'' }}>Facebook</option>
            <option value="Google" {{ request('source')=='Google' ? 'selected':'' }}>Google</option>
            <option value="Referral" {{ request('source')=='Referral' ? 'selected':'' }}>Referral</option>
            <option value="Website" {{ request('source')=='Website' ? 'selected':'' }}>Website</option>
        </select>

        <select name="assigned_to" class="border rounded p-2">
            <option value="">Assigned To</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}" {{ (string)request('assigned_to')== (string)$u->id ? 'selected':'' }}>
                    {{ $u->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>

        <a href="{{ route('leads.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">
            + Add Lead
        </a>
    </form>

    {{-- Leads Table --}}
    <div class="overflow-x-auto">
    <table class="w-full border text-left">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Phone</th>
                <th class="p-3">Source</th>
                <th class="p-3">Status</th>
                <th class="p-3">Assigned To</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($leads as $lead)
            <tr class="border-b">
                <td class="p-3">{{ $lead->name }}</td>
                <td class="p-3">{{ $lead->email }}</td>
                <td class="p-3">{{ $lead->phone }}</td>
                <td class="p-3">{{ $lead->source }}</td>
                <td class="p-3">
                    @if($lead->status == 'New')
                        <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">{{ $lead->status }}</span>
                    @elseif($lead->status == 'In-Progress')
                        <span class="px-2 py-1 rounded bg-blue-100 text-blue-800">{{ $lead->status }}</span>
                    @elseif($lead->status == 'Closed')
                        <span class="px-2 py-1 rounded bg-green-100 text-green-800">{{ $lead->status }}</span>
                    @else
                        <span class="px-2 py-1 rounded bg-gray-100 text-gray-800">{{ $lead->status }}</span>
                    @endif
                </td>
                <td class="p-3">{{ $lead->assignedUser->name ?? 'Unassigned' }}</td>

                <td class="p-3 flex gap-3 items-center">

                    {{-- View Button (everyone with access) --}}
                    <a href="{{ route('leads.show', $lead) }}" class="text-blue-600 font-medium">
                        View
                    </a>

                    {{-- Edit Button: Admin OR assigned counsellor --}}
                    @if(auth()->user()->hasRole('Admin') || $lead->assigned_to == auth()->id())
                        <a href="{{ route('leads.edit', $lead) }}" class="text-green-600 font-medium">
                            Edit
                        </a>
                    @endif

                    {{-- Delete Button: Admin only --}}
                    @role('Admin')
                        <form action="{{ route('leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this lead?');" class="inline-block m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 font-medium">
                                Delete
                            </button>
                        </form>
                    @endrole

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="p-4 text-center text-gray-600">No leads found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="mt-4">
        {{ $leads->links() }}
    </div>

</div>
@endsection
