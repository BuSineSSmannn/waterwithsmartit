<?php

namespace App\Presenters;

use App\Transformers\BranchTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class .
 *
 * @package namespace App\Presenters;
 */
class BranchPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return BranchTransformer|TransformerAbstract
     */
    public function getTransformer(): BranchTransformer|TransformerAbstract
    {
        return new BranchTransformer();
    }
}
