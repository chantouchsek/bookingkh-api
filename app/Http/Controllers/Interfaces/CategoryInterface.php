<?php

namespace App\Http\Controllers\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;

interface CategoryInterface
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse;

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryCreateRequest $request
     * @return JsonResponse
     */
    public function store(CategoryCreateRequest $request): JsonResponse;

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse;

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(CategoryUpdateRequest $request, string $id): JsonResponse;

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return int
     */
    public function destroy(string $id): int;
}
