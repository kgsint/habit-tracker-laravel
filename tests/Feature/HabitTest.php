<?php

namespace Tests\Feature;

use App\Models\Habit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HabitTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // index
    public function test_authenticated_user_can_view_habits(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                                        ->get('/');

        $response->assertStatus(200);
    }

    // index
    public function test_guest_cannot_view_habits(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    // create & store
    public function test_authenticated_user_can_create_habit(): void
    {
        $this->actingAs($user = User::factory()->create());

        // assert create route
        $this->get(route('habits.create'))
                                        ->assertStatus(200);

        $attributes = [
            'title' => $this->faker()->sentence(4),
            'description' => $this->faker()->sentence(10),
        ];

        $response = $this->post(route('habits.store'), $attributes);
        // get user created habit
        $habit = Habit::whereBelongsTo($user)->where($attributes)->first();

        // assert redirect to show page after created
        $response->assertRedirectToRoute('habits.show', $habit->id);
        // assert database
        $this->assertDatabaseHas('habits', $attributes);
    }

    // edit & update
    public function test_authenticated_user_can_update_habit(): void
    {
        $this->actingAs($user = User::factory()->create());

        // create user's related habit
        $habit = Habit::factory()->create(['user_id' => $user->id]);

        // assert edit page
        $this->get(route('habits.edit', $habit->id))->assertStatus(200);

        $attributes = [
            'title' => $this->faker()->sentence(4),
            'description' => $this->faker()->sentence(10),
        ];

        // send update request
        $response = $this->patch(route('habits.update', $habit->id), $attributes);

        // assert show route
        $response->assertRedirectToRoute('habits.show', $habit);
        $this->assertDatabaseHas('habits', $attributes);
    }

    // authorize update test
    public function test_authenticated_cannot_update_others()
    {
        // currently authenticate user
        $user = User::factory()->create();

        $this->actingAs($user);

        // other user
        $otherUser = User::factory()->create();

        // other user's habit
        $habit = Habit::factory()->create([
            'title' => $this->faker()->sentence(4),
            'description' => $this->faker()->sentence(10),
            'user_id' => $otherUser->id
        ]);

        // assert unauthorize in edit page
        $this->get(route('habits.edit', $habit->id))->assertStatus(403);

        $response = $this->patch(route('habits.update', $habit->id), [
                'title' => $this->faker()->sentence(3),
                'description' => $this->faker()->sentence(10),
        ]);

        // assert unauthorize in update request
        $response->assertStatus(403);
    }

    // delete
    public function test_authenticated_user_can_delete_habits()
    {

        $this->actingAs($user = User::factory()->create());

        $habit = Habit::factory()->create([
            'title' => $this->faker()->sentence(4),
            'description' => $this->faker()->sentence(10),
            'user_id' => $user->id
        ]);

        $response = $this->delete(route('habits.destroy', $habit->id));

        $response->assertStatus(200);
        $this->assertModelMissing($habit);
    }

    // authrize delete
    public function test_authenticated_user_cannot_delete_others()
    {
        // currently authenticate user
        $this->actingAs($user = User::factory()->create());

        // other user
        $otherUser = User::factory()->create();

        // other user's habit
        $habit = Habit::factory()->create([
            'title' => $this->faker()->sentence(4),
            'description' => $this->faker()->sentence(10),
            'user_id' => $otherUser->id
        ]);

        $response = $this->delete(route('habits.destroy', $habit->id));

        $response->assertStatus(403);
    }
}
