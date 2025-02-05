<?php

namespace App\Services;


use App\Models\Stock;
use App\Repositories\Stock\StockRepository;
use App\Transformers\StockTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class StockService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, StockRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }

    public function all(): array
    {
        return $this->formatData($this->repository->paginate(),'stock');
    }


    public function show(Stock $stock): array
    {
        $fractal = new Manager();
        $resource = new Item($stock, new StockTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'stock');
    }

}
