<?php
namespace App\Http\Controllers\Api\Todo;

use App\Enum\ItemStatus;
use Illuminate\Http\Request;
use App\Interfaces\TodoInterface;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Enum;
use App\Http\Requests\Todo\ItemRequest;
use App\Http\Resources\Todo\ItemResource;
use App\Http\Resources\Todo\ListResource;

class ItemController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/checklist/{list_id}/item",
     *     summary="Add new item to checklist",
     *     description="Create a new checklist item under the specified checklist. Requires Bearer token.",
     *     operationId="addChecklistItem",
     *     tags={"Todo(ChecklistItem)"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="list_id",
     *         in="path",
     *         description="Checklist ID to which the item will be added",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "status"},
     *             @OA\Property(property="name", type="string", example="Buy milk"),
     *             @OA\Property(property="description", type="string", example="Buy milk Description")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Item added successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Checklist")
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Checklist not found"
     *     )
     * )
     */
    public function store(ItemRequest $request, int $list_id)
    {
        $data = $request->fieldInputs();
        $todo = app(TodoInterface::class)->findTodo('id', $list_id);
        $todo->items()->create(
            array_merge(
                [
                    'list_id' => $todo->id,
                ],
                $data
            )
        );

        return new ListResource($todo);
    }

    /**
     * @OA\Get(
     *     path="/api/checklist/{list_id}/item/{id}",
     *     summary="Get checklist item detail",
     *     description="Retrieve detailed information of a checklist item under the specified checklist. Requires Bearer token.",
     *     operationId="getChecklistItemDetail",
     *     tags={"Todo(ChecklistItem)"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="list_id",
     *         in="path",
     *         required=true,
     *         description="Checklist ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Checklist Item ID",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Item detail retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ChecklistItem")
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Item or checklist not found"
     *     )
     * )
     */
    public function show(int $list_id, int $id)
    {
        $todo     = app(TodoInterface::class)->findTodo('id', $list_id);
        $todoItem = $todo->items()->where('id', $id)->first();

        return new ItemResource($todoItem);
    }

    /**
     * @OA\Put(
     *     path="/api/checklist/{list_id}/item/{id}",
     *     summary="Update checklist item",
     *     description="Update a specific item under a checklist. Requires Bearer token.",
     *     operationId="updateChecklistItem",
     *     tags={"Todo(ChecklistItem)"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="list_id",
     *         in="path",
     *         required=true,
     *         description="Checklist ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Checklist Item ID",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "status"},
     *             @OA\Property(property="name", type="string", example="Update task name"),
     *             @OA\Property(property="description", type="string", nullable=true, example="Optional description"),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 enum={"ONGOING", "COMPLETED"},
     *                 example="COMPLETED"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Checklist item updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ChecklistItem")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Checklist or item not found"
     *     )
     * )
     */
    public function update(Request $request, int $list_id, int $id)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'nullable',
            'status'      => ['required', new Enum(ItemStatus::class)],
        ]);

        $todo     = app(TodoInterface::class)->findTodo('id', $list_id);
        $todoItem = $todo->items()->where('id', $id)->first();
        $todoItem->update([
            'name'   => $request->name,
            'status' => $request->status,
        ]);

        return new ItemResource($todoItem);
    }

    /**
     * @OA\Delete(
     *     path="/api/checklist/{list_id}/item/{id}",
     *     summary="Delete a checklist item",
     *     description="Delete a specific item from a checklist. Requires Bearer token.",
     *     operationId="deleteChecklistItem",
     *     tags={"Todo(ChecklistItem)"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="list_id",
     *         in="path",
     *         required=true,
     *         description="Checklist ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Checklist Item ID",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Checklist item deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="message", type="string", example="Todo Item Deleted!")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Checklist or item not found"
     *     )
     * )
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
