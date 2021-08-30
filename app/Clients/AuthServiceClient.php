<?php
/**
 * Created by v.taneev.
 */


namespace App\Clients;


class AuthServiceClient extends AbstractRestClient
{

    protected function getServiceName ()
    {
        return 'auth';
    }

    public function getUserById($id) {
        $url = "/api/user/{$id}/";
        return $this->get($url);
    }
}
