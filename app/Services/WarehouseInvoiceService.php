<?php

namespace App\Services;


use App\Enums\InvoiceEnum;
use App\Enums\MovementProductType;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Warehouse;
use App\Models\WarehouseInvoice;
use App\Models\WarehouseInvoiceItem;
use App\Models\WarehouseMovement;
use App\Presenters\WarehouseInvoicePresenter;
use App\Repositories\WarehouseInvoice\WarehouseInvoiceRepository;
use App\Transformers\WarehouseInvoice\WarehouseInvoiceTransformer;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use RuntimeException;
use Throwable;

class WarehouseInvoiceService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, WarehouseInvoiceRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }

    public function all(): array
    {
        return $this->formatData($this->repository->setPresenter(WarehouseInvoicePresenter::class)->orderBy('id','desc')->paginate(),'warehouse_invoices');
    }

    public function show(WarehouseInvoice $color): array
    {
        $fractal = new Manager();
        $resource = new Item($color, new WarehouseInvoiceTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'warehouse_invoice');
    }

    /**
     */
    public function create($data): array
    {
        try{
            $this->beginTransaction();

            $invoice =  $this->repository->create([
                'branch_id' => $data['branch_id'],
                'user_id' => auth('api')->user()?->id,
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
    public function update(WarehouseInvoice $invoice, $data): array
    {

        try{
            $this->beginTransaction();

            $invoice->update([
                'branch_id' => $data['branch_id'],
            ]);

            $invoice->items()->delete();

            $updated_data = $this->updateItems($invoice, $data);

            $this->commit();

            return $this->show($updated_data);


        }catch (Throwable $e){
            throw new RuntimeException($e->getMessage());
        }



    }


    public function reject(WarehouseInvoice $invoice): array
    {
        $invoice->update([
           'status' => InvoiceEnum::REJECTED
        ]);

        return $this->show($invoice);
    }

    /**
     * @throws Exception|Throwable
     */
    public function confirm(WarehouseInvoice $invoice): array
    {

        try{
            $this->beginTransaction();

            $invoice->update([
                'status' => InvoiceEnum::CONFIRMED
            ]);


            foreach ($invoice->items as $item) {
                $stock = Stock::where([
                    'product_id' => $item->product_id,
                    'arrival_price' => $item->arrival_price,
                    'price' => $item->price,
                    'date_expire' => Carbon::parse($item->date_expire)->endOfDay()->format('Y-m-d H:i:s'),
                ])->first();

                $last_count = ($stock->quantity - $item->quantity);

               throw_if($last_count < 0, static function (){
                    return new RuntimeException('Не достаточно к-во');
               });

                $stock->update([
                    'quantity' => $last_count
                ]);

                StockMovement::create([
                    'stock_id' => $stock->id,
                    'invoice_id' => $invoice->id,
                    'user_id' => auth('api')->user()?->id,
                    'type' => MovementProductType::DEPARTURE,
                    'purchase_price' => $item->arrival_price,
                    'quantity' => $item->quantity,
                    'date_expire' => $item->date_expire,
                    'description' => "Расходная накладная на филиал No $invoice->id - {$invoice->branch->name}"
                ]);


                $warehouse = Warehouse::firstOrCreate([
                    'product_id' => $item->product_id,
                    'arrival_price' => $item->arrival_price,
                    'price' => $item->price,
                    'date_expire' => Carbon::parse($item->date_expire)->endOfDay()->format('Y-m-d H:i:s'),
                    'branch_id' => $invoice->branch_id
                ]);

                $warehouse->update([
                    'quantity' => $warehouse->quantity + $item->quantity
                ]);


                WarehouseMovement::create([
                    'warehouse_id' => $warehouse->id,
                    'branch_id' => $warehouse->branch->id,
                    'invoice_id' => $invoice->id,
                    'user_id' => auth('api')->user()?->id,
                    'type' => MovementProductType::ARRIVAL,
                    'purchase_price' => $item->arrival_price,
                    'quantity' => $item->quantity,
                    'date_expire' => $item->date_expire,
                    'description' => "Приходная накладная на филиал No $invoice->id - {$invoice->branch->name}"
                ]);
            }


            $this->commit();

            return $this->show($invoice);
        }catch (Throwable $e){
            throw new RuntimeException($e->getMessage());
        }
    }

   protected function updateItems(WarehouseInvoice $invoice, $data): WarehouseInvoice
   {
       $sum = 0;



       foreach ( $data['items']  as  $item) {

           $stock = Stock::find($item['stock_id']);


           if($stock->quantity < $item['quantity']){
               throw new RuntimeException('Недостаточно товара по называнию '.$stock->product->name . ". Запрошено " . $item['quantity'] . " , доступно " . $stock->quantity  ) ;
           }


           $sum += $stock->price * $item['quantity'];
           WarehouseInvoiceItem::create([
               'warehouse_invoice_id' => $invoice->id,
               'product_id' => $stock->product_id,
               'quantity' => $item['quantity'],
               'arrival_price' => $stock->arrival_price,
               'price' => $stock->price,
               'date_expire' => Carbon::create($stock->date_expire)?->format('Y-m-d'),
           ]);
       }

       $invoice->update([
           'total_amount' => $sum
       ]);

       return $invoice;
   }

}
