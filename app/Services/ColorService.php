<?php

namespace App\Services;


use App\Models\Color;
use App\Presenters\ColorPresenter;
use App\Repositories\Color\ColorRepository;
use App\Transformers\ColorTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Prettus\Validator\Exceptions\ValidatorException;

class ColorService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, ColorRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }


    public function all(): array
    {
        return $this->formatData($this->repository->setPresenter(ColorPresenter::class)->paginate(),'colors');
    }


    public function show(Color $color): array
    {
        $fractal = new Manager();
        $resource = new Item($color, new ColorTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'color');
    }


    /**
     * @throws ValidatorException
     */
    public function create($data): array
    {

        $color =  $this->repository->create($data);

        $color->refresh();
        return $this->show($color);
    }


    /**
     * @throws ValidatorException
     */
    public function update(Color $color, $data): array
    {
        $updated_data = $this->repository->update($data,$color->id);

        return $this->show($updated_data);
    }

    public function delete(Color $color): ?bool
    {
        return $color->delete();
    }




}
