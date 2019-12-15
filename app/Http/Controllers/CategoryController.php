<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Concerns\Authorizable;
use Illuminate\Http\JsonResponse;
use App\Presenters\CategoryPresenter;
use App\Repositories\CategoryRepository;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Controllers\Interfaces\CategoryInterface;

/**
 * Class CategoryController.
 */
class CategoryController extends Controller implements CategoryInterface
{
    use Authorizable;

    /**
     * @var CategoryRepository
     */
    protected $repository;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->setPresenter(CategoryPresenter::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->has('limit')) {
            $this->setPagination($request->get('limit'));
        }

        return $this->respond($this->repository->paginate($this->getPagination()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryCreateRequest $request
     *
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function store(CategoryCreateRequest $request): JsonResponse
    {
        $data = $request->all();
        $data['user_id'] = $request->user('api')->id;

        return $this->respond($this->repository->create($data));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return $this->respond($this->repository->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param string $id
     *
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function update(CategoryUpdateRequest $request, $id): JsonResponse
    {
        return $this->respond($this->repository->update($request->all(), $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return int
     */
    public function destroy($id): int
    {
        return $this->repository->delete($id);
    }
}
