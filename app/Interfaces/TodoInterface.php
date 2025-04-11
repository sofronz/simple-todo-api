<?php
namespace App\Interfaces;

use App\Models\Todo\ListTodo;
use Illuminate\Database\Eloquent\Builder;

interface TodoInterface
{
    public function listTodo(): Builder;

    public function createTodo(array $data): ListTodo;

    public function findTodo(string $key, string $value): ListTodo;

    public function updateTodo(array $data, string $id): ListTodo;

    public function deleteTodo(string $id): bool;
}
