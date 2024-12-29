<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Thêm task mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,completed',
        ]);

        $task = Task::create($validated);

        return response()->json($task, 201); // Trả về task mới được tạo
    }
    // Sửa task
public function update(Request $request, Task $task)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|in:pending,completed',
    ]);

    $task->update($validated);

    return response()->json($task); // Trả về task đã được cập nhật
}
// Xoá task
public function destroy(Task $task)
{
    $task->delete();

    return response()->json(null, 204); // Trả về mã 204 khi xoá thành công
}
// Xem chi tiết task
public function show(Task $task)
{
    return response()->json($task); // Trả về chi tiết task
}

}
