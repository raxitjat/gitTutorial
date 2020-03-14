<?php

namespace App\Observers;

use App\Post;
use App\Mail\DeletePostMail;
use App\Mail\AddPostMail;
// use 

class PostObserver
{
    /**
     * Handle the post "created" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
     public function creating(Post $post)
    {
        $post->title = strtoupper($post->title);


    }

    public function created(Post $post)
    {
        // $post->title=strtoupper($post->title);
        $this->sendMailableAdd($post,AddPostMail::class);

        
            // $post->title = strtoupper($post->title);

    }

    public function updating(Post $post)
    {
        // $post->title = strtoupper($post->title);

    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        // $post->title = strtoupper($post->title);
        
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    // public function deleting(Post $post)
    // {
    //     route('sendMail');
    // }
    public function deleted(Post $post)
    {
        // $this->sendMailable($post,DeletePostMail::class);
    }
    public function deleting(Post $post)
    {
        $this->sendMailableDelete($post,DeletePostMail::class);
    }

    /**
     * Handle the post "restored" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }

    private function sendMailableDelete(Post $post)
    {
    //     $teacher = User::findOrFail($classroom->teacher_id)->first();
    //     $student = User::findOrFail($classroom->student_id)->first();

    \Mail::to('raxit@logisticinfotech.co.in')->queue(new DeletePostMail($post));


        
    }
    private function sendMailableAdd(Post $post)
    {
    //     $teacher = User::findOrFail($classroom->teacher_id)->first();
    //     $student = User::findOrFail($classroom->student_id)->first();

    \Mail::to('raxit@logisticinfotech.co.in')->queue(new AddPostMail($post));


        
    }

}
