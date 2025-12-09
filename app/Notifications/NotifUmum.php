<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class NotifUmum extends Notification
{
    public $title;
    public $message;
    public $link;

    public function __construct($title, $message, $link = '#')
    {
        $this->title   = $title;
        $this->message = $message;
        $this->link    = $link;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'   => $this->title,
            'message' => $this->message,
            'url'     => $this->link,
        ];
    }
}
