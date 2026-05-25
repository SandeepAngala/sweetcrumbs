<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlaced extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Confirmed - '.$this->order->order_number)
            ->greeting('Hello '.$notifiable->name.'!')
            ->line('Thank you for your order at MANA OORU MANA TEA.')
            ->line('Order #: '.$this->order->order_number)
            ->line('Total: ₹'.number_format($this->order->total, 2))
            ->action('Track Order', url('/dashboard/orders/'.$this->order->order_number));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'order_placed',
            'title' => 'Order Placed',
            'message' => 'Your order '.$this->order->order_number.' has been placed successfully.',
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
        ];
    }
}
