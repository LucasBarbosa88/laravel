<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Scopes\Search as SearchScope;

class Product extends Authenticatable
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
        'name', 'description', 'price',
    ];

    protected static $logAttributes = [
        'name', 'description'
    ];
}