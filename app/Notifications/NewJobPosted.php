<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Job;

class NewJobPosted extends Notification
{
    use Queueable;

    protected $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];  
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Job Posted: ' . $this->job->title)
                    ->greeting('Hello ' . $notifiable->name)
                    ->line('A new job has been posted that might interest you.')
                    ->action('View Job', url('/jobs/' . $this->job->id))
                    ->line('Thank you for using our platform!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'job_id' => $this->job->id,
            'title' => $this->job->title,
            'message' => 'New job posted: ' . $this->job->title,
            'url' => route('notifications.viewJob', ['notification' => $this->job->id])
        ];
    }
}
