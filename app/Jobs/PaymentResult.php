<?php
/**
 * Created by v.taneev.
 */


namespace App\Jobs;

use App\Models\Request;
use App\Repositories\StatusRepository;
use App\Services\StatusApprovedService;
use App\Services\StatusPaidService;
use App\Services\StatusRefusedService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class PaymentResult implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $requestId;

    /**
     * @return mixed
     */
    public function getRequestId ()
    {
        return $this->requestId;
    }
    public function handle() {

        $requestId = $this->getRequestId();

        if (!$requestId) {
            throw new Exception("Request isn't set");
        }

        /** @var Request $request */
        $request = Request::query()
            ->where('id', '=', $requestId)
            ->first();

        if (!$request) {
            throw new Exception("Request #{$requestId} not found!");
        }

        $statusService = new StatusPaidService($request);
        $statusService->handle();
    }
}
