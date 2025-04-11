<?php
namespace App\Services;

use App\Models\User;
use App\Interfaces\UserInterface;
use Illuminate\Database\Eloquent\Builder;

class UserService implements UserInterface
{
    /**
     * @var User
     */
    protected $model;

    /**
     * UserService Constructor
     *
     * Initializes the service with the User model.
     */
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * Retrieve a new query builder for the User model.
     *
     * @return Builder
     */
    public function listUsers(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Create a new user in the database.
     *
     * @param array $data
     *
     * @return User
     */
    public function createUser(array $data): User
    {
        try {
            return $this->model->create($data);
        } catch (\Illuminate\Database\QueryException $th) {
            throw $th;
        }
    }

    /**
     * Find a user by a specific key and value.
     *
     * @param string $key
     * @param string $value
     *
     * @return User
     */
    public function findUser(string $key, string $value): User
    {
        return $this->model->where($key, $value)->first();
    }

    /**
     * Update a user's data by ID.
     *
     * @param array $data
     * @param string $id
     *
     * @return User
     */
    public function updateUser(array $data, string $id): User
    {
        $user = $this->findUser('id', $id);

        try {
            $user->update($data);

            return $this->findUser('id', $id);
        } catch (\Illuminate\Database\QueryException $th) {
            throw $th;
        }
    }

    /**
     * Delete a user by ID.
     *
     * @param string $id
     *
     * @return bool
     */
    public function deleteUser(string $id): bool
    {
        $user = $this->findUser('id', $id);

        return $user->delete();
    }
}
