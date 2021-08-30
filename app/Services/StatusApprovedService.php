<?php
/**
 * Created by v.taneev.
 */


namespace App\Services;


use App\Jobs\PaymentRequest;
use App\Jobs\ScoringRequest;
use App\Models\Product;
use App\Models\Request;
use App\Repositories\StatusRepository;
use Exception;

class StatusApprovedService implements StatusServiceInterface
{

    protected $request;

    public function __construct (Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest (): Request
    {
        return $this->request;
    }

    /**
     * @return Product
     */
    protected function getProduct() {
        $product = Product::query()
            ->where('rate_from', '<=', $this->getRequest()->rate)
            ->where('rate_to', '>=', $this->getRequest()->rate)
            ->first();

        if (!$product) {
            throw new Exception("Product not found for rate: {$this->getRequest()->rate}");
        }

        return $product;
    }

    public function handle ()
    {
        $request = $this->getRequest();
        $request->status()->associate(StatusRepository::payment());
        $request->product()->associate($this->getProduct());
        $request->save();

        CreditPaymentsGenerator::getInstance($request)->generate();

        PaymentRequest::dispatch($request->inn, $request->amount, $request->id)
            ->onQueue('payments_requests');
    }
}
