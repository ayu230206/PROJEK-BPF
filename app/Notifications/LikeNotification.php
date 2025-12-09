<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LikeNotification extends Notification
{
    use Queueable;

    protected $post;
    protected $liker;

    public function __construct($post, $liker)
    {
        $this->post  = $post;
        $this->liker = $liker;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'      => 'Postingan Disukai',
            'message'    => $this->liker->nama_lengkap . ' menyukai postingan kamu.',
            'liker_name' => $this->liker->nama_lengkap,
            'url'        => route('mahasiswa.posts.show', $this->post),
        ];
    }
}
