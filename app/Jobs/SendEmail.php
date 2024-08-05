<?php

namespace App\Jobs;

use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Queueable,Dispatchable,InteractsWithQueue,SerializesModels;

    public $employee;
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    public function handle(): void
    {
        Mail::to($this->employee['email'])->send(new RegisterMail($this->employee));

    }
}
