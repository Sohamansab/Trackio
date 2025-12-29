<?php

namespace App\Notifications;

use App\Models\AttendanceAdjustment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AttendanceAdjustmentApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $adjustment;

    /**
     * Create a new notification instance.
     */
    public function __construct(AttendanceAdjustment $adjustment)
    {
        $this->adjustment = $adjustment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Attendance Adjustment Request Has Been Approved')
            ->greeting('Hello ' . $notifiable->employeeProfile->name . '!')
            ->line('Your attendance adjustment request has been approved.')
            ->line('**Adjustment Details:**')
            ->line('Type: ' . $this->adjustment->adjustment_type)
            ->line('Date: ' . $this->adjustment->adjustment_date->format('F j, Y'))
            ->line('Reason: ' . $this->adjustment->reason)
            ->action('View Details', url('/employee/attendance-adjustments'))
            ->line('Thank you for using Trackio!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Attendance Adjustment Approved',
            'message' => 'Your attendance adjustment request for ' . $this->adjustment->adjustment_date->format('M j, Y') . ' has been approved.',
            'type' => 'attendance_adjustment_approved',
            'adjustment_id' => $this->adjustment->id,
            'adjustment_type' => $this->adjustment->adjustment_type,
            'adjustment_date' => $this->adjustment->adjustment_date->format('Y-m-d'),
        ];
    }
}
