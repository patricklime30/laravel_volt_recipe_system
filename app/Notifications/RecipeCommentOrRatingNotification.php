<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecipeCommentOrRatingNotification extends Notification
{
    use Queueable;

    public $recipe;
    public $user;
    public $type; //comment or rating

    /**
     * Create a new notification instance.
     */
    public function __construct($recipe, $user, $type)
    {
        $this->recipe = $recipe;
        $this->user = $user;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    // Store this notification in the database.
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    // store in the notifications.data column
    public function toDatabase($notifiable)
    {
        return [
            'recipe_id' => $this->recipe->id,
            'recipe_title' => $this->recipe->title,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'type' => $this->type,
            'message' => "{$this->user->name} added a {$this->type} on your recipe.",
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
