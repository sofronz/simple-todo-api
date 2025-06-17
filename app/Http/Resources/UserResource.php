<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="User",
     *     type="object",
     *     title="User",
     *     @OA\Property(property="username", type="string", example="johndoe"),
     *     @OA\Property(property="email", type="string", example="johndoe@example.com")
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'username' => $this->username,
            'email'    => $this->email,
        ];
    }
}
