<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // عرض جميع المهام
    public function index()
    {
        $tasks = Task::all();

        return view('tasks', compact('tasks'));
    }

    // تعديل المهمة
    public function edit($id)
    {
        $editingTask = Task::findOrFail($id);

        $tasks = Task::all();

        return view('tasks', compact('tasks', 'editingTask'));
    }

    // حفظ التعديل
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tasks,id',
            'name' => 'required|string|max:255',
        ]);

        $task = Task::findOrFail($request->id);

        $task->name = $request->name;

        $task->save();

        return redirect('/tasks')
            ->with('success', 'Task updated successfully!');
    }

    // حذف المهمة
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        return redirect('/tasks')
            ->with('success', 'Task deleted successfully!');
    }
}
