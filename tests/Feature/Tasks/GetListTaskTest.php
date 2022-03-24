<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetListTaskTest extends TestCase
{
    public function get_list_task_route()
    {
        return route('task.index');
    }
    /**
     * @test
     */
    public function user_can_get_all_tasks()
    {
        $task = Task::factory()->create();
        $response = $this->get($this->get_list_task_route());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('task.index');
    }


}
