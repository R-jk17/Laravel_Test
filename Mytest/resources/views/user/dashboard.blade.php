@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4"> Task Manager </h2>

 
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <a class="navbar-brand" href="{{ route('user.dashboard') }}">User Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.dashboard') }}?filter=my-tasks">My Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.dashboard') }}?filter=completed">Achieved Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.dashboard') }}?filter=missing-tasks">Missing Tasks</a>
                </li>
            </ul>
        </div>
    </nav>


    <form action="{{ route('user.dashboard') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="name" class="form-control" placeholder="Task Title" value="{{ request('name') }}">
            <input type="date" name="date_debut" class="form-control" placeholder="Start Date" value="{{ request('date_debut') }}">
            <input type="date" name="date_fin" class="form-control" placeholder="End Date" value="{{ request('date_fin') }}">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Clear All</a>
        </div>
    </form>


    <a href="{{ route('tasks.create') }}" class="btn btn-success mb-4">Create Task</a>


    <div class="row">
        @foreach ($tasks as $task)
            @php
                // Use the status from the database
                $status = $task->status; 

                // Set card color based on status
                $cardColor = match ($status) {
                    'pending' => 'bg-warning',
                    'in-progress' => 'bg-primary',
                    'completed' => 'bg-success',
                    'missing' => 'bg-danger',
                    default => 'bg-secondary',
                };
            @endphp

            <div class="col-md-4">
                <div class="card {{ $cardColor }} mb-4 text-white">
                    <div class="card-body">
                        <h5 class="card-title">{{ $task->name }}</h5>
                        <p class="card-text">{{ $task->description }}</p>
                        <p><strong>Start Date:</strong> {{ $task->date_debut }}</p>
                        <p><strong>End Date:</strong> {{ $task->date_fin }}</p>
                        <p><strong>Status:</strong> 
                            @if ($status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif ($status == 'in-progress')
                                <span class="badge badge-primary">In Progress</span>
                            @elseif ($status == 'completed')
                                <span class="badge badge-success">Completed</span>
                            @else
                                <span class="badge badge-danger">Missing</span>
                            @endif
                        </p>
                        
                        @if ($status != 'completed' && $status != 'missing')
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-light">Edit Task</a>
                        @endif
                        @if ($status == 'in-progress')
                        <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">Mark as Completed</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($tasks->isEmpty())
        <p>No tasks available.</p>
    @endif
</div>
@endsection
