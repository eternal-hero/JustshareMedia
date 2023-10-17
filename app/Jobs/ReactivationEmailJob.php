<?php

namespace App\Jobs;

use App\Mail\ReactivationMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ReactivationEmailJob
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public User $user;
    public $code;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user)->send(new ReactivationMail($this->code));
    }
}
