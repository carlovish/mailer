<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Inertia\Inertia;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $title;
    protected $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $content)
    {
       $this->title=$title;
       $this->content=$content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('carloshechava@gmail.com','Carlos Hechavarria')
        ->subject($this->title)
        ->view('emails.test')
        ->with([
            'title'=>$this->title,
            'content'=>$this->content
        ]);
    }
}
