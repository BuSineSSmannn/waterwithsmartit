<?php

namespace App\Presenters;

use App\Transformers\SizeTransformer;
use League\Fractal\TransformerAbstract;
use Override;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class .
 *
 * @package namespace App\Presenters;
 */
class SizePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return SizeTransformer|TransformerAbstract
     */
    #[Override]
    public function getTransformer(): SizeTransformer|TransformerAbstract
    {
        return new SizeTransformer();
    }
}
