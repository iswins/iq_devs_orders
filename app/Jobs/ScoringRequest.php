<?php
/**
 * Created by v.taneev.
 */


namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScoringRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inn;
    protected $amount;
    protected $term;
    protected $requestId;

    public function __construct($inn, $amount, $term, $requestId) {
        $this->inn = $inn;
        $this->amount = $amount;
        $this->term = $term;
        $this->requestId = $requestId;
    }

}
