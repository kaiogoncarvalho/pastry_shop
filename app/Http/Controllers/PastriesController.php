<?php

namespace App\Http\Controllers;


use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Rules\Double;
use App\Services\PastriesService;

class PastriesController extends Controller
{

    /**
     * @param Request $request
     * @param PastriesService $pastriesService
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function create(Request $request, PastriesService $pastriesService)
    {
        $rules = [
            "name"         => "required|string|min:1|max:100",
            "price"        => [
                'required',
                 new Double(10,2)
            ],
            "photo"        => "required|image"
        ];

        $this->validate($request, $rules);

        $pastry = $pastriesService->create($request->all(['name', 'price']), $request->file('photo'));

        return new JsonResponse($pastry->toArray(), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param PastriesService $pastriesService
     * @param $id
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function update(Request $request, PastriesService $pastriesService, $id)
    {
        $rules = [
            "name"         => [
                'min:3',
                'max:100',
            ],
            "price"        => [
                new Double(10,2)

            ],
            "photo"        => "image"
        ];

        $this->validate($request, $rules);

        $pastry = $pastriesService->update($id, $request->all(['name', 'price']), $request->file('photo'));

        return new JsonResponse($pastry->toArray(), Response::HTTP_OK);
    }

    /**
     * @param PastriesService $pastriesService
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function get(PastriesService $pastriesService, $id)
    {
        $pastry = $pastriesService->get($id);
        return new JsonResponse($pastry, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param PastriesService $pastriesService
     * @return JsonResponse
     */
    public function getAll(Request $request, PastriesService $pastriesService)
    {
        $pastries = $pastriesService->getAll($request->all());

        return new JsonResponse($pastries, Response::HTTP_OK);
    }

    /**
     * @param PastriesService $pastriesService
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(PastriesService $pastriesService, $id)
    {
        $pastriesService->delete($id);
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param PastriesService $pastriesService
     * @param $id
     * @return mixed
     */
    public function getPhoto(PastriesService $pastriesService, $id)
    {
        return $pastriesService->getPhoto($id);
    }
}
