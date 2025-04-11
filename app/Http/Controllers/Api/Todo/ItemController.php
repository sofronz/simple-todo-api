<?php

namespace App\Http\Controllers\Api\Todo;

use App\Enum\ItemStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\ItemRequest;
use App\Http\Resources\Todo\ItemResource;
use App\Http\Resources\Todo\ListResource;
use App\Interfaces\TodoInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * 
     * @param ItemRequest $request
     * @param int $list_id
     * 
     * @return ListResource
     */
    public function store(ItemRequest $request, int $list_id)
    {
        $data = $request->fieldInputs();
        $todo = app(TodoInterface::class)->findTodo('id', $list_id);
        $todo->items()->create(
            array_merge(
                [
                    'list_id' => $todo->id
                ],
                $data
            )
        );

        return new ListResource($todo);
    }

    /**
     * Display the specified resource.
     * 
     * @param int $list_id
     * @param int $id
     * 
     * @return ItemResource
     */
    public function show(int $list_id, int $id)
    {
        $todo = app(TodoInterface::class)->findTodo('id', $list_id);
        $todoItem = $todo->items()->where('id', $id)->first();

        return new ItemResource($todoItem);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Request $request
     * @param int $id
     * 
     * @return ListResource
     */
    public function update(Request $request, int $list_id, int $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'status' => ['required', new Enum(ItemStatus::class)]
        ]);

        $todo = app(TodoInterface::class)->findTodo('id', $list_id);
        $todoItem = $todo->items()->where('id', $id)->first();
        $todoItem->update($request->input());

        return new ItemResource($todo);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $list_id
     * @param int $id
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $list_id, int $id)
    {
        $todo = app(TodoInterface::class)->findTodo('id', $list_id);
        $todo->items()->where('id', $id)->delete();

        return response()->json([
            'data' => [
                'message' => 'Todo Item Deleted!',
            ],
        ], 200);
    }
}
