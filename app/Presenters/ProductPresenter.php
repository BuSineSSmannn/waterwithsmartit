<?php

namespace App\Presenters;

use App\Transformers\ProductTransformer;
use League\Fractal\TransformerAbstract;
use Override;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class .
 *
 * @package namespace App\Presenters;
 */
class ProductPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return ProductTransformer|TransformerAbstract
     */
    #[Override]
    public function getTransformer(): ProductTransformer|TransformerAbstract
    {
        return new ProductTransformer();
    }
}
