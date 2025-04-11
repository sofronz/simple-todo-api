<?php
namespace App\Models\Todo;

use App\Enum\ItemStatus;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * @var string
     */
    protected $table = 'td_list_items';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status'   => ItemStatus::class,
    ];

    /**
     * @return [type]
     */
    public function list()
    {
        return $this->belongsTo(Item::class, 'list_id', 'id');
    }
}
