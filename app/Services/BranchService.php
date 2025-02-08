<?php

namespace App\Services;


use App\Models\Branch;
use App\Repositories\Branch\BranchRepository;
use \App\Presenters\BranchPresenter;
use App\Transformers\BranchTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Prettus\Validator\Exceptions\ValidatorException;

class BranchService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, BranchRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }


    public function all(): array
    {
        return $this->formatData($this->repository->setPresenter(BranchPresenter::class)->paginate(),'branches');
    }


    public function getAll(): array
    {
        return $this->formatData($this->repository->setPresenter(BranchPresenter::class)->all(),'branches');
    }


    public function show(Branch $branch): array
    {
        $fractal = new Manager();
        $resource = new Item($branch, new BranchTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'branch');
    }


    /**
     * @throws ValidatorException
     */
    public function create($data): array
    {

        $branch = $this->repository->create($data);

        return $this->show($branch);
    }


    /**
     * @throws ValidatorException
     */
    public function update(Branch $branch, $data): array
    {
        $updated_data = $this->repository->update($data,$branch->id);

        return $this->show($updated_data);
    }

    public function delete(Branch $branch): ?bool
    {
        return $branch->delete();
    }


}
