<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property integer $rate_from
 * @property integer $rate_to
 * @property float $credit_rate
 * @property string $code
 * @property string $created_at
 * @property string $updated_at
 * @property Request[] $requests
 */
class Product extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';
    public $timestamps = [ "created_at", "updated_at" ];

    /**
     * @var array
     */
    protected $fillable = ['name', 'rate_from', 'rate_to', 'rate', 'created_at', 'updated_at', 'code'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany('App\Models\Request');
    }
}
