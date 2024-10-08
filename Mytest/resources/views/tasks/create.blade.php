@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Task</h2>

  
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Task Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Task Description (Optional)</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="date_debut" class="form-label">Start Date</label>
            <input type="date" name="date_debut" class="form-control" value="{{ old('date_debut') }}" required>
        </div>

        <div class="mb-3">
            <label for="date_fin" class="form-label">End Date</label>
            <input type="date" name="date_fin" class="form-control" value="{{ old('date_fin') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Create Task</button>
    </form>
</div>
@endsection
