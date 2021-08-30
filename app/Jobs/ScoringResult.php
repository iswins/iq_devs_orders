<?php
/**
 * Created by v.taneev.
 */


namespace App\Jobs;

use App\Models\Request;
use App\Repositories\StatusRepository;
use App\Services\StatusApprovedService;
use App\Services\StatusRefusedService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class ScoringResult implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $requestId;
    protected $rate;

    public function __construct($requestId, $rate) {
        $this->requestId = $requestId;
        $this->rate = $rate;
    }

    /**
     * @return mixed
     */
    public function getRequestId ()
    {
        return $this->requestId;
    }

    /**
     * @return mixed
     */
    public function getRate ()
    {
        return $this->rate;
    }

    public function handle() {

        $requestId = (int)$this->getRequestId();
        $rate = (int)$this->getRate();

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

        $request->rate = $rate;
        $request->save();

        if ($rate <= 0) {
            $statusService = new StatusRefusedService($request);
        } else {
            $statusService = new StatusApprovedService($request);
        }

        $statusService->handle();
    }
}
