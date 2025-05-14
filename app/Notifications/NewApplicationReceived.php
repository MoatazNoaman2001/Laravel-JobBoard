<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public $job;
    public $application;

    public function __construct($job, $application)
    {
        $this->job = $job;
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Application Received for ' . $this->job->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You have received a new application for the position: ' . $this->job->title)
            ->line('Applicant: ' . $this->application->candidate->name)
            ->line('Applied On: ' . $this->application->applied_at->format('F j, Y'))
            ->action('Review Application', route('employer.applications.show', $this->application))
            ->line('Please review the application at your earliest convenience.')
            ->salutation('Best Regards,');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'New application received for ' . $this->job->title,
            'applicant_name' => $this->application->candidate->name,
            'job_id' => $this->job->id,
            'application_id' => $this->application->id,
            'link' => route('employer.applications.show', $this->application),
        ];
    }
}