<?php
/**
 * Created by v.taneev.
 */


namespace App\Services;


use App\Models\PaymentSchedule;
use Carbon\Carbon;

class PaymentFormatter
{
    /**
     * @var PaymentSchedule
     */
    protected $paymentSchedule;

    protected function __construct(PaymentSchedule $paymentSchedule) {
        $this->paymentSchedule = $paymentSchedule;
    }

    public static function getInstance(PaymentSchedule $paymentSchedule) {
        return new static($paymentSchedule);
    }

    /**
     * @return PaymentSchedule
     */
    public function getPaymentSchedule (): PaymentSchedule
    {
        return $this->paymentSchedule;
    }



    public function toJson() {
        $payment = $this->getPaymentSchedule();
        return [
            'date' => (new Carbon($payment->date))->format('d.m.Y'),
            'body' => $payment->loan_body,
            'percent' => $payment->loan_percent,
            'amount' => $payment->amount,
        ];
    }
}
