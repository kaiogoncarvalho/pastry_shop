<?php

namespace Test\Acceptance;

use Illuminate\Http\Response;
use Test\AcceptanceTestCase;

class ClientsTest extends AcceptanceTestCase
{
    /**
     * Test Create Client
     * @covers \App\Http\Controllers\ClientsController::create
     */
    public function testCreate()
    {
        $body = factory('App\Models\Client')->make()->toArray();
        $this->json(
            'POST',
            '/v1/clients',
            $body
        )->seeStatusCode(Response::HTTP_CREATED)
        ->seeInDatabase(
            'clients',
            $body
        );
    }

    /**
     * Test Update Client
     * @covers \App\Http\Controllers\ClientsController::update
     */
    public function testUpdate()
    {
        $client = factory('App\Models\Client')->create();
        $body = factory('App\Models\Client')->make()->toArray();
        $this->json(
            'PATCH',
            '/v1/clients/'.$client->id,
            $body
        )->seeStatusCode(Response::HTTP_OK)
            ->seeInDatabase(
                'clients',
                $body
            );
    }

    /**
     * Test Create Client
     * @covers \App\Http\Controllers\ClientsController::get
     */
    public function testGet()
    {
        $client = factory('App\Models\Client')->create();
        $this->json(
            'GET',
            '/v1/clients/'.$client->id
        )->seeStatusCode(Response::HTTP_OK)
            ->seeJson($client->toArray());
    }


    /**
     * Test Create Get All
     * @covers \App\Http\Controllers\ClientsController::getAll
     */
    public function testGetAll()
    {
        $client = factory('App\Models\Client')->create();
        $this->json(
            'GET',
            '/v1/clients'
        )->seeStatusCode(Response::HTTP_OK);

        $response = json_decode($this->response->getContent(), true);
        $this->assertEquals($response['data'][0], $client->toArray());
    }

    /**
     * Test Create Get All Paginate
     * @covers \App\Http\Controllers\ClientsController::getAll
     */
    public function testGetAllPaginate()
    {
        factory('App\Models\Client')->times(30)->create();
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
     * Test Delete Client
     * @covers \App\Http\Controllers\ClientsController::delete
     */
    public function testDelete()
    {
        $client = factory('App\Models\Client')->create();
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
