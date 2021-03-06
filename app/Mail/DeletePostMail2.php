<?php

namespace App\Mail;
use App\Models\Post;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeletePostMail extends Mailable
{
    use Queueable, SerializesModels;
    public $post;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->post = $post;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('delete post update')
        ->view('emails.deletePostMail');
        
    }
}
