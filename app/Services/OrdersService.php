<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mails\OrderCreated;

/**
 * Class OrdersService
 * @package App\Services
 */
class OrdersService
{
    /**
     * @var Order
     */
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param array $fields
     * @return Order
     */
    public function create(array $fields)
    {
        DB::beginTransaction();
        try{
            /**
             * @var Order $order
             */
            $order = Order::create(['client_id' => $fields['client_id']]);
            $order->pastries()->sync($fields['pastries']);
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        $this->sendEmail($order);

        return $this->get($order->id);
    }

    public function sendEmail(Order $order)
    {
        Mail::to('kaiogoncarvalho@icloud.com')->send(new OrderCreated($order));
    }

    /**
     * @param int $id
     * @param array $fields
     */
    public function update(int $id, array $fields)
    {
        DB::beginTransaction();
        try{
            /**
             * @var Order $order
             */
            $order = Order::findOrFail($id);

            if(
                array_key_exists('client_id', $fields)
                && !empty($fields['client_id'])
            ){
                $order->client_id = $fields['client_id'];
            }

            if(
                array_key_exists('pastries', $fields)
                && !empty($fields['pastries'])
            ){
                $order->pastries()->sync($fields['pastries']);
            }

            $order->save();
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->get($id);
    }

    public function getAll(?array $filters)
    {
        $orders = Order::with(['client', 'pastries']);

        return $orders->paginate(
            $filters['perPage'] ?? 10,
            ['*'],
            'page',
            $filters['page'] ?? 1
        );
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function delete(int $id): void
    {
        /**
         * @var Order $order
         */
        $order = Order::findOrFail($id);
        $order->delete();
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function get(int $id)
    {
        /**
         * @var Order $order
         */
        return Order::with(['client', 'pastries'])->findOrFail($id);
    }

}
