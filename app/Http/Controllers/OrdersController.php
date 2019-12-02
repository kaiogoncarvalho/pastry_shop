<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClientsService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\OrdersService;
use App\Services\PastriesService;
use App\Models\Order;
use App\Mails\OrderCreated;

class OrdersController extends Controller
{
    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request, OrdersService $ordersService)
    {
        $rules = [
            "client_id"    => "required|integer|exists:clients,id",
            "pastries"     => "required|array",
            "pastries.*"   => "required|integer|exists:pastries,id"
        ];

        $this->validate($request, $rules);

        $order = $ordersService->create($request->all());

        return new JsonResponse($order, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, OrdersService $ordersService, $id)
    {
        $rules = [
            "client_id"    => "integer|exists:clients,id",
            "pastries"     => "array",
            "pastries.*"   => "integer|exists:pastries,id"
        ];

        $this->validate($request, $rules);

        $order = $ordersService->update($id, $request->all());

        return new JsonResponse($order, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param ClientsService $clientService
     * @return JsonResponse
     */
    public function getAll(Request $request, OrdersService $ordersService)
    {
        $orders = $ordersService->getAll($request->all());

        return new JsonResponse($orders, Response::HTTP_OK);
    }

    /**
     * @param ClientsService $clientService
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(OrdersService $ordersService, $id)
    {
        $ordersService->delete($id);
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param ClientsService $clientService
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function get(OrdersService $ordersService, $id)
    {
        $order = $ordersService->get($id);
        return new JsonResponse($order, Response::HTTP_OK);
    }

    /**
     * @param OrdersService $ordersService
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function sendEmail(OrdersService $ordersService, $id)
    {
        $order = $ordersService->get($id);
        $ordersService->sendEmail($order);
        return new JsonResponse([], Response::HTTP_NO_CONTENT);

    }
}
