<?php

namespace App\Modules\User\Cms\Models;
use App\Modules\User\Cms\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
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
