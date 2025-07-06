<?php

namespace Callmeaf\Order\App\Notifications\Api\V1;

use Callmeaf\Order\App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     * @var Order $order
     */
    public function __construct(public $order)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array<string, string>
     */
    public function viaQueues(): array
    {
        return [
            'mail' => 'notifications',
        ];
    }

    /**
     * Determine which connections should be used for each notification channel.
     *
     * @return array<string, string>
     */
    public function viaConnections(): array
    {
        return [
            'database' => 'sync',
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->subject(
            __('callmeaf-order::api_v1.mail.created.subject', [
                'ref_code' => $this->order->ref_code,
            ])
        )->markdown('callmeaf-order::api.v1.mail.orders.created',[
            'url' => explode(',',config('app.frontend_url'))[0],
            'code' => $this->order->code,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "subject" => __('callmeaf-order::api_v1.mail.created.notification_subject'),
            'payload' => __('callmeaf-order::api_v1.mail.created.notification_payload',[
                'code' => $this->order->code,
            ]),
        ];
    }
}
