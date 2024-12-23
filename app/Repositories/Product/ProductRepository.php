<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Presenters\ProductPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class Repository.
 *
 * @package namespace App\Repositories;
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Product::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function presenter(): string
    {
        return ProductPresenter::class;
    }


    protected $fieldSearchable = [
        'name' => 'like',
        'productBrand.name' => 'like',
        'mxik_code' => 'like',
        'barcode' => 'like',
    ];
}
