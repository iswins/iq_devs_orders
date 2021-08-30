<?php
/**
 * Created by v.taneev.
 */


namespace App\Repositories;


use App\Models\Status;

class StatusRepository
{
    protected static $statuses = [];

    /**
     * @param $code
     * @return Status
     */
    protected static function getStatusByCode($code) {
        if (isset(static::$statuses[$code])) {
            return static::$statuses[$code];
        }

        return static::$statuses[$code] = Status::query()
            ->where('code', '=', $code)
            ->first();
    }

    /**
     * @return Status
     */
    public static function review() {
        return static::getStatusByCode(Status::REVIEW);
    }

    /**
     * @return Status
     */
    public static function refused() {
        return static::getStatusByCode(Status::REFUSED);
    }

    /**
     * @return Status
     */
    public static function approved() {
        return static::getStatusByCode(Status::APPROVED);
    }

    /**
     * @return Status
     */
    public static function payment() {
        return static::getStatusByCode(Status::PAYMENT);
    }

    /**
     * @return Status
     */
    public static function success() {
        return static::getStatusByCode(Status::SUCCESS);
    }
}
