<?php

namespace App\Repositories\Size;

use App\Models\Size;
use App\Presenters\SizePresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class Repository.
 *
 * @package namespace App\Repositories;
 */
class SizeRepository extends BaseRepository implements SizeRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Size::class;
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
        return SizePresenter::class;
    }


    protected $fieldSearchable = [
        'name' => 'like',
        'category.name' => 'like',
        'id'
    ];
}
