<?php

namespace App\Presenters;

use App\Transformers\StockInvoiceTransformer;
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
    public function getTransformer(): StockInvoiceTransformer|TransformerAbstract
    {
        return new StockInvoiceTransformer();
    }
}
