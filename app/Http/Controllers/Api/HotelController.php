<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use App\Http\Resources\HotelResource;
use App\Services\HotelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HotelController extends Controller
{

    private $hotelService;
    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only('name', 'country', 'city', 'price');
        return response()->json([
            'status' => true,
            'data' => HotelResource::collection($this->hotelService->list($filters, $request->sort_key ?? 'id', $request->sort_method ?? 'asc'))
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param HotelRequest $request
     * @return JsonResponse
     */
    public function store(HotelRequest $request): JsonResponse
    {
        if ($this->hotelService->create($request->only('name', 'country', 'city', 'price'), $request->facilities))
            return response()->json([
                'status' => true,
                'message' => "Hotel Created Successfully",
            ]);

        return response()->json([
            'status' => false,
            'message' => "Some thing went wrong",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => HotelResource::make($this->hotelService->show($id))
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param HotelRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(HotelRequest $request, int $id): JsonResponse
    {
        if ($this->hotelService->update($id, $request->only('name', 'country', 'city', 'price'), $request->facilities))
            return response()->json([
                'status' => true,
                'message' => "Hotel Updated Successfully",
            ]);

        return response()->json([
            'status' => false,
            'message' => "Some thing went wrong",
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->hotelService->delete($id);

        return response()->json([
            'status' => true,
            'message' => "Hotel Deleted Successfully",
        ]);
    }
}
