<?php



namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{


public function create()
{
    return view('tasks.create');
}


public function store(Request $request)
{

    $request->validate([
        'name' => 'required|string|max:20',
        'description' => 'nullable|string',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
    ]);

    // Determine the status of the task
    $currentDate = now();
    $status = 'pending'; 

    if ($request->date_fin < $currentDate) {
        $status = 'missing'; 
    } elseif ($request->date_debut > $currentDate) {
        $status = 'pending'; 
    } else {
        $status = 'in-progress';
    }

 
    Task::create([
        'name' => $request->name,
        'description' => $request->description,
        'date_debut' => $request->date_debut,
        'date_fin' => $request->date_fin,
        'user_id' => auth()->id(), 
        'status' => $status, 
    ]);


    return redirect()->route(auth()->user()->role == 'admin' ? 'admin.dashboard' : 'user.dashboard')
                     ->with('success', 'Task created successfully.');
}


public function edit(Task $task)
{
    
    return view('tasks.edit', compact('task'));
}


public function update(Request $request, Task $task)
{
    
    $request->validate([
        'name' => 'required|string|max:20',
        'description' => 'nullable|string',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
    ]);

    // Determine the status of the task
    $currentDate = now();
    $status = 'pending'; 

    if ($request->date_fin < $currentDate) {
        $status = 'missing'; 
    } elseif ($request->date_debut > $currentDate) {
        $status = 'pending'; 
    } else {
        $status = 'in-progress';
    }

    $task->update([
        'name' => $request->name,
        'description' => $request->description,
        'date_debut' => $request->date_debut,
        'date_fin' => $request->date_fin,
        'status' => $status,
    ]);

    // Get the user's role and construct the route name dynamically
    $role = auth()->user()->role; // Get the user's role
    return redirect()->route("{$role}.dashboard") // Use the role to build the route name
                     ->with('success', 'Task edited successfully.');
}


public function destroy(Task $task)
{
        
    $task->delete();

    return redirect()->route(auth()->user()->role == 'admin' ? 'admin.dashboard' : 'user.dashboard')
                     ->with('success', 'Task deleted successfully.');
}

public function updateStatus(Request $request, $id)
{
    $task = Task::findOrFail($id);
    
    if ($task->user_id != auth()->id()) {
        return redirect()->route(auth()->user()->role == 'admin' ? 'admin.dashboard' : 'user.dashboard')->withErrors(['error' => 'Unauthorized']);
   }
     
    $task->status = 'completed';
    $task->save();
    
        return redirect()->route('user.dashboard')->with('success', 'Task status updated to completed!');
}

}


