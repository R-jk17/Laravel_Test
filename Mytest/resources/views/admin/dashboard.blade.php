@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4"> Task Manager </h2>

    <!-- Navbar for Admin -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}?view=all">All Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}?view=my">My Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}?view=completed">Completed Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}?view=missing">Missing Tasks</a>
                </li>
            </ul>
        </div>
    </nav>

   
    <form action="{{ route('admin.dashboard') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="name" class="form-control" placeholder="Task Title" value="{{ request('name') }}">
            <input type="date" name="date_debut" class="form-control" placeholder="Start Date" value="{{ request('date_debut') }}">
            <input type="date" name="date_fin" class="form-control" placeholder="End Date" value="{{ request('date_fin') }}">
            <input type="text" name="user" class="form-control" placeholder="Created By" value="{{ request('user') }}">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Clear All</a>
        </div>
    </form>

    
    <a href="{{ route('tasks.create') }}" class="btn btn-success mb-4">Create Task</a>


    <style>
    .table th {
        font-weight: bold;
        background-color: #f8f9fa;
    }
    .status-badge {
        display: inline-block;
        padding: 0.25em 0.6em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
        color: white;
    }
    .status-missing { background-color: #dc3545; }
    .status-in-progress { background-color: #0d6efd; }
    .status-completed { background-color: #198754; }
    .status-pending { background-color: #ffc107; color: black; }
</style>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Task Name</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
            @php
                $rowClass = match ($task->status) {
                    'in-progress' => 'table-primary',
                    'completed' => 'table-success',
                    'pending' => 'table-warning',
                    'missing' => 'table-danger',
                    default => '',
                };
                
                $statusClass = match ($task->status) {
                    'in-progress' => 'status-in-progress',
                    'completed' => 'status-completed',
                    'pending' => 'status-pending',
                    'missing' => 'status-missing',
                    default => '',
                };
                
                $statusText = match ($task->status) {
                    'in-progress' => 'In Progress',
                    'completed' => 'Completed',
                    'pending' => 'Pending',
                    'missing' => 'Missing',
                    default => 'Unknown',
                };
            @endphp

            <tr class="{{ $rowClass }}">
                <td class="font-weight-bold">{{ $task->name }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->date_debut }}</td>
                <td>{{ $task->date_fin }}</td>
                <td>
                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                </td>
                <td>
                    @if ($task->status != 'completed' && $task->status != 'missing')
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary font-weight-bold">Edit Task</a>
                    @endif
                    @if ($task->status == 'in-progress')
                        <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success font-weight-bold">Mark as Completed</button>
                        </form>
                    @endif
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger font-weight-bold" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
