<?php

namespace App\Services;


use App\Models\StockInvoice;
use App\Models\StockInvoiceItem;
use App\Presenters\StockInvoicePresenter;
use App\Repositories\StockInvoice\StockInvoiceRepository;
use App\Transformers\StockInvoiceTransformer;
use Carbon\Carbon;
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

        $invoice = $this->updateItems($invoice, $data);

        return $this->show($invoice);
    }


    /**
     */
    public function update(StockInvoice $invoice, $data): array
    {

        $invoice->update([
            'supplier_id' => $data['supplier_id'],
            'trx_type' => $data['trx_type'],
        ]);

        $invoice->stockInvoiceItems()->delete();

        $updated_data = $this->updateItems($invoice, $data);


        return $this->show($updated_data);
    }

   protected function updateItems(StockInvoice $invoice, $data): StockInvoice
   {
       $sum = 0;

       foreach ( $data['items']  as  $item) {
           $sum += $item['price'] * $item['quantity'];
           StockInvoiceItem::create([
               'stock_invoice_id' => $invoice->id,
               'product_id' => $item['product_id'],
               'quantity' => $item['quantity'],
               'price' => $item['price'],
               'sale_price' => $item['sale_price'],
               'date_expire' => Carbon::create($item['date_expire'])?->format('Y-m-d'),
           ]);
       }

       $invoice->update([
           'total_amount' => $sum
       ]);

       return $invoice;
   }




}
