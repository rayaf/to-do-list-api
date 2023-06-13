<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \Illuminate\Database\QueryException;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskCanBeCreated()
    {
        $user = User::factory()->create();

        $taskData = [
            'title' => 'Sample Task',
            'description' => 'This is a sample task.',
            'completed' => false,
            'user_id' => $user->id,
        ];

        $task = Task::create($taskData);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals('Sample Task', $task->title);
        $this->assertEquals('This is a sample task.', $task->description);
        $this->assertFalse($task->completed);
        $this->assertEquals($user->id, $task->user_id);
    }

    public function testTaskValidation()
    {
        $this->expectException(QueryException::class);

        $taskData = [
            'title' => null,
            'description' => 'This is a sample task.',
            'completed' => false,
            'user_id' => null,
        ];

        Task::create($taskData);
    }


    public function testTaskHasUser()
    {
        $user = User::factory()->create();

        $taskData = [
            'title' => 'Sample Task',
            'description' => 'This is a sample task.',
            'completed' => false,
            'user_id' => $user->id,
        ];

        $task = Task::create($taskData);

        $this->assertInstanceOf(User::class, $task->user);
        $this->assertEquals($user->id, $task->user->id);
    }
}