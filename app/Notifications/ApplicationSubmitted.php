<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ApplicationSubmitted extends Notification
{
    protected $job;

    public function __construct($job)
    {
        $this->job = $job;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Application Submitted')
                    ->line('You have successfully applied for the job ' . $this->job->title . ' at ' . $this->job->company . '.')
                    ->action('View Applications', url('/candidate/applications'))
                    ->line('Thank you for using our platform!');
    }
}
