<?php
namespace App\Services;

use App\Interfaces\todoInterface;
use App\Models\Todo\ListTodo;
use Illuminate\Database\Eloquent\Builder;

class TodoService implements TodoInterface
{
    /**
     * @var ListTodo
     */
    protected $model;

    /**
     * TodoService Constructor
     *
     * Initializes the service with the todo model.
     */
    public function __construct()
    {
        $this->model = new ListTodo();
    }

    /**
     * Retrieve a new query builder for the todo model.
     *
     * @return Builder
     */
    public function listTodo(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Create a new todo in the database.
     *
     * @param array $data
     *
     * @return ListTodo
     */
    public function createTodo(array $data): ListTodo
    {
        try {
            return $this->model->create($data);
        } catch (\Illuminate\Database\QueryException $th) {
            throw $th;
        }
    }

    /**
     * Find a todo by a specific key and value.
     *
     * @param string $key
     * @param string $value
     *
     * @return ListTodo
     */
    public function findTodo(string $key, string $value): ListTodo
    {
        return $this->model->where($key, $value)->first();
    }

    /**
     * Update a todo's data by ID.
     *
     * @param array $data
     * @param string $id
     *
     * @return ListTodo
     */
    public function updateTodo(array $data, string $id): ListTodo
    {
        $todo = $this->findTodo('id', $id);

        try {
            $todo->update($data);

            return $this->findTodo('id', $id);
        } catch (\Illuminate\Database\QueryException $th) {
            throw $th;
        }
    }

    /**
     * Delete a todo by ID.
     *
     * @param string $id
     *
     * @return bool
     */
    public function deleteTodo(string $id): bool
    {
        $todo = $this->findTodo('id', $id);

        return $todo->delete();
    }
}
