<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;
use function route;

class CreateNewTaskTest extends TestCase
{
    public function getCreateTaskRoute()
    {
        return route('task.store');
    }

    public function getCreateTaskViewRoute()
    {
        return route('task.create');
    }

    /**
     * @test
     */
    public function authenticated_user_can_new_task()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->make()->toArray();
        $response = $this->post($this->getCreateTaskRoute(), $task);

        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', $task);
        $response->assertRedirect(route('task.index'));
    }

    /**
     * @test
     */
    public function unauthenticated_user_can_not_create_task()
    {
        $task = Task::factory()->create()->toArray();
        $response = $this->post($this->getCreateTaskRoute(), $task);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function authenticated_user_can_not_create_task_if_name_field_is_null()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->make(['name' => null])->toArray();
        $response = $this->post($this->getCreateTaskRoute(), $task);
        $response->assertSessionHasErrors(['name']);

    }

    /**
     * @test
     */
    public function authenticate_user_can_view_create_task_form()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->get(route('task.create'));
        $response->assertViewIs('task.create');
    }

    /**
     * @test
     */

    public function authenticated_user_see_name_require_text_if_validate_error()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->make(['name' => null])->toArray();
        $response = $this->from($this->getCreateTaskRoute())->post($this->getCreateTaskRoute());
//        $response->assertSee('The name field is required.');
        $response->assertRedirect($this->getCreateTaskRoute());

    }

    /**
     * @test
     */
    public function unauthenticated_user_can_not_see_create_task_view()
    {
        $response = $this->get($this->getCreateTaskViewRoute());
        $response->assertRedirect('/login');
    }


}
