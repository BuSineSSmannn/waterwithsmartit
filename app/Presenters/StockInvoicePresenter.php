<?php

namespace App\Presenters;

use App\Transformers\StockInvoice\StockInvoiceAllTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class .
 *
 * @package namespace App\Presenters;
 */
class StockInvoicePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return StockInvoiceTransformer|TransformerAbstract
     */
    public function getTransformer(): StockInvoiceAllTransformer|TransformerAbstract
    {
        return new StockInvoiceAllTransformer();
    }
}
