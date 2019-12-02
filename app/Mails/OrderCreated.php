<?php

namespace App\Mails;


use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderCreated extends Mailable
{

    use SerializesModels, Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $this->order->total = 0;

        foreach ($this->order->pastries()->get() as $pastry) {
            $this->order->total += $pastry->price;
        }
        return $this
            ->view("emails.orders.create")
            ->with([
                'order'   => $this->order,
                'client'  => $this->order->client()->get()[0],
                'pastries' => $this->order->pastries()->get()
            ]);
    }

}
