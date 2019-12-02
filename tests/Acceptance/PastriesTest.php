<?php

namespace Test\Acceptance;

use Illuminate\Http\Response;
use Test\TestCase;
use Illuminate\Http\UploadedFile;

class PastriesTest extends TestCase
{
    /**
     * Test Create Pastry
     * @covers \App\Http\Controllers\PastriesController::create
     */
    public function testCreate()
    {
        $body = factory('App\Models\Pastry')->make();
        $this->call(
            'POST',
            '/v1/pastries',
            [
                'name' => $body->name,
                'price' => $body->price,
            ],
            [],
            ['photo' => UploadedFile::fake()->image($body['photo'])]
        )->send();



        $statusCode = $this->response->getStatusCode();
        $this->assertEquals($statusCode, Response::HTTP_CREATED);

        $response = json_decode($this->response->getContent(), true);
        $this->assertEquals($response['name'], $body->name);
        $this->assertEquals($response['price'], $body->price);
        $this->assertEquals($response['photo'], $body->photo);
    }

    /**
     * Test Update Pastry
     * @covers \App\Http\Controllers\PastriesController::update
     */
    public function testUpdate()
    {
        $pastry = factory('App\Models\Pastry')->create();
        $body = factory('App\Models\Pastry')->make();
        $this->call(
            'POST',
            '/v1/pastries/'.$pastry->id,
            [
                'name' => $body->name,
                'price' => $body->price,
            ],
            [],
            ['photo' => UploadedFile::fake()->image($body['photo'])]
        )->send();

        $statusCode = $this->response->getStatusCode();
        $this->assertEquals($statusCode, Response::HTTP_OK, $this->response->getContent());

        $response = json_decode($this->response->getContent(), true);
        $this->assertEquals($response['name'], $body->name);
        $this->assertEquals($response['price'], $body->price);
        $this->assertEquals($response['photo'], $body->photo);
    }

    /**
     * Test Create Pastry
     * @covers \App\Http\Controllers\PastriesController::get
     */
    public function testGet()
    {
        $pastry = factory('App\Models\Pastry')->create();
        $this->json(
            'GET',
            '/v1/pastries/'.$pastry->id
        )->seeStatusCode(Response::HTTP_OK)
            ->seeJson($pastry->toArray());
    }


    /**
     * Test Create Get All
     * @covers \App\Http\Controllers\PastriesController::getAll
     */
    public function testGetAll()
    {
        $pastry = factory('App\Models\Pastry')->create();
        $this->json(
            'GET',
            '/v1/pastries'
        )->seeStatusCode(Response::HTTP_OK);

        $response = json_decode($this->response->getContent(), true);
        $this->assertEquals($response['data'][0], $pastry->toArray());
    }

    /**
     * Test Create Get All Paginate
     * @covers \App\Http\Controllers\PastriesController::getAll
     */
    public function testGetAllPaginate()
    {
        factory('App\Models\Pastry')->times(30)->create();
        $this->json(
            'GET',
            '/v1/pastries?page=2&perPage=5'
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
     * Test Delete Pastry
     * @covers \App\Http\Controllers\PastriesController::delete
     */
    public function testDelete()
    {
        $pastry = factory('App\Models\Pastry')->create();
        $this->json(
            'DELETE',
            '/v1/pastries/'.$pastry->id
        )->seeStatusCode(Response::HTTP_NO_CONTENT)
            ->notSeeInDatabase(
                'pastries',
                ['id' => $pastry->id, 'deleted_at' => null]
            );
    }
}
