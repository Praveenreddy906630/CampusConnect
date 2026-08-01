@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen text-center">
    <h1 class="text-3xl font-bold mb-4">Registrations Closed</h1>
    <p class="text-lg">Registrations are only open between 
        <strong>{{ \Carbon\Carbon::parse($settings->registration_start)->format('d M Y') }}</strong> 
        and 
        <strong>{{ \Carbon\Carbon::parse($settings->registration_end)->format('d M Y') }}</strong>.
    </p>
</div>
@endsection
