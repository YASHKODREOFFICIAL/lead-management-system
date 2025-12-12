@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Lead</h1>

    <form method="POST" action="{{ route('leads.update', $lead) }}" class="space-y-4">
        @csrf
        @method("PUT")

        <input name="name" value="{{ $lead->name }}" class="border p-2 w-full rounded" required>

        <input name="email" value="{{ $lead->email }}" class="border p-2 w-full rounded" required>

        <input name="phone" value="{{ $lead->phone }}" class="border p-2 w-full rounded">

        <select name="source" class="border p-2 w-full rounded">
            <option {{ $lead->source=='Facebook'?'selected':'' }}>Facebook</option>
            <option {{ $lead->source=='Google'?'selected':'' }}>Google</option>
            <option {{ $lead->source=='Referral'?'selected':'' }}>Referral</option>
            <option {{ $lead->source=='Website'?'selected':'' }}>Website</option>
        </select>

<select name="status" class="border p-2 w-full rounded" required>
    <option value="New" {{ $lead->status == 'New' ? 'selected' : '' }}>New</option>
    <option value="In-Progress" {{ $lead->status == 'In-Progress' ? 'selected' : '' }}>In-Progress</option>
    <option value="Closed" {{ $lead->status == 'Closed' ? 'selected' : '' }}>Closed</option>
</select>


@role('Admin')
<div>
    <label class="block font-medium mb-1">Assign To</label>
    <select name="assigned_to" class="border p-2 w-full rounded">
        <option value="">Unassigned</option>
        @foreach($users as $u)
            <option value="{{ $u->id }}" {{ $lead->assigned_to == $u->id ? 'selected' : '' }}>
                {{ $u->name }}
            </option>
        @endforeach
    </select>
</div>
@endrole


        <button class="bg-blue-600 text-white px-4 py-2 rounded">Update Lead</button>
    </form>
</div>
@endsection
