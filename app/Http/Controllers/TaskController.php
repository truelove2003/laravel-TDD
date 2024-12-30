<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    // Hiển thị danh sách các task
    public function index(Request $request)
    {
        
        // Kiểm tra nếu có từ khóa tìm kiếm
        $query = Task::query();
    
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
    
        // Lấy danh sách task với pagination
        $tasks = $query->paginate(10); // Hoặc sử dụng get() nếu không cần phân trang
    
        return view('tasks.index', compact('tasks'));
    }

    // Hiển thị form tạo task mới
    public function create()
    {
        return view('tasks.create');
    }

    // Lưu task mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => 'required|in:pending,completed',
        ]);
    
        // Tạo mới task
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);
    
        // Trả về phản hồi JSON với mã trạng thái 201 (Created)
        return response()->json($task, 201);
    }
    

    // Hiển thị form chỉnh sửa task
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => 'required|in:pending,completed',
        ]);
    
        // Cập nhật thông tin task
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);
    
        // Trả về task đã cập nhật và mã trạng thái 200
        return response()->json($task, 200);
    }
    

    // Xóa task
    public function destroy(Task $task)
    {
        // Xóa task
        $task->delete();
    
        // Trả về mã trạng thái 204 (No Content) khi xóa thành công
        return response()->noContent();
    }
    
    
}