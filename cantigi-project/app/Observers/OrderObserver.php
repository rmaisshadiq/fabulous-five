<?php

namespace App\Observers;

use App\Mail\ReturnReminderMail;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // 1. Check if the 'status' field was actually changed in this update
        // 2. Check if the new value for 'status' is 'due'
        if ($order->isDirty('status') && $order->status === 'due') {
            
            // Make sure the customer and user relationship exists to get the email
            if ($order->customer?->user?->email) {
                Mail::to($order->customer->user->email)->send(new ReturnReminderMail($order));
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
