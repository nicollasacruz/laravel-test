<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\DailyLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class SaveRandomQuote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, public Carbon $date)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('SaveRandomQuote job is running!!! 🧨');
        $response  = Http::get('https://api.quotable.io/random');

        DailyLog::create([
            'user_id' => $this->user->id,
            'day' => $this->date,
            'log' => $response['content'],
        ]);
    }

    public function middleware(): array
    {
        return [(new RateLimited('save-random-quote'))->dontRelease()];
    }
}
