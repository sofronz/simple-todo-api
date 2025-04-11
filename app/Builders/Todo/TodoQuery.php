<?php
namespace App\Builders\Todo;

use Illuminate\Http\Request;
use App\Interfaces\Builder\Query;
use App\Interfaces\UserInterface;
use App\Builders\User\Filters\Age;
use App\Builders\User\Filters\Search;
use App\Interfaces\TodoInterface;
use Illuminate\Database\Eloquent\Builder;

class TodoQuery implements Query
{
    /**
     * Apply filters and conditions to the todo query based on the provided request.
     *
     * @param Request $request
     *
     * @return Builder
     */
    public static function apply(Request $request): Builder
    {
        $query = app(TodoInterface::class)->listTodo();

        if ($request->has('search')) {
            $query = Search::apply($query, $request->get('search'));
        }

        return $query;
    }
}
