<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ApplicationSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public $job;
    public $application;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Job  $job
     * @param  \App\Models\Application  $application
     */
    public function __construct($job, $application)
    {
        $this->job = $job;
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Application Submitted: ' . $this->job->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Thank you for applying for the position:')
            ->line(new HtmlString('<strong>' . $this->job->title . '</strong> at <strong>' . $this->job->company . '</strong>'))
            ->line(new HtmlString('<br>'))
            ->line('Application Details:')
            ->line(new HtmlString('<strong>Date:</strong> ' . $this->application->applied_at->format('F j, Y')))
            ->line(new HtmlString('<strong>Reference ID:</strong> ' . $this->application->id))
            ->line(new HtmlString('<br>'))
            ->action('View Application Status', route('candidate.applications.show', $this->application))
            ->line('We will review your application and contact you within 5-7 business days.')
            ->salutation(new HtmlString('Best Regards,<br>' . config('app.name')));
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
            'type' => 'application_submitted',
            'message' => 'Your application for ' . $this->job->title . ' has been submitted.',
            'job_id' => $this->job->id,
            'job_title' => $this->job->title,
            'company_name' => $this->job->company,
            'application_id' => $this->application->id,
            'applied_at' => $this->application->applied_at->toDateTimeString(),
            'link' => route('candidate.applications.show', $this->application),
        ];
    }

    /**
     * Get the tags for the notification.
     *
     * @return array
     */
    public function tags()
    {
        return ['application', 'job:'.$this->job->id, 'candidate:'.$this->application->candidate_id];
    }
}