<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeletePostMail;
use App\Post;

use Illuminate\Mail\Mailer;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // public $post ;
    public $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        // dd($details);
        $this->details = $details;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    
    public function handle()
    {
        
        // dd($post);
        $email = new DeletePostMail();
        Mail::to($this->details)->send($email);

        // Mail::to('raxit@logisticinfotech.co.in')->send(new DeletePostMail());
        // Mail::to('raxit@logisticinfotech.co.in')->send(new DeletePostMail());
    }
}
