<?php
/**
 * Created by Praneeth Nidarshan
 */


namespace App\Services;


class LoadAmortizationCalculator
{
    private $loanAmount;
    private $termYears;
    private $interest;
    private $terms;
    private $period;
    private $principal;
    private $balance;
    private $termPay;

    public function __construct($data)
    {
        if($this->validate($data)) {
            $this->loanAmount 	= (float) $data['loan_amount'];
            $this->termYears 	= (int) $data['term_years'];
            $this->interest 	= (float) $data['interest'];
            $this->terms 		= (int) $data['terms'];

            $this->terms = ($this->terms == 0) ? 1 : $this->terms;

            $this->period = $this->terms * $this->termYears;
            $this->interest = ($this->interest /100 ) / $this->terms;
        }
    }

    private function validate($data) {
        $dataFormat = [
            'loan_amount' 	=> 0,
            'term_years' 	=> 0,
            'interest' 		=> 0,
            'terms' 		=> 0
        ];

        $validateData = array_diff_key($dataFormat,$data);

        if ($validateData) {
            throw new \Exception("Invalid input data to calculation");
        }

        return true;
    }

    private function calculate()
    {
        $deno = 1 - 1 / pow( (1+ $this->interest), $this->period);

        $this->termPay = ($this->loanAmount * $this->interest) / $deno;
        $interest = $this->loanAmount * $this->interest;

        $this->principal = $this->termPay - $interest;
        $this->balance = $this->loanAmount - $this->principal;

        return [
            'payment' 	=> $this->termPay,
            'interest' 	=> $interest,
            'principal' => $this->principal,
            'balance' 	=> $this->balance
        ];
    }

    public function getSummary()
    {
        $this->calculate();
        $totalPay = $this->termPay *  $this->period;
        $totalInterest = $totalPay - $this->loanAmount;

        return [
            'total_pay' => $totalPay,
            'total_interest' => $totalInterest,
        ];
    }

    public function getSchedule ()
    {
        $schedule = [];

        while  ($this->balance >= 0) {
            array_push($schedule, $this->calculate());
            $this->loanAmount = $this->balance;
            $this->period--;
        }

        return $schedule;
    }


}
