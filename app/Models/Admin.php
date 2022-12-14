<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;

    // protected $appends = ['status']; #for api

    //Append attripute
    //public function get___Attribute()

    public function getStatusKeywordAttribute ()
    {
        return $this->active ? "Active" : "Disabled";
    }
}
