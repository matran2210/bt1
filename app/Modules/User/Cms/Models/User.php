<?php

namespace App\Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Cms\Traits\Filterable;
class User extends Model
{

    use Filterable;

    protected $table = "user";
    protected $fillable = [
        'name', 'email', 'phone',
        'address','admin_group','password','status','is_delete','created_at', 'updated_at'
        ];

    //filterable
    protected  $filterable = [
        'name', 'email', 'phone',
        'address','admin_group','password','status','is_delete','created_at', 'updated_at'
    ];










}
