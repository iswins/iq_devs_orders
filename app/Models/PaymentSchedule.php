<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $request_id
 * @property float $loan_body
 * @property float $loan_percent
 * @property float $amount
 * @property Carbon $date
 * @property string $created_at
 * @property string $updated_at
 * @property Request $request
 */
class PaymentSchedule extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_schedule';
    public $timestamps = [ "created_at", "updated_at" ];

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['request_id', 'loan_body', 'loan_percent', 'amount', 'date', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function request()
    {
        return $this->belongsTo('App\Models\Request');
    }
}
