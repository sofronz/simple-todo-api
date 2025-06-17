<?php
namespace App\Http\Controllers\Api\Todo;

use Illuminate\Http\Request;
use App\Builders\Todo\TodoQuery;
use App\Interfaces\TodoInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\ListRequest;
use App\Http\Resources\Todo\ListResource;

class ListController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/checklist",
     *     summary="Get all checklists",
     *     description="Returns a paginated list of checklists. Requires Bearer token.",
     *     operationId="getChecklists",
     *     tags={"Todo(Checklist)"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by checklist name or description",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/Checklist")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $todo = TodoQuery::apply($request)->paginate(10);

        return ListResource::collection($todo);
    }

    /**
     * @OA\Post(
     *     path="/api/checklist",
     *     summary="Create a new checklist",
     *     description="Create a new checklist with name and description. Requires Bearer token.",
     *     operationId="createChecklist",
     *     tags={"Todo(Checklist)"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description"},
     *             @OA\Property(property="name", type="string", example="Daily Tasks"),
     *             @OA\Property(property="description", type="string", example="Tasks for daily routine")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Checklist created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Checklist")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(ListRequest $request)
    {
        $data = $request->fieldInputs();
        $todo = app(TodoInterface::class)->createTodo($data);

        return new ListResource($todo);
    }

    /**
     * @OA\Get(
     *     path="/api/checklist/{id}/item",
     *     summary="Get all checklist item",
     *     description="Retrieve detailed information of a checklist by its ID. Requires Bearer token.",
     *     operationId="getChecklistDetail",
     *     tags={"Todo(ChecklistItem)"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the checklist",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Checklist detail retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Checklist")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Checklist not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function show(int $list_id)
    {
        $todo = app(TodoInterface::class)->findTodo('id', $list_id);

        return new ListResource($todo);
    }

    /**
     * @OA\Put(
     *     path="/api/checklist/{id}",
     *     summary="Update checklist",
     *     description="Update an existing checklist by ID. Requires Bearer token.",
     *     operationId="updateChecklist",
     *     tags={"Todo(Checklist)"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Checklist ID",
     *         required=true,
     *         @OA\Schema(type="string", example="1")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description"},
     *             @OA\Property(property="name", type="string", example="Updated checklist title"),
     *             @OA\Property(property="description", type="string", example="Updated checklist description")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Checklist updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ChecklistItem")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Checklist not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function update(ListRequest $request, string $id)
    {
        $data = $request->fieldInputs();
        $todo = app(TodoInterface::class)->updateTodo($data, $id);

        return new ListResource($todo);
    }

    /**
     * @OA\Delete(
     *     path="/api/checklist/{id}",
     *     summary="Delete checklist",
     *     description="Delete a checklist by its ID. Requires Bearer token.",
     *     operationId="deleteChecklist",
     *     tags={"Todo(Checklist)"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Checklist ID to delete",
     *         required=true,
     *         @OA\Schema(type="string", example="1")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Checklist deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="message", type="string", example="Todo Deleted!")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Checklist not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        app(TodoInterface::class)->deleteTodo($id);

        return response()->json([
            'data' => [
                'message' => 'Todo Deleted!',
            ],
        ], 200);
    }
}
