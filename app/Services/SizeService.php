<?php

namespace App\Services;


use App\Models\Size;
use App\Repositories\Size\SizeRepository;
use App\Transformers\SizeTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Prettus\Validator\Exceptions\ValidatorException;

class SizeService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, SizeRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }


    public function all(): array
    {
        return $this->formatData($this->repository->paginate(),'sizes');
    }


    public function show(Size $size): array
    {
        $fractal = new Manager();
        $resource = new Item($size, new SizeTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'size');
    }


    /**
     * @throws ValidatorException
     */
    public function create($data): array
    {

        $size =  $this->repository->skipPresenter()->create($data);

        $size->refresh();
        return $this->show($size);
    }


    /**
     * @throws ValidatorException
     */
    public function update(Size $size, $data): array
    {
        $updated_data = $this->repository->skipPresenter()->update($data,$size->id);

        return $this->show($updated_data);
    }

    public function delete(Size $size): ?bool
    {
        return $size->delete();
    }


}
