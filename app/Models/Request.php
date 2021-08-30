<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $status_id
 * @property integer $product_id
 * @property integer $user_id
 * @property float $amount
 * @property int $term
 * @property float $rate
 * @property string $inn
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Product $product
 * @property Status $status
 * @property PaymentSchedule[] $paymentSchedules
 */
class Request extends Model
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
    protected $fillable = ['status_id', 'product_id', 'user_id', 'amount', 'rate', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentSchedules()
    {
        return $this->hasMany('App\Models\PaymentSchedule');
    }
}
