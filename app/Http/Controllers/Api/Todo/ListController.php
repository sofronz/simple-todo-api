<?php

namespace App\Http\Controllers\Api\Todo;

use App\Builders\Todo\TodoQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\ListRequest;
use App\Http\Resources\Todo\ListResource;
use App\Interfaces\TodoInterface;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $todo = TodoQuery::apply($request)->paginate(10);

        return ListResource::collection($todo);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ListRequest $request
     *
     * @return ListResource
     */
    public function store(ListRequest $request)
    {
        $data = $request->fieldInputs();
        $todo = app(TodoInterface::class)->createTodo($data);

        return new ListResource($todo);
    }

    /**
     * Display the specified resource.
     *
     * @param int $list_id
     *
     * @return ListResource
     */
    public function show(int $list_id)
    {
        $todo = app(TodoInterface::class)->findTodo('id', $list_id);

        return new ListResource($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ListRequest $request
     * @param string $id
     *
     * @return ListResource
     */
    public function update(ListRequest $request, string $id)
    {
        $data = $request->fieldInputs();
        $todo = app(TodoInterface::class)->updateTodo($data, $id);

        return new ListResource($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
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
