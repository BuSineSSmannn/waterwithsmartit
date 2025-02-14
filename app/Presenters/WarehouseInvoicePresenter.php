<?php

namespace App\Presenters;

use App\Transformers\WarehouseInvoice\WarehouseInvoiceAllTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class .
 *
 * @package namespace App\Presenters;
 */
class WarehouseInvoicePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return WarehouseInvoiceAllTransformer|TransformerAbstract
     */
    public function getTransformer(): WarehouseInvoiceAllTransformer|TransformerAbstract
    {
        return new WarehouseInvoiceAllTransformer();
    }
}
