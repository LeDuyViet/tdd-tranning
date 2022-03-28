<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use function route;

class GetTaskTest extends TestCase
{
    /**
     * @test
     */
    public function authenticated_user_can_show_task_if_task_exist()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $response = $this->get(Route('task.show', $task->id));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function authenticated_user_can_not_show_task_if_task_not_exist()
    {
        $this->actingAs(User::factory()->create());
        $taskId = -1;
        $response = $this->get(Route('task.show', $taskId));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function unauthenticated_user_can_not_show_task()
    {
        $taskId = -1;
        $response = $this->get(Route('task.show', $taskId));
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/login');
    }
}
