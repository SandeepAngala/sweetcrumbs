<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Product $product) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Low Stock Alert - '.$this->product->name)
            ->line("Product {$this->product->name} (SKU: {$this->product->sku}) is low on stock.")
            ->line('Current stock: '.$this->product->stock)
            ->action('Manage Inventory', url('/admin/products/'.$this->product->id.'/edit'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'low_stock',
            'title' => 'Low Stock Alert',
            'message' => "{$this->product->name} has only {$this->product->stock} units left.",
            'product_id' => $this->product->id,
        ];
    }
}
