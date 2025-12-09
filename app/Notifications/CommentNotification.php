<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Mahasiswa\Post;

class CommentNotification extends Notification
{
    use Queueable;

    protected $post;
    protected $comment;

    public function __construct(Post $post, $comment)
    {
        $this->post = $post;
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database']; // simpan di tabel notifications
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Komentar Baru',
            'message' => $this->comment,
            'url' => route('mahasiswa.posts.show', $this->post), 
            // Laravel akan otomatis pakai $post->getKey() sesuai resource route
        ];
    }
}
