<?php

namespace App\Presenters;

use App\Transformers\ColorTransformer;
use League\Fractal\TransformerAbstract;
use Override;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class .
 *
 * @package namespace App\Presenters;
 */
class ColorPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return ColorTransformer|TransformerAbstract
     */
    #[Override]
    public function getTransformer(): ColorTransformer|TransformerAbstract
    {
        return new ColorTransformer();
    }
}
