<?php

namespace App\Repositories\StockInvoice;

use App\Models\StockInvoice;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class Repository.
 *
 * @package namespace App\Repositories;
 */
class StockInvoiceRepository extends BaseRepository implements StockInvoiceRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return StockInvoice::class;
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
