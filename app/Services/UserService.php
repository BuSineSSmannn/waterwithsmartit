<?php

namespace App\Services;


use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Transformers\UserTransformer;
use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Prettus\Validator\Exceptions\ValidatorException;

class UserService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, UserRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }


    public function all(): array
    {
        return $this->formatData($this->repository->paginate(),'users');
    }


    public function show(User $user): array
    {
        $fractal = new Manager();
        $resource = new Item($user, new UserTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'user');
    }


    /**
     * @throws ValidatorException
     */
    public function create($data): array
    {
        try{
            DB::beginTransaction();

            $user =  $this->repository->skipPresenter()->create($data);

            $user->roles()->attach($data['roles']);

            $user->branches()->attach($data['branches']);

            DB::commit();

            return $this->show($user);
        }catch (Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }


    public function update(User $user,$data)
    {
       try{
           DB::beginTransaction();

           $user->update($data);

           $user->roles()->sync($data['roles']);

           $user->branches()->sync($data['branches']);

           DB::commit();

           return $this->show($user);
       }catch (Exception $e){
           DB::rollBack();
           dd($e->getMessage());
       }
    }

    public function delete(User $user): ?bool
    {
        return $user->delete();
    }

}
