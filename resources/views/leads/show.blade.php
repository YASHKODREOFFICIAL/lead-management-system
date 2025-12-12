@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-4">{{ $lead->name }}</h1>

    <p><strong>Email:</strong> {{ $lead->email }}</p>
    <p><strong>Phone:</strong> {{ $lead->phone }}</p>
    <p><strong>Source:</strong> {{ $lead->source }}</p>
    <p><strong>Status:</strong> {{ $lead->status }}</p>
    <p><strong>Assigned To:</strong> {{ $lead->assignedUser->name ?? 'Unassigned' }}</p>

    <a href="{{ route('leads.edit', $lead) }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded inline-block mt-4">
        Edit Lead
    </a>

    <h2 class="text-xl font-semibold mt-8 mb-3">History</h2>

    <div class="space-y-4">
        @foreach($lead->histories as $history)
        <div class="border p-4 rounded bg-gray-50">
            <p><strong>Changed At:</strong> {{ $history->created_at }}</p>
            <p><strong>Status:</strong> {{ $history->previous_status ?? '-' }} → {{ $history->new_status }}</p>
            <p>
                <strong>Assigned:</strong>
                {{ optional(\App\Models\User::find($history->previous_assigned_user))->name ?? '-' }}
                →
                {{ optional(\App\Models\User::find($history->new_assigned_user))->name ?? '-' }}
            </p>
        </div>
        @endforeach
    </div>

</div>
@endsection
