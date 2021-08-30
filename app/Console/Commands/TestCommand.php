<?php
/**
 * Created by v.taneev.
 */


namespace App\Console\Commands;


use App\Jobs\ScoringRequest;
use App\Jobs\ScoringResult;
use App\Models\Request;
use App\Services\CreditPaymentsGenerator;
use App\Services\LoadAmortizationCalculator;
use App\Services\StatusApprovedService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestCommand extends Command
{

    //{"uuid":"ff98adb8-6c84-46c1-95b5-1f49cc73a5d5","displayName":"App\\Jobs\\ScoringStartJob","job":"Illuminate\\Queue\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\Jobs\\ScoringStartJob","command":"O:24:\"App\\Jobs\\ScoringStartJob\":13:{s:14:\"\u0000*\u0000companyName\";s:12:\"test company\";s:6:\"\u0000*\u0000inn\";i:11111;s:9:\"\u0000*\u0000userId\";s:3:\"666\";s:3:\"job\";N;s:10:\"connection\";N;s:5:\"queue\";s:16:\"scoring_requests\";s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:19:\"chainCatchCallbacks\";N;s:5:\"delay\";N;s:11:\"afterCommit\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}}"},"id":"b956c7cd-81d7-4957-9ebe-4c89f164d798"}

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tests:custom';

    public function handle()
    {
        /*
        $output = $this->getOutput();
        $inn = rand(111111111, 99999999);
        $requestId = rand(1111, 99999999);
        ScoringRequest::dispatch($inn, "300000", '12', $requestId)
            ->onQueue('scoring_requests');

        print $requestId . "\n";
        */

        /*
        $test = new ScoringResult(2, 11);
        $test->handle();
        */

        /** @var Request $request */
        $request = Request::query()
            ->where('id', '=', '32')
            ->first();

        $request->rate = 15;
        $request->save();

        (new StatusApprovedService($request))->handle();
    }
}

