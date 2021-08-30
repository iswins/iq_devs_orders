<?php
/**
 * Created by v.taneev.
 */


namespace App\Services;


use App\Models\Request;

interface StatusServiceInterface
{
    public function __construct(Request $request);
    public function handle();
}
