@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h2>Task ID {{ $task->id }}</h2>
                <div class="card-heading mb-2">
                    <h2 class="">Name:</h2>
                    <p type="text" name="name" class="form-group" disabled>{{ $task->name }}</p>
                </div><div class="card-heading mb-2">
                <h2 class="">Content:</h2>
                    <p type="text" name="name" class="form-group" disabled>{{ $task->content }}</p>
                </div>

        </div>
    </div>
@endsection
@extends('layouts.app')

