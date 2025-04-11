<?php
namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface UserInterface
{
    public function listUsers(): Builder;

    public function createUser(array $data): User;

    public function findUser(string $key, string $value): User;

    public function updateUser(array $data, string $id): User;

    public function deleteUser(string $id): bool;
}
