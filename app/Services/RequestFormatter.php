<?php
/**
 * Created by v.taneev.
 */


namespace App\Services;


use App\Models\Request;

class RequestFormatter
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

    public function toJson() {
        $request = $this->getRequest();
        return [
            'id' => $request->id,
            'date' => $request->created_at->format('d.m.Y H:i'),
            'amount' => $request->amount,
            'term' => $request->term,
            'status' => [
                'id' => $request->status->id,
                'name' => $request->status->name,
                'color' => $request->status->color,
            ],
            'product' => $request->product ?  [
                'id' => $request->product->id,
                'name' => $request->product->name,
                'credit_rate' => $request->product->credit_rate,
            ] : null,
            'rate' => $request->rate,
        ];
    }
}
