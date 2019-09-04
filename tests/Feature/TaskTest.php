<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    // use WithoutMiddleware;
    // $this->withoutExceptionHandling();

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    /** @test */
    public function only_logged_in_user_can_see_the_dashboard()
    {
        $response = $this->get('/')
          ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_see_the_dasahboard()
    {
        $this->actingAsUser();

        $response = $this->get('/dashboard')
        ->assertOk();
    }

    /** @test */
    public function create_a_task()
    {
        $this->actingAsUser();

        $response = $this->post('/tasks', $this->data());

        $this->assertCount(1, Task::all());
    }

    /** @test */
    public function a_user_id_is_required()
    {
        $this->actingAsUser();

        $response = $this->post('/tasks', array_merge($this->data(), ['user_id' => '']));

        $response->assertSessionHasErrors('user_id');
        $this->assertCount(0, Task::all());
    }

    /** @test */
    public function a_title_is_required()
    {
        $this->actingAsUser();

        $response = $this->post('/tasks', array_merge($this->data(), ['title' => '']));

        $response->assertSessionHasErrors('title');
        $this->assertCount(0, Task::all());
    }

    /** @test */
    public function a_title_is_required_at_least_four_char()
    {
        $this->actingAsUser();

        $response = $this->post('/tasks', array_merge($this->data(), ['title' => 'A']));

        $response->assertSessionHasErrors('title');
        $this->assertCount(0, Task::all());
    }

    /** @test */
    public function a_task_points_is_required()
    {
        $this->actingAsUser();

        $response = $this->post('/tasks', array_merge($this->data(), ['points' => '']));

        $response->assertSessionHasErrors('points');
        $this->assertCount(0, Task::all());
    }

    /** @test */
    public function a_task_status_is_done_required()
    {
        $this->actingAsUser();

        $response = $this->post('/tasks', array_merge($this->data(), ['is_done' => '']));

        $response->assertSessionHasErrors('is_done');
        $this->assertCount(0, Task::all());
    }


    private function data()
    {
      return [
        'user_id'      => 1,
        'title'        => 'Task A',
        'points'       => 1,
        'is_done'      => false
      ];
    }

    private function actingAsUser()
    {
        $this->actingAs(factory(User::class)->create());
    }


}
