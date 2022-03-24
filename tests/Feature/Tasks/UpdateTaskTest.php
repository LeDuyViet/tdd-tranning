<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    use WithFaker;

    public function getUpdateTaskRoute($id)
    {
        return route('task.update', $id);
    }public function getEditTaskRoute($id)
    {
        return route('task.edit', $id);
    }
    /**
     * @test
     */
    public function authenticated_user_can_view_update_task_form()
    {
        $task = Task::factory()->create();
        $this->actingAs(User::factory()->create());
        $response = $this->get($this->getEditTaskRoute($task->id));
        $response->assertViewIs('task.edit');
    }

    /**
     * @test
     */
    public function authenticated_user_can_update_task_if_task_exist()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->name,
            'content' => $this->faker->text,
        ];
        $response = $this->put($this->getUpdateTaskRoute($task->id), $dataUpdate);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks',[
            'name' => $dataUpdate['name'],
            'content' => $dataUpdate['content']
        ]);
        $response->assertRedirect(route('task.index'));
    }

    /**
     * @test
     */
    public function authenticated_user_see_name_require_text_update_if_validate_error()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $dataUpdate = [
            'name' => null,
            'content' => $this->faker->text,
        ];
        $response = $this->from($this->getEditTaskRoute($task->id), $dataUpdate)->put($this->getUpdateTaskRoute($task->id), $dataUpdate);
        $response->assertRedirect($this->getEditTaskRoute($task->id), $dataUpdate);
    }

    /**
     * @test
     */
    public function authenticated_user_can_not_update_task_if_task_not_exists()
    {
        $this->actingAs(User::factory()->create());
        $taskId = -1;
        $dataUpdate = [
            'name' => $this->faker->name,
            'content' => $this->faker->text,
        ];
        $response = $this->put($this->getUpdateTaskRoute($taskId), $dataUpdate);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function authenticated_user_can_not_view_update_task_form_if_task_not_exists()
    {
        $this->actingAs(User::factory()->create());
        $taskId = -1;
        $dataUpdate = [
            'name' => $this->faker->name,
            'content' => $this->faker->text,
        ];
        $response = $this->get($this->getUpdateTaskRoute($taskId), $dataUpdate);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function unauthenticated_user_can_view_form_update()
    {
        $taskId = 1;
        $dataUpdate = [
            'name' => $this->faker->name,
            'content' => $this->faker->text,
        ];
        $response = $this->get($this->getUpdateTaskRoute($taskId), $dataUpdate);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function unauthenticated_user_can_not_update_task()
    {
        $taskId = 1;
        $dataUpdate = [
            'name' => $this->faker->name,
            'content' => $this->faker->text,
        ];
        $response = $this->put($this->getUpdateTaskRoute($taskId), $dataUpdate);
        $response->assertRedirect('/login');
    }



}
