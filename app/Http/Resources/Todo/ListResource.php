<?php
namespace App\Http\Resources\Todo;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Checklist",
     *     type="object",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="Daily Tasks"),
     *     @OA\Property(property="description", type="string", example="Tasks to complete daily"),
     *     @OA\Property(
     *         property="items",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/ChecklistItem")
     *     ),
     *     @OA\Property(
     *         property="owner",
     *         ref="#/components/schemas/User"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'items'       => ItemResource::collection($this->items),
            'owner'       => new UserResource($this->user),
        ];
    }
}
