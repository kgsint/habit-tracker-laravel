<?php

namespace Tests\Feature;

use App\Models\Habit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // test store
    public function test_a_task_can_be_created()
    {
        $this->actingAs($user = User::factory()->create());

        $habit = Habit::factory()->create(['user_id' => $user->id]);

        $attribute = ['body' => 'a new task'];
        $response = $this->post(route('tasks.store', $habit->id), $attribute);

        // assert redirect route
        $response->assertRedirectToRoute('habits.show', $habit->id);
        // assert database
        $this->assertDatabaseHas('tasks', $attribute);
    }

    // test update
    public function test_a_task_can_be_updated()
    {
        $this->actingAs($user = User::factory()->create());

        $habit = Habit::factory()->create(['user_id' => $user->id]);

        $task = $habit->tasks()->create([
            'body' => 'a task',
        ]);

        // send update request
        $response = $this->patch(route('tasks.update', ['habit' => $habit->id, 'task' => $task->id]), [
            'body' => 'updated_task',
        ]);

        // assert response code
        $response->assertStatus(200);
        // assert database
        $this->assertDatabaseHas('tasks', ['body' => 'updated_task']);
    }

    // authorize update test
    public function test_user_cannot_update_others_task()
    {
        $this->actingAs($user = User::factory()->create());

        $otherUser = User::factory()->create();

        // other user's
        $habit = Habit::factory()->create(['user_id' => $otherUser->id]);

        $task = $habit->tasks()->create([
            'body' => 'a task',
        ]);

        $response = $this->patch(route('tasks.update', ['habit' => $habit->id, 'task' => $task->id]), [
            'body' => 'updated task',
        ]);

        $response->assertStatus(403);

    }

    public function test_a_test_can_be_completed()
    {
        $this->actingAs($user = User::factory()->create());

        $habit = Habit::factory()->create(['user_id' => $user->id]);
        $task = $habit->tasks()->create([
            'body' => 'a task',
        ]);

        $attributes = ['body' => 'a task', 'is_complete' => true];
        $response = $this->patch(
                                route('tasks.update', ['habit' => $habit->id, 'task' => $task->id]),
                                        $attributes
                                );

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', $attributes);
    }

    public function test_a_test_can_be_uncompleted()
    {
        $this->actingAs($user = User::factory()->create());

        $habit = Habit::factory()->create(['user_id' => $user->id]);
        $task = $habit->tasks()->create([
            'body' => 'a task',
            'is_complete' => true
        ]);

        // uncomplete request
        $attributes = ['body' => 'a task', 'is_complete' => false];
        $response = $this->patch(
                                    route('tasks.update', ['habit' => $habit->id, 'task' => $task->id]
                                ), $attributes);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', $attributes);
    }

    // delete test
    public function test_a_task_is_deleted_when_the_body_of_no_text_is_updated()
    {
        $this->actingAs($user = User::factory()->create());

        $habit = Habit::factory()->create(['user_id' => $user->id]);

        $task = $habit->tasks()->create([
            'body' => 'a task',
        ]);

        // update with the body of empty string
        $response = $this->patch(route('tasks.update', ['habit' => $habit->id, 'task' => $task->id]), [
            'body' => '',
        ]);

        // assert route
        $response->assertRedirectToRoute('habits.show', $habit->id)
                                                                ->assertDontSee('a task'); // assert don't see on page
        // assert database
        $this->assertDatabaseMissing('tasks', $task->toArray());
        $this->assertModelMissing($task);
    }
}
