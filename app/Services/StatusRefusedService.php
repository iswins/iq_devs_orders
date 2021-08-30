<?php
/**
 * Created by v.taneev.
 */


namespace App\Services;


use App\Models\Request;
use App\Repositories\StatusRepository;

class StatusRefusedService implements StatusServiceInterface
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
        $request = $this->getRequest();
        $request->status()->associate(StatusRepository::refused());
        $request->save();
    }
}
