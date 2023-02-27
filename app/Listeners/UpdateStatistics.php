<?php

namespace App\Listeners;

use App\Events\ExceptionWasCreated;
use App\Models\Statistic;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateStatistics implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(ExceptionWasCreated $event)
    {
        $statistics = Statistic::firstOrCreate([
            'total_exceptions' => 0,
        ]);

        $statistics->total_exceptions++;
        $statistics->save();
    }
}
