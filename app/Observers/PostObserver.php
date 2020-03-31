<?php

namespace App\Observers;

use App\Models\Post;
use App\Mail\DeletePostMail;
use App\Mail\AddPostMail;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
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
        $post->refrence=mt_rand(100000, 999999);

        // $post->title = strtoupper($post->title);


    }

    public function created(Post $post)
    {
        $post->refrence=mt_rand(100000, 999999);
        // $post->save();
        // $six_digit_random_number = mt_rand(100000, 999999);
        // $this->sendMailableAdd($post, AddPostMail::class);

    }

    public function updating(Post $post)
    {
        // if (Storage::disk('public')->exists(config('custom.paths.postImage') . $post->image))
        // {
        //     Storage::disk('public')->delete(config('custom.paths.postImage') . $post->image);

        // }

    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
         

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
        
        if (Storage::disk('public')->exists(config('custom.paths.postImage') . $post->image))
        {
            Storage::disk('public')->delete(config('custom.paths.postImage') . $post->image);

        } else {
            dd("erroer");
        }
    }
    public function deleting(Post $post)
    {
        $details= 'raxit@logisticinfotech.co.in';
        $mailData = [
            "title" =>  $post->title,
            "description" => $post->description ,
         ];
         

        Mail::to($details)->queue(new DeletePostMail($mailData));
        
  
    // dispatch(new SendEmailJob($details));
     
        // $this->sendMailableDelete($post, DeletePostMail::class);
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

        \Mail::to('raxit@logisticinfotech.co.in')->queue(new DeletePostMail($post));

    }
    private function sendMailableAdd(Post $post)
    {

        \Mail::to('raxit@logisticinfotech.co.in')->queue(new AddPostMail($post));
    }

}
