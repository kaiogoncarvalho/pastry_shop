<?php


namespace App\Http\Controllers;


use App\Services\ClientsService;
use Illuminate\Http\Request;

interface CrudController
{
    /**
     * @param Request $request
     * @param ClientsService $clientService
     * @return mixed
     */
    public function create(Request $request, ClientsService $clientService);
    /**
     * @param Request $request
     * @param ClientsService $clientService
     * @param $id
     * @return mixed
     */
    public function update(Request $request, ClientsService $clientService, $id);

    /**
     * @param ClientsService $clientService
     * @param $id
     * @return mixed
     */
    public function get(ClientsService $clientService, $id);

    /**
     * @param Request $request
     * @param ClientsService $clientService
     * @return mixed
     */
    public function getAll(Request $request, ClientsService $clientService);

    /**
     * @param ClientsService $clientService
     * @param $id
     * @return mixed
     */
    public function delete(ClientsService $clientService, $id);
}
