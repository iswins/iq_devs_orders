<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $color
 * @property string $code
 * @property string $created_at
 * @property string $updated_at
 * @property Request[] $requests
 */
class Status extends Model
{
    const REVIEW = 'review';
    const REFUSED = 'refused';
    const APPROVED = 'approved';
    const PAYMENT = 'payment';
    const SUCCESS = 'success';


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
    protected $fillable = ['name', 'color', 'created_at', 'updated_at', 'code'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany('App\Models\Request');
    }
}
