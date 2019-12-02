<?php

namespace Test\Acceptance;

use Illuminate\Http\Response;
use Test\TestCase;

class OrdersTest extends TestCase
{
    /**
     * Test Create Order
     * @covers \App\Http\Controllers\OrdersController::create
     */
    public function testCreate()
    {
        $client = factory('App\Models\Client')->create();
        $pastries = factory('App\Models\Pastry')->times(3)->create()->toArray();
        $this->json(
            'POST',
            '/v1/orders',
            [
                'client_id' => $client->id,
                'pastries'  => [
                    $pastries[0]['id'],
                    $pastries[1]['id'],
                    $pastries[2]['id'],
                ]
            ]
        )->seeStatusCode(Response::HTTP_CREATED);

        $response = json_decode($this->response->getContent(), true);


        $this->seeInDatabase(
            'orders',
            ['client_id' => $client->id, 'id' => $response['id']]
        );

        $this->seeInDatabase(
            'orders_pastries',
            ['pastry_id' => $pastries[0]['id'], 'order_id' => $response['id']]
        );

        $this->seeInDatabase(
            'orders_pastries',
            ['pastry_id' => $pastries[1]['id'], 'order_id' => $response['id']]
        );

        $this->seeInDatabase(
            'orders_pastries',
            ['pastry_id' => $pastries[2]['id'], 'order_id' => $response['id']]
        );
    }

    /**
     * Test Update Order
     * @covers \App\Http\Controllers\OrdersController::update
     */
    public function testUpdate()
    {
        $order = factory('App\Models\Order')->create();
        $oldClientId = $order->client_id;
        $oldPastries = factory('App\Models\Pastry')->times(3)->create()->toArray();
        $order->pastries()->sync([
            $oldPastries[0]['id'],
            $oldPastries[1]['id'],
            $oldPastries[2]['id'],
        ]);

        $client = factory('App\Models\Client')->create();
        $pastries = factory('App\Models\Pastry')->times(3)->create()->toArray();
        $this->json(
            'PATCH',
            '/v1/orders/'.$order->id,
            [
                'client_id' => $client->id,
                'pastries'  => [
                    $pastries[0]['id'],
                    $pastries[1]['id'],
                    $pastries[2]['id'],
                ]
            ]
        )->seeStatusCode(Response::HTTP_OK);

        $response = json_decode($this->response->getContent(), true);


        $this->seeInDatabase(
            'orders',
            ['client_id' => $client->id, 'id' => $response['id']]
        );

        $this->seeInDatabase(
            'orders_pastries',
            ['pastry_id' => $pastries[0]['id'], 'order_id' => $response['id']]
        );

        $this->seeInDatabase(
            'orders_pastries',
            ['pastry_id' => $pastries[1]['id'], 'order_id' => $response['id']]
        );

        $this->seeInDatabase(
            'orders_pastries',
            ['pastry_id' => $pastries[2]['id'], 'order_id' => $response['id']]
        );

        $this->notSeeInDatabase(
            'orders',
            ['client_id' => $oldClientId, 'id' => $response['id']]
        );

        $this->notSeeInDatabase(
            'orders_pastries',
            ['pastry_id' => $oldPastries[0]['id'], 'order_id' => $response['id']]
        );

        $this->notSeeInDatabase(
            'orders_pastries',
            ['pastry_id' => $oldPastries[1]['id'], 'order_id' => $response['id']]
        );

        $this->notSeeInDatabase(
            'orders_pastries',
            ['pastry_id' => $oldPastries[2]['id'], 'order_id' => $response['id']]
        );
    }

    /**
     * Test Create Order
     * @covers \App\Http\Controllers\OrdersController::get
     */
    public function testGet()
    {
        $order = factory('App\Models\Order')->create();
        $pastries = factory('App\Models\Pastry')->create()->toArray();
        $order->pastries()->sync([
            $pastries['id'],
        ]);
        $this->json(
            'GET',
            '/v1/orders/'.$order->id
        )->seeStatusCode(Response::HTTP_OK);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals($order->id, $response['id']);
        $this->assertEquals($order->client_id, $response['client_id']);
        $this->assertEquals($pastries['id'], $response['pastries'][0]['id']);
    }


    /**
     * Test Create Get All
     * @covers \App\Http\Controllers\OrdersController::getAll
     */
    public function testGetAll()
    {
        $order = factory('App\Models\Order')->create();
        $pastries = factory('App\Models\Pastry')->create()->toArray();
        $order->pastries()->sync([
            $pastries['id'],
        ]);
        $this->json(
            'GET',
            '/v1/orders'
        )->seeStatusCode(Response::HTTP_OK);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals($order->id, $response['data'][0]['id']);
        $this->assertEquals($order->client_id, $response['data'][0]['client_id']);
        $this->assertEquals($pastries['id'], $response['data'][0]['pastries'][0]['id']);
    }

    /**
     * Test Create Get All Paginate
     * @covers \App\Http\Controllers\OrdersController::getAll
     */
    public function testGetAllPaginate()
    {
        factory('App\Models\Order')->times(30)->create();
        $this->json(
            'GET',
            '/v1/clients?page=2&perPage=5'
        )->seeStatusCode(Response::HTTP_OK);

        $response = json_decode($this->response->getContent(), true);
        $this->assertCount(5, $response['data']);
        $this->assertEquals(2, $response['current_page']);
        $this->assertEquals(6, $response['from']);
        $this->assertEquals(6, $response['last_page']);
        $this->assertEquals(10, $response['to']);
        $this->assertEquals(30, $response['total']);
    }

    /**
     * Test Delete Order
     * @covers \App\Http\Controllers\OrdersController::delete
     */
    public function testDelete()
    {
        $client = factory('App\Models\Order')->create();
        $this->json(
            'DELETE',
            '/v1/clients/'.$client->id
        )->seeStatusCode(Response::HTTP_NO_CONTENT)
            ->notSeeInDatabase(
                'clients',
                ['id' => $client->id, 'deleted_at' => null]
            );
    }
}
