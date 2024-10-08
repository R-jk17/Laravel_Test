@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Task</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $task->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Task Description</label>
            <textarea name="description" class="form-control">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="date_debut" class="form-label">Start Date</label>
            <input type="date" name="date_debut" class="form-control" value="{{ old('date_debut', $task->date_debut) }}" required>
        </div>

        <div class="mb-3">
            <label for="date_fin" class="form-label">End Date</label>
            <input type="date" name="date_fin" class="form-control" value="{{ old('date_fin', $task->date_fin) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Task</button>
    </form>

    
</div>
@endsection
