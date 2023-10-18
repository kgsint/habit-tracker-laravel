<?php

namespace Tests\Unit;

use App\Models\Habit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HabitTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_user()
    {
        $habit = Habit::factory()->create();

        $this->assertInstanceOf(User::class, $habit->user);
    }
}
