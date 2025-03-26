<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function addTask(Request $req){
         // Validate request data
         $req->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|in:Low,Medium,High',
            'due_date'    => 'required|date|after:today',
        ]);

        // Create and save task
        $task = Task::create([
            'title'       => $req->title,
            'description' => $req->description,
            'priority'    => $req->priority,
            'due_date'    => $req->due_date,
            'status'      => 'Pending', // Default status
        ]);

       return response()->json(['message' => 'Task added successfully!', 'data'=> $task]);
    }

    public function deleteTask($id)
    {
        $task = Task::find($id);

        if ($task) {
            $task->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function filterTasks(Request $request)
    {
        $status = $request->query('type', 'all'); // Get 'type' from query, default to 'all'

        if ($status === 'all') {
            $tasks = Task::paginate(5);
        } else {
            $tasks = Task::where('status', $status)->paginate(5);
        }
    
        return view('dashbaord', ['tasks' => $tasks, 'status' => $status]);
    }

    public function changeStatus(Request $request, $id)
    {
        $task = Task::findOrFail($id); // Find task by ID
        $task->status = $request->status; // Update status
        $task->save(); // Save changes

        return response()->json(['success' => true, 'message' => 'Task status updated successfully']);
    }
    public function editTask($id)
    {
        $task = Task::findOrFail($id);
        return response()->json(['task' => $task]);
    }

    public function updateTask(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->due_date = $request->due_date;
        $task->save();

        return response()->json(['message' => 'Task updated successfully!']);
    }
}
