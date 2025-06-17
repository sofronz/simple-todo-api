<?php
namespace App\Http\Resources\Todo;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="ChecklistItem",
     *     type="object",
     *     title="Checklist Item",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="Buy groceries"),
     *     @OA\Property(property="description", type="string", example="Things to buy at the market"),
     *     @OA\Property(property="status", type="string", example="ONGOING")
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'status'      => $this->status,
        ];
    }
}
