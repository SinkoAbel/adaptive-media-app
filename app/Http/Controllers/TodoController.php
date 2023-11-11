<?php

namespace App\Http\Controllers;

use App\Exceptions\TodoException;
use App\Http\Requests\TodoRequest;
use App\Services\TodoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class TodoController extends Controller
{
    private TodoService $service;

    public function __construct(TodoService $service)
    {
        $this->service = $service;
    }


    /**
     * Index function returns a JsonResponse with paginated TODO items
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $this->service->getAllTodoItems($request)
        );
    }

    /**
     * The function returns an item by id.
     * @param int $id
     * @return JsonResponse
     * @throws TodoException
     */
    public function indexById($id): JsonResponse
    {
        if (!is_numeric($id))
            throw TodoException::invalidPathVariableException();

        return response()->json(
            $this->service->getTodoItemById($id)
        );
    }

    /**
     * Store function saves an item in the database.
     * @param TodoRequest $request
     * @return JsonResponse
     */
    public function store(TodoRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->createTodoItem($request),
            201
        );
    }

    /**
     * Update function updates an existing record in the database.
     * @param TodoRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws TodoException
     */
    public function update(TodoRequest $request, $id): JsonResponse
    {
        if (!is_numeric($id))
            throw TodoException::invalidPathVariableException();

        return response()->json(
            $this->service->modifyTodoItem($request, $id),
            201
        );
    }

    /**
     * Destroy function deletes a record in the database.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return response()->json(
            $this->service->deleteTodoItem($id),
            204
        );
    }
}
