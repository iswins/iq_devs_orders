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

class PaymentRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inn;
    protected $amount;
    protected $requestId;

    public function __construct($inn, $amount, $requestId) {
        $this->inn = $inn;
        $this->amount = $amount;
        $this->requestId = $requestId;
    }

}
