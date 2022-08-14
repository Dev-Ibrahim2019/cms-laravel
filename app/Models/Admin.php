<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $appends = ['status']; #for api

    //Append attripute
    //public function get___Attribute()

    public function getStatusAttribute ()
    {
        return $this->active ? "Active" : "Disabled";
    }
}
