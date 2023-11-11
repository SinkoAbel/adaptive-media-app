<?php

namespace App\Http\Controllers;

use App\Exceptions\TodoException;
use App\Http\Requests\TodoRequest;
use App\Services\TodoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;


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
     *
     * @OA\Get(
     *       path="/api/items",
     *       operationId="getAllTodoItems",
     *       tags={"Todo items"},
     *       summary="Get paginated todo items.",
     *       description="Returns json with paginated items.",
     *       @OA\Response(
     *           response=200,
     *           description="Successful",
     *       )
     * )
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
     *
     * @OA\Get(
     *       path="/api/items/{id}",
     *       operationId="getTodoItemsById",
     *       tags={"Todo items"},
     *       summary="Get a todo item by id.",
     *       description="Returns an item.",
     *       @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="The id of the todo item",
     *           @OA\Schema(type="integer")
     *       ),
     *       @OA\Response(
     *           response=200,
     *           description="Successful operation",
     *           @OA\JsonContent(ref="#/components/schemas/Todo")
     *       ),
     *       @OA\Response(
     *            response=400,
     *            description="Bad request",
     *            @OA\JsonContent(
     *                type="object",
     *                @OA\Property(property="status", type="number", example="400"),
     *                @OA\Property(property="error_message", type="string", example="Path variable type is invalid"),
     *            )
     *       ),
     *       @OA\Response(
     *           response=404,
     *           description="Not found",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(property="status", type="number", example="404"),
     *               @OA\Property(property="error_message", type="string", example="Todo item was not found"),
     *           )
     *       ),
     * )
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
     *
     * @OA\Post(
     *     path="/api/items",
     *     operationId="createTodoItem",
     *     tags={"Todo items"},
     *     summary="Create new todo item.",
     *     description="Returns the newly created item.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for post request.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="My new todo"),
     *             @OA\Property(property="description", type="string", example="This is a short description."),
     *             @OA\Property(property="completed", type="boolean", example="0"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/Todo")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="number", example="400"),
     *             @OA\Property(property="error_message", type="string", example="Request body is invalid! Fields or it's values are possibly incorrect!"),
     *         )
     *     ),
     * )
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
     *
     * @OA\Put(
     *     path="/api/items/{id}",
     *     operationId="updateTodoItem",
     *     tags={"Todo items"},
     *     summary="Update a todo item.",
     *     description="Returns the updated item.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id of the todo item",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for post request.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="My new todo"),
     *             @OA\Property(property="description", type="string", example="This is a short description."),
     *             @OA\Property(property="completed", type="boolean", example="0"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/Todo")
     *     ),
     *     @OA\Response(
     *         response=422
     *         description="Bad request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="number", example="400"),
     *             @OA\Property(property="error_message", type="string", example="Request body is invalid! Fields or it's values are possibly incorrect!"),
     *         )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="status", type="number", example="400"),
     *              @OA\Property(property="error_message", type="string", example="Path variable type is invalid"),
     *          )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="number", example="404"),
     *             @OA\Property(property="error_message", type="string", example="Todo item was not found"),
     *         )
     *     )
     * )
     *
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
     * @throws TodoException
     *
     * @OA\Delete(
     *     path="/api/items/{id}",
     *     operationId="deleteTodoItem",
     *     tags={"Todo items"},
     *     summary="Delete a todo item.",
     *     description="Returns 204 status code on successful delete.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id of the todo item",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No content",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="number", example="400"),
     *             @OA\Property(property="error_message", type="string", example="Path variable type is invalid"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="number", example="404"),
     *             @OA\Property(property="error_message", type="string", example="Todo item was not found"),
     *         )
     *     )
     * )
     *
     */
    public function destroy($id): JsonResponse
    {
        if (!is_numeric($id))
            throw TodoException::invalidPathVariableException();

        return response()->json(
            $this->service->deleteTodoItem($id),
            204
        );
    }
}
