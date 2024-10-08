@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Tasks</h2>

    
    <form method="GET" action="{{ route('tasks.index') }}">
        <div class="row">
            <div class="col-md-3">
                <input type="date" name="date_debut" class="form-control" placeholder="Start Date">
            </div>
            <div class="col-md-3">
                <input type="date" name="date_fin" class="form-control" placeholder="End Date">
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by Task Name">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>


    <table class="table mt-4">
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->date_debut }}</td>
                    <td>{{ $task->date_fin }}</td>
                    <td>{{ $task->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        @if (auth()->user()->role === 'admin')
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
