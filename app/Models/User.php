<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

use App\Scopes\Search as SearchScope;

class User extends Model implements Authenticatable
{
    use AuthenticableTrait;
    // use Notifiable, HasRoles, LogsActivity, SearchScope;

    /**
     * The attributes that are used to search.
     *
     * @var array
     */
    protected $searchBy = [
        'name', 'email',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected static $logAttributes = [
        'name', 'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
