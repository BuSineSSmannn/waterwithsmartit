<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Transformers\ProductTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Prettus\Validator\Exceptions\ValidatorException;
use RuntimeException;
use Whoops\Run;

class ProductService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, ProductRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }


    public function all(): array
    {
        return $this->formatData($this->repository->paginate(),'products');
    }


    public function show(Product $product): array
    {
        $fractal = new Manager();
        $resource = new Item($product, new ProductTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'product');
    }


    /**
     * @throws ValidatorException
     */
    public function create($data): array
    {

        $product =  $this->repository->skipPresenter()->create($data);

        $product->refresh();
        return $this->show($product);
    }


    /**
     * @throws ValidatorException
     */
    public function update(Product $product, $data): array
    {
        $updated_data = $this->repository->skipPresenter()->update($data,$product->id);

        return $this->show($updated_data);
    }

    public function delete(Product $product): ?bool
    {
        return $product->delete();
    }

    public function connectBarcodeToMxik($mxik, $barcode): array
    {

        $product = Product::where('mxik_code', $mxik)->where('barcode',$barcode)->first();


        if($product){
            throw new RuntimeException('Product already connected');
        }

        $product = Product::where('mxik_code', $mxik)->first();



        if($product->barcode){
            $new_product = $product->replicate();
            $new_product->barcode = $barcode;
            $new_product->status = 'active';
            $new_product->is_imported = '0';
            $new_product->price = 0.00;
            $new_product->save();
            return $this->show($new_product);
        }

        $product->barcode = $barcode;
        $product->save();
        return $this->show($product);

    }


}
