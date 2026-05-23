<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order, public string $status) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Update - '.$this->order->order_number)
            ->line('Your order status is now: '.ucfirst(str_replace('_', ' ', $this->status)))
            ->action('View Order', url('/dashboard/orders/'.$this->order->order_number));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'order_status',
            'title' => 'Order Status Updated',
            'message' => 'Order '.$this->order->order_number.' is now '.str_replace('_', ' ', $this->status).'.',
            'order_id' => $this->order->id,
            'status' => $this->status,
        ];
    }
}
