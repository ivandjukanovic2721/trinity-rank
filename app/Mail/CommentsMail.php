<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Comments;

class CommentsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $template;

    public function __construct(Comments $comment, $template)
    {
        $this->comment = $comment;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view( implode('.', [ 'emails', 'comments', $this->template ]) );
    }
}
