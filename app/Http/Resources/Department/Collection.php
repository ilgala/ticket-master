<?php

namespace App\Http\Resources\Department;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Collection extends ResourceCollection
{
    public $collects = Model::class;
}
