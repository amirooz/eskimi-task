<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function a_task_can_be_added_to_the_database()
    {
        $this->withoutExceptionHandling();

        $response = $this->post(route('tasks'), [
            'user_id'      => 1,
            'title'        => 'Task A',
            'points'       => 1,
            'is_done'      => false,
        ]);

        $response->assertOk();

        $this->asserCount(1, Task::all());
    }

}
