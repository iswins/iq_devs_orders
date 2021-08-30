<?php
/**
 * Created by v.taneev.
 */


namespace App\Services;


use App\Models\PaymentSchedule;
use App\Models\Request;
use Carbon\Carbon;

class CreditPaymentsGenerator
{
    protected $request;

    protected function __construct(Request  $request) {
        $this->request = $request;
    }

    public static function getInstance(Request $request) {
        return new static($request);
    }

    /**
     * @return Request
     */
    public function getRequest (): Request
    {
        return $this->request;
    }

    public function generate() {
        $request = $this->getRequest();


        $date = new Carbon();
        $rate = $request->product->credit_rate;
        $amount = $request->amount;


        $data = [
            'loan_amount' 	=> (float)$amount,
            'term_years' 	=> $request->term / 12,
            'interest' 		=> $rate,
            'terms' 		=> 12
        ];

        $amortization = new LoadAmortizationCalculator($data);
        $schedulesArray = $amortization->getSchedule();
        foreach ($schedulesArray as $scheduleRow) {
            $date->modify("+1 month");
            $payment = new PaymentSchedule();
            $payment->request()->associate($request);
            $payment->date = clone $date;
            $payment->loan_body = $scheduleRow['principal'];
            $payment->loan_percent = $scheduleRow['interest'];
            $payment->amount = $scheduleRow['payment'];
            $payment->save();
        }
    }
}
