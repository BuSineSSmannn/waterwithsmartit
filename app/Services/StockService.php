<?php

namespace App\Services;


use App\Models\Stock;
use App\Repositories\Stock\StockRepository;
use App\Transformers\StockTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class StockService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, StockRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }

    /**
     * @throws RepositoryException
     */
    public function all(): array
    {
        $this->repository->pushCriteria(app(RequestCriteria::class));

        return $this->formatData($this->repository->paginate(),'stock');
    }


    public function show( $stock): array
    {
        $stock = $this->repository->skipPresenter()->find($stock);

        $fractal = new Manager();
        $resource = new Item($stock, new StockTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'stock');
    }

}
