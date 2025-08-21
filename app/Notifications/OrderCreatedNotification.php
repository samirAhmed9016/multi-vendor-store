<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;
    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {

        return ['mail', 'database', 'broadcast'];

        $channels = ['database'];
        if ($notifiable->notification_preferences['order_created']['sms'] ?? false) {
            $channels[] = 'vonage';
        }
        if ($notifiable->notification_preferences['order_created']['mail'] ?? false) {
            $channels[] = 'mail';
        }
        if ($notifiable->notification_preferences['order_created']['broadcast'] ?? false) {
            $channels[] = 'broadcast';
        }
        return $channels;



        // return ['mail'];

        // $channels = ['mail'];

        // $prefs = $notifiable->notification_preferences ?? [];

        // if (!empty($prefs['order_created']['sms'])) {
        //     $channels[] = 'vonage';
        // }

        // if (!empty($prefs['order_created']['mail'])) {
        //     $channels[] = 'mail';
        // }

        // if (!empty($prefs['order_created']['broadcast'])) {
        //     $channels[] = 'broadcast';
        // }

        // return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $address = $this->order->billingAddress;

        // dd($address);
        $name = $address->name ?? 'Customer';

        $country = $address->country_name ?? 'Unknown';
        // dd($country);



        return (new MailMessage)
            ->subject('Order Created: ' . $this->order->number)
            ->from('notifications@store.eg', 'Store Notifications')
            ->greeting('Hello ' . $name)
            ->line('A New Order ' . $this->order->number . ' Created By ' . $name . ' from ' . $country)
            ->action('Notification Action', url('/dashboard/dashboard'))
            ->line('Thank you for using our application!');


        // return (new MailMessage)
        //     ->subject('Order Created: ' . $this->order->number)
        //     ->from('notifications@store.eg', 'Store Notifications')
        //     ->greeting('Hello ' . $address->name)
        //     ->line('A New Order' . $this->order->number . ' Created By' . $address->name . 'from' . $address->country_name)
        //     ->action('Notification Action', url('/dashboard'))
        //     ->line('Thank you for using our application!');
    }

    public function toDatabase(object $notifiable): array
    {

        $address = $this->order->billingAddress;

        // dd($address);
        $name = $address->name ?? 'Customer';

        $country = $address->country_name ?? 'Unknown';
        return [
            'body' => 'A New Order created',
            'icon' => 'fa fa-envelope',
            'url' => url('/dashboard/dashboard'),
            'order_id' => $this->order->id,
            'order_number' => $this->order->number,
            'store_id' => $this->order->store_id,
            'user_id' => $this->order->user_id,
            'message' => 'A new order has been created: ' . $this->order->number,
        ];
    }


    public function toBroadcast(object $notifiable)
    {
        $address = $this->order->billingAddress;

        return new BroadcastMessage([
            'body' => 'A New Order created',
            'icon' => 'fa fa-envelope',
            'url' => url('/dashboard/dashboard'),
            'order_id' => $this->order->id,
            'order_number' => $this->order->number,
            'store_id' => $this->order->store_id,
            'user_id' => $this->order->user_id,
            'message' => 'A new order has been created: ' . $this->order->number,
        ]);
        // return $x->toArray();
    }





    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
