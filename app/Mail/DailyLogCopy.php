<?php

namespace App\Mail;

use App\Models\DailyLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyLogCopy extends Mailable
{
    use Queueable, SerializesModels;
    
    public DailyLog $dailyLog;

    /**
     * Create a new message instance.
     */
    public function __construct(DailyLog $dailyLog)
    {
        $this->dailyLog = $dailyLog;
    }

    public function build()
    {
        return $this->subject('Sample Email')
                    ->view('email.daily-log-copy')
                    ->with(['dailyLog' => $this->dailyLog]);
    }

    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Daily Log Copy',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'email.daily-log-copy',
    //         with: ['dailyLog' => $this->dailyLog],
    //     );
    // }
}
