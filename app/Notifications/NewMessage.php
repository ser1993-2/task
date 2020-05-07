<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NewMessage extends Notification
{
    use Queueable;
    public $taskId;
    public $text;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($taskId,$text)
    {
        $this->taskId = $taskId;
        $this->text = $text;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        if (Auth::user()->role == 0) {
            return (new MailMessage)->subject('Новое сообщение')
                ->line('В заявке №' . $this->taskId . ', оставлено новое сообщение.')
                ->action('Перейти к заявке', url('/manager#/task/' . $this->taskId))
                ->line('Сообщение:')
                ->line($this->text);
        } else {
            return (new MailMessage)->subject('Новое сообщение')
                ->line('В заявке №' . $this->taskId . ', оставлено новое сообщение.')
                ->action('Перейти к заявке', url('/user#/task/' . $this->taskId))
                ->line('Сообщение:')
                ->line($this->text);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
