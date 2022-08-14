<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected  Admin $admin;
    // public  Admin $admin;
    // private Admin $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admin)
    {
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hr@tasks-system.com')
        ->subject('Tasks Sestem | Welcome Email')
        ->with(['admin'=>$this->admin, 'name'=>$this->admin->name]) // ;admin variable defined as protected
        ->markdown('cms.emails.welcome');
    }
}
