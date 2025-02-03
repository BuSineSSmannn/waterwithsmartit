<?php

namespace App\Services;


use App\Enums\InvoiceEnum;
use App\Enums\MovementProductType;
use App\Models\Stock;
use App\Models\StockInvoice;
use App\Models\StockInvoiceItem;
use App\Models\StockMovement;
use App\Presenters\StockInvoicePresenter;
use App\Repositories\StockInvoice\StockInvoiceRepository;
use App\Transformers\StockInvoice\StockInvoiceTransformer;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use RuntimeException;
use Throwable;

class StockInvoiceService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, StockInvoiceRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }


    public function all(): array
    {
        return $this->formatData($this->repository->setPresenter(StockInvoicePresenter::class)->paginate(),'stock_invoices');
    }


    public function show(StockInvoice $color): array
    {
        $fractal = new Manager();
        $resource = new Item($color, new StockInvoiceTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'stock_invoice');
    }


    /**
     */
    public function create($data): array
    {
        try{
            $this->beginTransaction();

            $invoice =  $this->repository->create([
                'supplier_id' => $data['supplier_id'],
                'user_id' => auth('api')->user()?->id,
                'trx_type' => $data['trx_type'],
                'status' => 'draft'
            ]);

            $invoice = $this->updateItems($invoice, $data);

            $this->commit();

            return $this->show($invoice);


        }catch (Throwable $e){
            throw new RuntimeException($e->getMessage());
        }
    }


    /**
     */
    public function update(StockInvoice $invoice, $data): array
    {

        try{
            $this->beginTransaction();

            $invoice->update([
                'supplier_id' => $data['supplier_id'],
                'trx_type' => $data['trx_type'],
            ]);

            $invoice->items()->delete();

            $updated_data = $this->updateItems($invoice, $data);

            $this->commit();

            return $this->show($updated_data);


        }catch (Throwable $e){
            throw new RuntimeException($e->getMessage());
        }



    }


    public function reject(StockInvoice $invoice): array
    {
        $invoice->update([
           'status' => InvoiceEnum::REJECTED
        ]);

        return $this->show($invoice);
    }

    /**
     * @throws Exception|Throwable
     */
    public function confirm(StockInvoice $invoice): array
    {

        try{
            $this->beginTransaction();

            $invoice->update([
                'status' => InvoiceEnum::CONFIRMED
            ]);


            foreach ($invoice->items as $item) {
                $stock = Stock::createOrFirst([
                    'product_id' => $item->product_id,
                    'trx_type' => $invoice->trx_type,
                    'arrival_price' => $item->arrival_price,
                    'price' => $item->price,
                    'date_expire' => $item->date_expire,
                ]);

                $stock->update([
                    'quantity' => $stock->quantity + $item->quantity
                ]);

                StockMovement::create([
                    'stock_id' => $stock->id,
                    'invoice_id' => $invoice->id,
                    'user_id' => auth('api')->user()?->id,
                    'type' => MovementProductType::ARRIVAL,
                    'purchase_price' => $item->arrival_price,
                    'quantity' => $item->quantity,
                    'date_expire' => $item->date_expire,
                    'description' => "Приходная накладная от поставщика No $invoice->id - {$invoice->supplier->name}"
                ]);
            }


            $this->commit();

            return $this->show($invoice);
        }catch (Throwable $e){
            throw new RuntimeException($e->getMessage());
        }
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
               'arrival_price' => $item['arrival_price'],
               'price' => $item['price'],
               'date_expire' => Carbon::create($item['date_expire'])?->format('Y-m-d'),
           ]);
       }

       $invoice->update([
           'total_amount' => $sum
       ]);

       return $invoice;
   }

}
