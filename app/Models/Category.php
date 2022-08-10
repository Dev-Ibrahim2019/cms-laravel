<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
