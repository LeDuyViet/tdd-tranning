@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h2>Update task</h2>
            <form action="{{ route('task.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-heading mb-2">
                    <input type="text" name="name" placeholder="Name..." class="form-group" value="{{ $task->name }}">
                </div>
                @error('name')
                    <span class="error text-danger" style="display: block">{{ $message }}</span>
                @enderror
                <div class="card-heading mb-2">
                    <input type="text" name="content" placeholder="Content..." class="form-group" value="{{ $task->content }}">
                </div>
                @error('content')
                <span class="error text-danger " style="display: block">{{ $message }}</span>
                @enderror
                <button class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
@endsection
@extends('layouts.app')

