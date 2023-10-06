<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamNotification extends Notification
{
    use Queueable;
    private $_id;
    private $user_create;
    private $name;
    private $team_image;


    public function __construct($_id,$user_create,$name,$team_image)
    {
        $this->_id = $_id;
        $this->user_create = $user_create;
        $this->name = $name;
        $this->team_image = $team_image;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }


    public function toArray($notifiable)
    {
        return [
            '_id' => $this->_id,
            'user_create' => $this->user_create,
            'name' => $this->name,
            'image_path' => $this->team_image,
        ];
    }
}
