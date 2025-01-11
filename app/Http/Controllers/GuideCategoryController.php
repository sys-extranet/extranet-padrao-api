<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuideCategoryRequest;
use App\Http\Responses\ApiResponse;
use App\Models\GuideCategory;
use App\Repositories\GuideCategoryRepository;
use Symfony\Component\HttpFoundation\Response;

class GuideCategoryController extends Controller
{
    protected $guideCategoryRepository;

    public function __construct(GuideCategoryRepository $guideCategoryRepository)
    {
        $this->guideCategoryRepository = $guideCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $guideCategories = $this->guideCategoryRepository->all();
            $response = new ApiResponse(Response::HTTP_OK, 'Guide Categories retrieved successfully.');
            return $response->toResponse($guideCategories);
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
    public function store(GuideCategoryRequest $request)
    {
        try {
            $guideCategoryCreated = $this->guideCategoryRepository->save($request->all());
            $response = new ApiResponse(Response::HTTP_CREATED, 'Category Guide created successfully.');
            return $response->toResponse($guideCategoryCreated);
        } catch (\Exception $e) {
            $response = new ApiResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            return $response->toResponse([]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GuideCategoryRequest $guideCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuideCategoryRequest $guideCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuideCategoryRequest $request, GuideCategory $guideCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuideCategory $guideCategory)
    {
        //
    }
}
