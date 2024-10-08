<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
{
    $query = Task::query();
    if ($request->has('view')) {
        switch ($request->view) {
            case 'all':
                $query->whereIn('status', ['pending', 'in-progress']);
                break;
            case 'my':
                $query->where('user_id', auth()->id())
                      ->whereIn('status', ['pending', 'in-progress']);
                break;
            case 'completed':
                $query->where('status', 'completed');
                break;
            case 'missing':
                $query->where('date_fin', '<', now())
                      ->where('status', '!=', 'completed');
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

    if ($request->filled('user')) {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->user . '%');
        });
    }

    $query ->orderBy('date_fin', 'asc') 
           ->orderByRaw("FIELD(status, 'in-progress', 'completed', 'pending', 'missing')");


    $tasks = $query->get();

    return view('admin.dashboard', compact('tasks'));
}

   
}


