<?php

namespace warehouse\Mail;

use warehouse\Models\Warehouse_order_customer_pic;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    protected $warehouse_order_pic;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Warehouse_order_customer_pic $warehouse_order_pic)
    {
        $this->warehouse_order_customer_pic = $warehouse_order_pic;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $id = array();
        foreach ($this->warehouse_order_customer_pic->pics_whs as $value) {
            # code...
            foreach ($value->cek_status_orders_pic as $status_order) {
                # code...
                return $this->markdown('emails.orders.shipped')->with([
                    'SO' => $status_order->status_name,
                    'OrderId' => $value->order_id,
                    'RatePrice' => $value->total_rate,
                    'Email' => $this->warehouse_order_customer_pic->to_do_list_cspics->email,
                    'Nama' => $this->warehouse_order_customer_pic->to_do_list_cspics->name,
                    'id' => $this->warehouse_order_customer_pic->id,
                ]);
            }
        }
    }
}
