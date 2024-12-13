<?php

namespace App\Presenters;

use App\Transformers\CategoryTransformer;
use League\Fractal\TransformerAbstract;
use Override;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class .
 *
 * @package namespace App\Presenters;
 */
class CategoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return CategoryTransformer|TransformerAbstract
     */
    #[Override]
    public function getTransformer(): CategoryTransformer|TransformerAbstract
    {
        return new CategoryTransformer();
    }
}
