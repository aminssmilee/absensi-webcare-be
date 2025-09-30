<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // 🔹 Ambil semua tugas untuk user login
    public function index()
    {
        $tasks = Task::where('assigned_to', Auth::id())->get();
        return response()->json($tasks, 200);
    }

    // 🔹 Update status dan komentar
    public function update(Request $request, Task $task)
    {
        // Pastikan hanya user yang ditugaskan bisa update
        if ($task->assigned_to !== Auth::id()) {
            return response()->json([
                'message' => 'Tidak boleh edit tugas orang lain'
            ], 403);
        }

        // Validasi input
        $validated = $request->validate([
            'is_done' => 'nullable|boolean',
            'comment' => 'nullable|string|max:500',
        ]);

        // Update task
        $task->update($validated);

        return response()->json([
            'message' => 'Tugas berhasil diperbarui ✅',
            'task'    => $task
        ], 200);
    }
}
