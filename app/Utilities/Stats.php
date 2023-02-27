<?php

namespace App\Utilities;

use App\Models\Exception;
use App\Models\Order;

/**
 * @property mixed orderGrowth
 * @property mixed exceptionGrowth
 */
class Stats
{
    /**
     * @return array
     */
    public function exceptionGrowth()
    {
        $exceptions = Exception::query()->where('created_at', '>=', carbon()->subDays(30))
            ->where('created_at', '<=', carbon())
            ->oldest()
            ->get();

        $stats = [];

        foreach ($exceptions as $exception) {
            if (! isset($stats[$exception->created_at->format('d-m-Y')])) {
                $stats[$exception->created_at->format('d-m-Y')]['total'] = 0;
            }

            $stats[$exception->created_at->format('d-m-Y')]['total']++;
            $stats[$exception->created_at->format('d-m-Y')]['exceptions'][] = $exception;
        }

        return collect($stats);
    }

    /**
     * @return array
     */
    public function orderGrowth()
    {
        $orders = Order::paid()->where('created_at', '>=', carbon()->subDays(30))
            ->where('created_at', '<=', carbon())
            ->get([
                'created_at',
            ]);

        $stats = [];

        foreach ($orders as $order) {
            if (! isset($stats[$order->created_at->format('d-m-Y')])) {
                $stats[$order->created_at->format('d-m-Y')]['total'] = 0;
            }

            $stats[$order->created_at->format('d-m-Y')]['total']++;
            $stats[$order->created_at->format('d-m-Y')]['orders'][] = $order;
        }

        return $stats;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }

        $message = '%s does not respond to the %s property or method.';

        throw new \Exception(sprintf($message, static::class, $property));
    }
}
