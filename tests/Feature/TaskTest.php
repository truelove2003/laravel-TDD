<?php

namespace Tests\Feature;

use App\Models\User; // Thêm dòng này
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(); // Tạo task giả lập

        $response = $this->actingAs($user)->putJson("/tasks/{$task->id}", [
            'title' => 'Updated Task',
            'description' => 'Updated task description.',
            'status' => 'completed',
        ]);

        $response->assertStatus(200); // Kiểm tra mã trạng thái 200
        $response->assertJson([
            'title' => 'Updated Task',
            'description' => 'Updated task description.',
            'status' => 'completed',
        ]);
    }

    public function test_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->deleteJson("/tasks/{$task->id}");

        $response->assertStatus(204); // Kiểm tra mã trạng thái 204
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]); // Kiểm tra task đã bị xoá khỏi DB
    }

    public function test_show_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->getJson("/tasks/{$task->id}");

        $response->assertStatus(200); // Kiểm tra mã trạng thái 200
        $response->assertJson([
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
        ]);
    }
}
