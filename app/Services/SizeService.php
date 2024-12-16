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


    public function show(Size $color): array
    {
        $fractal = new Manager();
        $resource = new Item($color, new SizeTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'size');
    }


    /**
     * @throws ValidatorException
     */
    public function create($data): array
    {

        $color =  $this->repository->skipPresenter()->create($data);

        $color->refresh();
        return $this->show($color);
    }


    /**
     * @throws ValidatorException
     */
    public function update(Size $color, $data): array
    {
        $updated_data = $this->repository->skipPresenter()->update($data,$color->id);

        return $this->show($updated_data);
    }

    public function delete(Size $color): ?bool
    {
        return $color->delete();
    }


}
