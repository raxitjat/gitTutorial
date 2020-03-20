<?php

namespace App\Console\Commands;
use App\DripEmailer;
use App\User;
use App\Post;
use Illuminate\Console\Command;
use App\Mail\SendOfferMail;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send e-mails to  all users';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Started sending emails...');

        $users = User::all();
        
        foreach($users as $user)
        {
            $email = new SendOfferMail($user->name);
            Mail::to($user->email)->queue($email);
            
        }

        $this->info('Email sent to all the users!');
        
    }
}
