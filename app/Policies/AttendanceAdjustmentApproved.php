<?php

namespace App\Notifications;

use App\Models\AttendanceAdjustment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AttendanceAdjustmentApproved extends Notification
{
    use Queueable;

    public $adjustment;

    /**
     * Create a new notification instance.
     */
    public function __construct(AttendanceAdjustment $adjustment)
    {
        $this->adjustment = $adjustment;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Your attendance adjustment request for ' . $this->adjustment->adjustment_date->format('Y-m-d') . ' has been approved.',
            'adjustment_id' => $this->adjustment->id,
            'type' => $this->adjustment->adjustment_type,
        ];
    }
}