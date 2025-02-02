<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuideRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Guide;
use App\Models\Manual;
use App\Repositories\GuideRepository;
use App\Repositories\MenuRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuideController extends Controller
{
    protected $guideRepository;

    public function __construct(GuideRepository $guideRepository, MenuRepository $menuRepository)
    {
        parent::__construct($menuRepository);
        $this->guideRepository = $guideRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $guides = $this->guideRepository->getAllWithPaginate(10);
            $response = new ApiResponse(Response::HTTP_OK, 'Listagem de guias realizada.', $this->menu);
            return $response->toResponse($guides);
        } catch (\Exception $e) {
            $response = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $response->toResponse([]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuideRequest $request)
    {
        try {
            $guideCreated = $this->guideRepository->save($request->all());
            $response = new ApiResponse(Response::HTTP_CREATED, 'Guide created successfully.');
            return $response->toResponse($guideCreated);
        } catch (\Exception $e) {
            $response = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $response->toResponse([]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Guide $guide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guide $guide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuideRequest $request, Guide $guide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guide $guide)
    {
        //
    }
}
