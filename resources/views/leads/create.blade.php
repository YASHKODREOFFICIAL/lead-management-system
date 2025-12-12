@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Create Lead</h1>

    <form method="POST" action="{{ route('leads.store') }}" class="space-y-4">
        @csrf

        <input 
            name="name" 
            class="border p-2 w-full rounded" 
            placeholder="Name" 
            required
        >

        <input 
            name="email" 
            class="border p-2 w-full rounded" 
            placeholder="Email" 
            required
        >

        <input 
            name="phone" 
            class="border p-2 w-full rounded" 
            placeholder="Phone"
        >

        <select name="source" class="border p-2 w-full rounded" required>
            <option value="">Select Source</option>
            <option value="Facebook">Facebook</option>
            <option value="Google">Google</option>
            <option value="Referral">Referral</option>
            <option value="Website">Website</option>
        </select>

        {{-- FIXED STATUS DROPDOWN (only valid ENUM values allowed) --}}
<select name="status" class="border p-2 w-full rounded" required>
    <option value="New">New</option>
    <option value="In-Progress">In-Progress</option>
    <option value="Closed">Closed</option>
</select>



        {{-- Admin can assign leads --}}
        @role('Admin')
        <select name="assigned_to" class="border p-2 w-full rounded">
            <option value="">Assign To</option>
            @foreach($users as $u)
            <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
        </select>
        @endrole

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Create Lead
        </button>
    </form>
</div>
@endsection
