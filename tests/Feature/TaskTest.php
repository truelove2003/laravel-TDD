<?php

namespace Tests\Feature;

use App\Models\User; // Thêm dòng này
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup function to log in a user before running the tests
     */
    protected function setUp(): void
    {
        parent::setUp();
        // Đảm bảo user đã đăng nhập với token
        $this->user = User::factory()->create(); // Tạo người dùng giả
        $this->token = $this->user->createToken('TestApp')->plainTextToken; // Tạo token cho người dùng
    }

    // Kiểm thử tạo task
    public function test_create_task()
    {
        $user = User::factory()->create(); // Tạo người dùng giả lập

        $response = $this->actingAs($user)->postJson('/tasks', [
            'title' => 'New Task',
            'description' => 'This is a new task description.',
            'status' => 'pending',
        ]);

        $response->assertStatus(201); // Kiểm tra mã trạng thái 201
        $response->assertJson([
            'title' => 'New Task',
            'description' => 'This is a new task description.',
            'status' => 'pending',
        ]);
    }

    // Kiểm thử cập nhật task
    public function test_update_task()
    {
        $user = User::factory()->create(); // Tạo người dùng giả
        $task = Task::factory()->create(); // Tạo task giả
    
        // Tạo token cho người dùng
        $token = $user->createToken('TestApp')->plainTextToken;
    
        // Gửi yêu cầu PUT với token trong header
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/tasks/{$task->id}", [
            'title' => 'Updated Task',
            'description' => 'Updated task description.',
            'status' => 'completed',
        ]);
    
        // Kiểm tra mã trạng thái 200 (OK)
        $response->assertStatus(200);
        $response->assertJson([
            'title' => 'Updated Task',
            'description' => 'Updated task description.',
            'status' => 'completed',
        ]);
    }
    

    // Kiểm thử xóa task
    public function test_delete_task()
    {
        $user = User::factory()->create(); // Tạo người dùng giả
        $task = Task::factory()->create(); // Tạo task giả
    
        // Tạo token cho người dùng
        $token = $user->createToken('TestApp')->plainTextToken;
    
        // Gửi yêu cầu DELETE với token trong header
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/tasks/{$task->id}");
    
        $response->assertStatus(204); // Kiểm tra mã trạng thái 204
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]); // Kiểm tra task đã bị xoá khỏi DB
    }
    
 
}

