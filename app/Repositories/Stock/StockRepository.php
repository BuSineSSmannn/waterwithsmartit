<?php

namespace App\Repositories\Stock;

use App\Models\Stock;
use App\Presenters\StockPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class Repository.
 *
 * @package namespace App\Repositories;
 */
class StockRepository extends BaseRepository implements StockRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Stock::class;
    }


    public function presenter(): string
    {
        return StockPresenter::class;
    }


    protected $fieldSearchable = [
        'id',
        'product.name' => 'like',
    ];
}
