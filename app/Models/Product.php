<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\Search as SearchScope;

class Product extends Model
{
    use Notifiable, HasRoles, LogsActivity, SearchScope;

    /**
     * The attributes that are used to search.
     *
     * @var array
     */
    protected $searchBy = [
        'name', 'description',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'sku'
    ];

    protected static $logAttributes = [
        'name', 'description'
    ];
}
