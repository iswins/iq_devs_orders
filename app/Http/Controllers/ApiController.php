<?php

namespace App\Http\Controllers;

use App\Clients\AuthServiceClient;
use App\Exceptions\ServiceException;
use App\Jobs\ScoringRequest;
use App\Models\PaymentSchedule;
use App\Repositories\StatusRepository;
use App\Services\PaymentFormatter;
use App\Services\RequestFormatter;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use App\Models\Request as ModelRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;
use Validator;

class ApiController extends Controller
{


    public function newRequest($userId, Request $request) {
        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($request->all(), [
            'amount' => [
                'required',
                'integer',
                'min:100000',
            ],
            'term' => [
                'required',
                'integer',
                'min:6',
            ],
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            $userData = AuthServiceClient::getInstance()->getUserById($userId);
        } catch (ConnectException $exception) {
            return $this->error("Auth service is unavailable", 500);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 500);
        }

        $data = $validator->getData();

        $model = new ModelRequest();
        $model->user_id = $userId;
        $model->amount = $data['amount'];
        $model->term = $data['term'];
        $model->rate = 0;
        $model->inn = $userData['inn'];
        $model->status()->associate(StatusRepository::review());
        $model->save();

        ScoringRequest::dispatch($userData['inn'], $model->amount, $model->term, $model->id)
            ->onQueue('scoring_requests');

        return $this->success(RequestFormatter::getInstance($model)->toJson());
    }

    /**
     * @param $userId
     * @param Request $request
     * @return array
     */
    public function getList($userId, Request $request) {
        $rows = ModelRequest::query()
            ->with('status')
            ->with('product')
            ->where('user_id', '=', $userId)
            ->orderBy('id', 'desc')
            ->get();

        $ret = [];

        /** @var ModelRequest $row */
        foreach ($rows as $row) {
            $ret[] = RequestFormatter::getInstance($row)->toJson();
        }

        return $this->success($ret);
    }

    /**
     * @param $userId
     * @param $requestId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayments($userId, $requestId, Request $request) {

        /** @var ModelRequest $modelRequest */
        $modelRequest = ModelRequest::query()
            ->with('paymentSchedules')
            ->where('user_id', '=', $userId)
            ->where('id', '=', $requestId)
            ->first();

        if (!$modelRequest) {
            return $this->error("Request not found");
        }

        $ret = [];

        /** @var PaymentSchedule $row */
        foreach ($modelRequest->paymentSchedules as $row) {
            $ret[] = PaymentFormatter::getInstance($row)->toJson();
        }

        return $this->success($ret);
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data) {
        return response()->json($data, 200);
    }

    /**
     * @param MessageBag $messageBag
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validationError(MessageBag $messageBag) {
        $messages = $messageBag->getMessages();
        $fields = (new Collection($messages))->map(function($values, $field) {
            return ['field' => $field, 'error' => implode("; ", $values)];
        })->toArray();

        return response()->json(['message' => null, 'fields' => $fields], 400);
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message, $code = 400) {
        return response()->json(['message' => $message], $code);
    }
}
