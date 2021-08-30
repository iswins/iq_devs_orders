<?php
/**
 * Created by v.taneev.
 */


namespace App\Services;


use App\Models\Request;
use App\Repositories\StatusRepository;

class StatusPaidService implements StatusServiceInterface
{

    protected $request;

    public function __construct (Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest (): Request
    {
        return $this->request;
    }

    public function handle ()
    {
        $this->sendTelegramMessage();

        $request = $this->getRequest();
        $request->status()->associate(StatusRepository::success());
        $request->save();
    }

    protected function sendTelegramMessage() {

    }
}
