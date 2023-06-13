<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * Test the index method of the TaskController.
     */
    public function testIndex()
    {
        // Create some tasks for the authenticated user
        $user = $this->actingAsUser();
        Task::factory()->count(3)->create(['user_id' => $user->id]);

        // Call the index method and assert the response is ok
        $response = $this->call('GET', 'api/tasks');
        $response->assertOk();

        // Assert the response contains the tasks as JSON
        $tasks = Task::where('user_id', $user->id)->get();
        $response->assertJson($tasks->toArray());
    }


     /**
     * Test the store method of the TaskController.
     */
    public function testStore()
    {
        // Create a fake file for testing
        Storage::fake('local');
        $file = UploadedFile::fake()->create('document.pdf');

        // Create a task for the authenticated user
        $user = $this->actingAsUser();

        // Create an array of input data for the task
        $input = [
            'title' => 'Test task',
            'description' => 'This is a test task',
            'attachment' => $file,
            'user_id' => $user->id,
        ];

        // Call the store method and assert the response is created (201)
        $response = $this->call('POST', 'api/tasks', $input);
        $response->assertCreated();

        // Assert the task was saved in the database with the correct data
        $task = Task::first();
        $this->assertEquals($input['title'], $task->title);
        $this->assertEquals($input['description'], $task->description);
        $this->assertEquals($file->hashName(), basename($task->attachment));

        // Assert the file was stored in the attachments disk
        Storage::disk('local')->assertExists($task->attachment);

        // Assert the response contains the task as JSON
        $response->assertJsonFragment([
            'title' => 'Test task',
            'description' => 'This is a test task',
            'user_id' => $task->user_id,
            'attachment' => $task->attachment,
        ]);
    }

    /**
     * Test the show method of the TaskController.
     */
    public function testShow()
    {
        // Create a task for the authenticated user
        $user = $this->actingAsUser();
        $task = Task::factory()->create(['user_id' => $user->id]);

        // Call the show method and assert the response is ok
        $response = $this->call('GET', 'api/tasks/' . $task->id);
        $response->assertOk();

        // Assert the response contains the task as JSON
        $response->assertJson($task->toArray());
    }

    /**
     * Test the update method of the TaskController.
     */
    public function testUpdate()
    {
        // Create a task for the authenticated user
        $user = $this->actingAsUser();
        $task = Task::factory()->create(['user_id' => $user->id]);

        // Create an array of input data for the task
        $input = [
            'title' => 'Updated task',
            'description' => 'This is an updated task',
        ];

        // Call the update method and assert the response is ok
        $response = $this->call('PUT', 'api/tasks/' . $task->id, $input);
        $response->assertOk();

        // Assert the task was updated in the database with the correct data
        $task->refresh();
        $this->assertEquals($input['title'], $task->title);
        $this->assertEquals($input['description'], $task->description);

        // Assert the response contains the task as JSON
        $response->assertJson($task->toArray());
    }

    /**
     * Test the destroy method of the TaskController.
     */
    public function testDestroy()
    {
        // Create a task for the authenticated user
        $user = $this->actingAsUser();
        $task = Task::factory()->create(['user_id' => $user->id]);

        // Call the destroy method and assert the response is ok
        $response = $this->call('DELETE', 'api/tasks/' . $task->id);
        $response->assertOk();

        // Assert the task was deleted from the database
        $this->assertNull(Task::find($task->id));

        // Assert the response contains a success message as JSON
        $response->assertJson(['message' => 'Task deleted']);
    }
}
