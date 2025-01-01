<?php

namespace App\Services;


use App\Models\StockInvoice;
use App\Presenters\StockInvoicePresenter;
use App\Repositories\StockInvoice\StockInvoiceRepository;
use App\Transformers\StockInvoiceTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Prettus\Validator\Exceptions\ValidatorException;

class StockInvoiceService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, StockInvoiceRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }


    public function all(): array
    {
        return $this->formatData($this->repository->setPresenter(ColorPresenter::class)->paginate(),'colors');
    }


    public function show(StockInvoice $color): array
    {
        $fractal = new Manager();
        $resource = new Item($color, new StockInvoiceTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'stock_invoice');
    }


    /**
     * @throws ValidatorException
     */
    public function create($data): array
    {

        $invoice =  $this->repository->create([
            'supplier_id' => $data['supplier_id'],
            'user_id' => auth('api')->user()->id,
            'trx_type' => $data['trx_type'],
            'status' => 'draft'
        ]);

        dd($invoice)  ;

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
