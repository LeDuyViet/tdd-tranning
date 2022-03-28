<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Tests\TestCase;

class DeleteTaskTest extends TestCase
{
    /**
     * @test
     */
    public function authenticated_user_can_delete_task_if_task_exist()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $taskCountBeforeDelete = Task::count();
        $response = $this->delete(route('task.delete', $task->id));
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseMissing('tasks', [
            'name' => $task->name,
            'content' => $task->content
        ]);
        $this->assertDatabaseCount('tasks', $taskCountBeforeDelete-1);
        $response->assertRedirect(route('task.index'));
    }

    /**
     * @test
     */
    public function authenticated_user_can_not_delete_task_if_task_not_exist()
    {
        $this->actingAs(User::factory()->create());
        $taskId = -1;
        $response = $this->delete(route('task.delete', $taskId));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function unauthenticated_user_can_not_delete_task_if_task_exist()
    {
        $this->actingAs(User::factory()->create());
        $taskId = 1;
        $response = $this->delete(route('task.delete', $taskId));
        $response->assertStatus(404);
    }
}
