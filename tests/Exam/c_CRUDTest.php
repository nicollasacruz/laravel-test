<?php

declare(strict_types = 1);

namespace Tests\Exam;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * CRUD Test
 * - On this test we will cover everything that involves a CRUD workflow:
 *
 * 1. Create a route to create a daily log
 * 2. Validate the payload
 * 3. Use route binding
 * 4. Use policies
 * 5. Create a custom rule
 * 6. Use middleware
 * 7. Dispatch an event
 * 8. Create a listener and a Mailable
 *
 * @package Tests\Exam
 */
class c_CRUDTest extends TestCase
{
    /**
     * Create route that will save a daily log
     * using the post method and name the route
     * as daily_logs.store
     */
    #[Test]
    public function create_route(): void
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user)->post(route('daily-logs.store'), [
            'log' => 'Logging from create route test',
            'day' => '2020-01-01',
        ]);

        $this->assertDatabaseHas('daily_logs', [
            'user_id' => $user->id,
            'log'     => 'Logging from create route test',
            'day'     => '2020-01-01 00:00:00',
        ]);
    }

    /**
     * Validates the payload
     * - log: should be required
     * - day: should be required and have a valid date
     */
    #[Test]
    public function validate_the_payload(): void
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $this->postJson(route('daily-logs.store'))
            ->assertJsonValidationErrors([
                'log' => __('validation.required', ['attribute' => 'log']),
                'day' => __('validation.required', ['attribute' => 'day']),
            ]);

        $this->postJson(route('daily-logs.store'), ['day' => 'invalid-date'])
            ->assertJsonValidationErrors([
                'day' => __('validation.date', ['attribute' => 'day']),
            ]);
    }

    /**
     * Refactor the code and implement Route Model Binding
     * - You should apply the refactor and this test still
     *   need to pass
     */
    #[Test]
    public function implement_route_model_binding(): void
    {
        $user     = \App\Models\User::factory()->create();
        $dailyLog = \App\Models\DailyLog::factory()->create();

        $this->actingAs($user);

        $this->put(route('daily-logs.update', $dailyLog), [
            'log' => 'Updating the text',
        ]);

        $this->assertDatabaseHas('daily_logs', [
            'id'  => $dailyLog->id,
            'log' => 'Updating the text',
        ]);
    }

    /**
     * Create a Policy to authorize only the user owner
     * of the daily log to be able to delete the daily log.
     */
    #[Test]
    public function use_policy_to_authorize_deletion(): void
    {
        $user1 = \App\Models\User::factory()->create();
        $user2 = \App\Models\User::factory()->create();

        $dailyLog = \App\Models\DailyLog::factory()->create([
            'user_id' => $user2->id,
        ]);

        $this->actingAs($user1)
            ->deleteJson(route('daily-logs.delete', $dailyLog))
            ->assertForbidden();
    }

    /**
     * Apply Soft Delete
     */
    #[Test]
    public function apply_soft_delete(): void
    {
        $user = \App\Models\User::factory()->create();

        $dailyLog = \App\Models\DailyLog::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->deleteJson(route('daily-logs.delete', $dailyLog));

        $this->assertSoftDeleted('daily_logs', ['id' => $dailyLog->id]);
    }

    /**
     * Create a custom rule that will block the word SHIT
     * if exists on the log field
     */
    #[Test]
    public function custom_rule(): void
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('daily-logs.store'), [
                'log' => 'Developers that get SHIT done',
                'day' => '2020-01-01',
            ])
            ->assertJsonValidationErrors([
                'log' => "Bad word! Don't use SHIT. Please!!!",
            ]);

        $this->assertCount(0, $user->dailyLogs);
    }

    /**
     * Create a middleware that will block a user with
     * a name "Jane Doe" to create Daily Logs
     */
    #[Test]
    public function use_middleware_to_block_access(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Jane Doe',
        ]);

        $this->actingAs($user)->postJson(route('daily-logs.store'), [
            'log' => 'Developers that get things done',
            'day' => '2020-01-01',
        ])->assertUnauthorized();
    }

    /**
     * Dispatch an event after a creation of a Daily Log
     */
    #[Test]
    public function it_should_dispatch_an_event(): void
    {
        Event::fake();

        $user = \App\Models\User::factory()->create();

        $this->actingAs($user)->post(route('daily-logs.store'), [
            'log' => 'Logging from create route test',
            'day' => '2020-01-01',
        ]);

        Event::assertDispatched(\App\Events\DailyLogCreated::class);
    }

    /**
     * When a Daily Log is created and event will be dispatched,
     * a listener should be created that will be used
     * to email the creator with a copy of the Daily Log
     */
    #[Test]
    public function create_a_listener_that_will_send_an_email_with_a_copy_of_daily_log(): void
    {
        Mail::fake();

        $user = \App\Models\User::factory()->create();

        $this->actingAs($user)->post(route('daily-logs.store'), [
            'log' => 'Logging from create route test',
            'day' => '2020-01-01',
        ]);

        Mail::assertSent(\App\Mail\DailyLogCopy::class);
    }
}
