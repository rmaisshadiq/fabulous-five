<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateOrderStatus extends Command
{
    protected $signature = 'orders:update-status';
    protected $description = 'Update order status based on booking dates';

    public function handle()
    {
        $now = Carbon::now();
        $this->info("Running status check at: {$now->toDateTimeString()} ({$now->getTimezone()->getName()})");

        // --- LOGIC 1: Update 'confirmed' to 'in_progress' ---
        $startingOrders = Order::where('status', 'completed')
            ->where('start_booking_date', '<=', $now)
            ->where('end_booking_date', '>=', $now) // Check end_date in the same query
            ->get();

        if ($startingOrders->isNotEmpty()) {
            $this->info("Found {$startingOrders->count()} orders to start.");
            foreach ($startingOrders as $order) {
                $order->status = 'in_progress';
                $order->save();
                $this->info(" -> Order #{$order->id} status updated to 'in_progress'.");
            }
        }

        // --- LOGIC 2: Update 'in_progress' to 'due' ---
        $dueOrders = Order::where('status', 'in_progress')
            ->where('end_booking_date', '<', $now)
            ->get();

        if ($dueOrders->isNotEmpty()) {
            $this->info("Found {$dueOrders->count()} orders that are now due.");
            foreach ($dueOrders as $order) {
                $order->status = 'due';
                $order->save();
                $this->info(" -> Order #{$order->id} status updated to 'due'.");
            }
        }

        $this->info('Order status update check complete.');
    }
}
