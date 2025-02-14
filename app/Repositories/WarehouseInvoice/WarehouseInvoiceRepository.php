<?php

namespace App\Repositories\WarehouseInvoice;

use App\Models\WarehouseInvoice;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class Repository.
 *
 * @package namespace App\Repositories;
 */
class WarehouseInvoiceRepository extends BaseRepository implements WarehouseInvoiceRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return WarehouseInvoice::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    protected $fieldSearchable = [
        'id'
    ];
}
