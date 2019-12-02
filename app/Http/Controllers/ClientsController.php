<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClientsService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Laravel\Lumen\Routing\Controller;

class ClientsController extends Controller
{
    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request, ClientsService $clientService)
    {
        $rules = [
            "name"         => "required|string|min:3|max:100",
            "email"        => "required|email|max:150|unique:clients",
            "phone"        => "required|digits_between:10,11|numeric",
            "birthdate"    => "required|date|before:now",
            "address"      => "required|string|min:3|max:255",
            "complement"   => "max:100",
            "neighborhood" => "required|min:3|max:255",
            "postcode"     => "required|numeric|digits:8"
        ];

        $this->validate($request, $rules);

        $client = $clientService->create(
            $request->all(
                array_keys($rules)
            )
        );

        return new JsonResponse($client->toArray(), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, ClientsService $clientService, $id)
    {
        $rules = [
            "name"         => "string|min:3|max:100",
            "email"        => [
                'email',
                'max:100',
                Rule::unique('clients')->ignore($id)
            ],
            "phone"        => "digits_between:10,11|numeric",
            "birthdate"    => "date|before:now",
            "address"      => "string|min:3|max:255",
            "complement"   => "max:100",
            "neighborhood" => "min:3|max:255",
            "postcode"     => "numeric|digits:8"
        ];

        $this->validate($request, $rules);

        $client = $clientService->update(
            $id,
            $request->all()
        );

        return new JsonResponse($client->toArray(), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param ClientsService $clientService
     * @return JsonResponse
     */
    public function getAll(Request $request, ClientsService $clientService)
    {
        $clients = $clientService->getAll($request->all());

        return new JsonResponse($clients, Response::HTTP_OK);
    }

    /**
     * @param ClientsService $clientService
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(ClientsService $clientService, $id)
    {
        $clientService->delete($id);
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param ClientsService $clientService
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function get(ClientsService $clientService, $id)
    {
        $client = $clientService->get($id);
        return new JsonResponse($client, Response::HTTP_OK);
    }

}
