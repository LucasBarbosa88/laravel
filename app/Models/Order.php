<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Scopes\Search as SearchScope;
class Order extends Model
{
    use LogsActivity, SearchScope;

    /**
     * The attributes that are used to search.
     *
     * @var array
     */
    protected $searchBy = [
        'client_name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_name', 'total_price', 'products_list'
    ];

    protected static $logAttributes = [
        'client_name'
    ];
}
