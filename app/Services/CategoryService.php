<?php

namespace App\Services;


use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Prettus\Validator\Exceptions\ValidatorException;

class CategoryService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, CategoryRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }


    public function all(): array
    {
        return $this->formatData($this->repository->paginate(),'categories');
    }


    public function show(Category $category): array
    {
        $fractal = new Manager();
        $resource = new Item($category, new CategoryTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'category');
    }


    /**
     * @throws ValidatorException
     */
    public function create($data): array
    {

        $category =  $this->repository->skipPresenter()->create($data);

        $category->refresh();
        return $this->show($category);
    }


    /**
     * @throws ValidatorException
     */
    public function update(Category $category, $data): array
    {
        $updated_data = $this->repository->skipPresenter()->update($data,$category->id);

        return $this->show($updated_data);
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }


}
