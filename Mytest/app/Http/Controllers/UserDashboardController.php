<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;

class UserDashboardController extends Controller
{
    public function index(Request $request)
{
    $query = Task::where('user_id', auth()->id())
                 ->where('date_fin', '>=', now());

     if ($request->has('filter')) {
        switch ($request->filter) {
            case 'my-tasks':
                $query->whereIn('status', ['pending', 'in-progress']);
            break;
            case 'completed':
                $query->where('status', 'completed');
            break;
            case 'missing-tasks':
                $query->where('status', 'missing');
            break;
        }
    }

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('date_debut')) {
        $query->whereDate('date_debut', $request->date_debut);
    }

    if ($request->filled('date_fin')) {
        $query->whereDate('date_fin', $request->date_fin);
    }

    $query ->orderBy('date_fin', 'asc') 
           ->orderByRaw("FIELD(status, 'in-progress', 'completed', 'pending', 'missing')");


    $tasks = $query->get();

    return view('user.dashboard', compact('tasks'));
}

}

