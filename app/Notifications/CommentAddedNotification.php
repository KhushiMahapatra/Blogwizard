<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentAddedNotification extends Notification
{
    use Queueable;

    public $comment;
    public $post;

    /**
     * Create a new notification instance.
     *
     * @param $comment
     * @param $post
     */
    public function __construct($comment, $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Sending via email
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Comment Added')
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line('A new comment has been added to your post:')
            ->line('**Post Title:** ' . $this->post->title)
            ->line('**Comment:** ' . $this->comment->comment)
            ->action('View Post', url(route('single-blog', $this->post->id)))
            ->line('Thank you for using our application!');
    }
}
