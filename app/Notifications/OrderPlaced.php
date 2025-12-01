<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlaced extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
{
    return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('تأكيد الطلب')
                ->greeting('مرحباً ' . $this->order->name)
                ->line('شكراً لطلبك! تم استلام طلبك بنجاح.')
                ->line('المجموع: ' . number_format($this->order->total, 2) . ' دج')
                ->line('كود الخصم: ' . ($this->order->coupon_code ?? 'لا يوجد'))
                ->line('نأمل أن تستمتع بالتسوق معنا!');
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
            //
        ];
    }
}
