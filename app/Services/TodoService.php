<?php

namespace App\Services;

use App\Exceptions\TodoException;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 * Class TodoService.
 * This class is used to manipulate Todo items in the database
 */
class TodoService
{
    private static string $COLUMN_NAME = 'name';
    private static string $COLUMN_DESCRIPTION = 'description';
    private static string $COLUMN_COMPLETED = 'completed';
    private static string $QUERY_PAGE = 'page';
    private static string $QUERY_PER_PAGE = 'per_page';
    private static int $DEFAULT_PAGE_NUMBER = 1;
    private static int $DEFAULT_ITEMS_PER_PAGE = 25;

    /**
     * This function gives back every TODO item from the database.
     * It also handles query params if given.
     * @param Request $request - Request that might contain query params
     * @return LengthAwarePaginator - LengthAwarePaginator of TODO items
     */
    public function getAllTodoItems(Request $request): LengthAwarePaginator
    {
        $query = Todo::query();

        if ($request->has(self::$COLUMN_NAME)) {
            $query->where(self::$COLUMN_NAME, $request->input(self::$COLUMN_NAME));
        }

        if ($request->has(self::$COLUMN_COMPLETED)) {
            $query->where(self::$COLUMN_COMPLETED, $request->input(self::$COLUMN_COMPLETED));
        }

        $page = $request->input(self::$QUERY_PAGE, self::$DEFAULT_PAGE_NUMBER);
        $itemPerPage = $request->input(self::$QUERY_PER_PAGE, self::$DEFAULT_ITEMS_PER_PAGE);

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        return $query->paginate($itemPerPage);
    }

    /**
     * This function returns a single TODO item by id.
     * @param int $id id of TODO item
     * @return Todo - a TODO item
     * @throws TodoException
     */
    public function getTodoItemById(int $id): Todo
    {
        $item = Todo::find($id);

        if ($item == null)
            throw TodoException::itemNotFound();

        return $item;
    }

    /**
     * This function creates a new TODO item in the DB.
     * @param TodoRequest $request - the new TODO item
     * @return Todo - created TODO item
     */
    public function createTodoItem(TodoRequest $request): Todo
    {
        return Todo::create([
            self::$COLUMN_NAME => $request[self::$COLUMN_NAME],
            self::$COLUMN_DESCRIPTION => $request[self::$COLUMN_DESCRIPTION],
            self::$COLUMN_COMPLETED => $request[self::$COLUMN_COMPLETED]
        ]);
    }

    /**
     * This functions modifies a TODO item in the DB by it's id.
     * @param TodoRequest $request modified TODO item
     * @param int $id id of TODO item to modify
     * @return Todo - modified TODO item
     * @throws TodoException
     */
    public function modifyTodoItem(TodoRequest $request, int $id): Todo
    {
        $todoItem = Todo::find($id);

        if ($todoItem == null)
            throw TodoException::itemNotFound();

        $todoItem->update([
            self::$COLUMN_NAME => $request[self::$COLUMN_NAME],
            self::$COLUMN_DESCRIPTION => $request[self::$COLUMN_DESCRIPTION],
            self::$COLUMN_COMPLETED => $request[self::$COLUMN_COMPLETED]
        ]);

        return $todoItem;
    }

    /**
     * This function deletes a TODO item's record from the DB by the provided id.
     * @param int $id TODO item's id
     * @return bool - Returns `true` if delete successful, returns `false` if failed
     * @throws TodoException
     */
    public function deleteTodoItem(int $id): bool
    {
        $todoItem = Todo::find($id);

        if ($todoItem == null)
            throw TodoException::itemNotFound();

        $todoItem->delete();

        return true;
    }
}
