<?php

namespace App\Models\Todo;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ListTodo extends Model
{
    /**
     * @var string
     */
    protected $table = 'td_lists';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'description',
    ];

    /**
     * @return [type]
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return [type]
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'list_id', 'id');
    }
}
